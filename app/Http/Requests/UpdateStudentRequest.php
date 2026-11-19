<?php

namespace App\Http\Requests;

use App\Services\XssSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name'       => ['sometimes', 'required', 'string', 'max:255'],
            'student_id' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('students', 'student_id')->ignore($id)],
            'department' => ['sometimes', 'required', 'string', 'max:255'],
            'marks'      => ['sometimes', 'nullable', 'numeric', 'min:0', 'max:100'],
            'email'      => ['sometimes', 'required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($id)],
        ];
    }
}
