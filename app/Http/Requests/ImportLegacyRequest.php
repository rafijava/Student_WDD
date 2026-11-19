<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportLegacyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'students'          => ['required', 'array'],
            'students.*'        => ['required', 'array'],
            'students.*.name'   => ['sometimes', 'string'],
            'students.*.email'  => ['sometimes', 'string'],
        ];
    }
}
