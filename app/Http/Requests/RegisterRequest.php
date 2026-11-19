<?php

namespace App\Http\Requests;

use App\Services\XssSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Anyone may register through the public API endpoint.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation by trimming/sanitizing non-secret string fields.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            XssSanitizer::cleanArray(
                $this->only(['name', 'email'])
            )
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(6)],
            'role'     => ['required', 'in:admin,staff'],
        ];
    }
}
