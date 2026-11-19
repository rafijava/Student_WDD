<?php

namespace App\Http\Requests;

use App\Services\XssSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            XssSanitizer::cleanArray(
                $this->only(['course_id', 'title'])
            )
        );
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'course_id' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('courses', 'course_id')->ignore($id)],
            'title'     => ['sometimes', 'required', 'string', 'max:255'],
            'capacity'  => ['sometimes', 'required', 'integer', 'min:1', 'max:1000'],
            'fee'       => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
