<?php

namespace App\Http\Requests;

use App\Services\XssSanitizer;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            XssSanitizer::cleanArray(
                $this->only(['name', 'student_id', 'department', 'email'])
            )
        );
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:255', 'unique:students,student_id'],
            'department' => ['required', 'string', 'max:255'],
            'marks'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:students,email'],
        ];
    }
}
