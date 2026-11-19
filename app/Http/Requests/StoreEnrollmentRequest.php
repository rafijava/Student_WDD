<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'course_id'  => ['required', 'integer', 'exists:courses,id'],
            'status'     => ['sometimes', 'string', 'in:enrolled,completed,dropped'],
        ];
    }
}
