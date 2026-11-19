<?php

namespace App\Http\Requests;

use App\Services\XssSanitizer;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
        return [
            'course_id' => ['required', 'string', 'max:255', 'unique:courses,course_id'],
            'title'     => ['required', 'string', 'max:255'],
            'capacity'  => ['required', 'integer', 'min:1', 'max:1000'],
            'fee'       => ['required', 'numeric', 'min:0'],
        ];
    }
}
