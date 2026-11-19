<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LegacyStudentAdapterService
{
    /**
     * Map common legacy JSON field names to the target Student schema.
     */
    public function mapRecord(array $legacy): array
    {
        return [
            'name'       => $this->pickValue($legacy, ['name', 'full_name', 'student_name', 'fullName']),
            'student_id' => $this->pickValue($legacy, ['student_id', 'roll', 'roll_number', 'studentId']),
            'department' => $this->pickValue($legacy, ['department', 'dept', 'department_name']),
            'marks'      => $this->numericValue($this->pickValue($legacy, ['marks', 'score', 'gpa', 'grade'])),
            'email'      => $this->pickValue($legacy, ['email', 'mail', 'email_address']),
        ];
    }

    /**
     * Import a collection of legacy records and persist valid students.
     *
     * @return array<string, mixed>
     */
    public function import(Collection $records): array
    {
        $imported = 0;
        $skipped  = [];

        DB::beginTransaction();

        try {
            foreach ($records as $index => $legacy) {
                $data = $this->mapRecord($legacy);

                if (empty($data['name']) || empty($data['student_id']) || empty($data['email'])) {
                    $skipped[$index] = 'Missing required fields after mapping.';
                    continue;
                }

                $data = XssSanitizer::cleanArray($data);

                try {
                    Student::create($data);
                    $imported++;
                } catch (QueryException $e) {
                    if ($this->isDuplicateError($e)) {
                        $skipped[$index] = 'Duplicate student_id or email.';
                    } else {
                        throw $e;
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'legacy' => 'Legacy import failed: '.$e->getMessage(),
            ]);
        }

        return [
            'imported' => $imported,
            'skipped'  => $skipped,
            'total'    => $records->count(),
        ];
    }

    /**
     * Try a list of possible field names and return the first non-empty value.
     */
    protected function pickValue(array $record, array $candidates): ?string
    {
        foreach ($candidates as $key) {
            if (array_key_exists($key, $record) && $record[$key] !== null && $record[$key] !== '') {
                return (string) $record[$key];
            }
        }

        return null;
    }

    protected function numericValue(?string $value): ?float
    {
        if ($value === null) {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return null;
    }

    protected function isDuplicateError(QueryException $e): bool
    {
        $message = $e->getMessage();

        return str_contains($message, '1062 Duplicate entry') ||
               str_contains($message, 'Integrity constraint violation') ||
               str_contains($message, 'unique');
    }
}
