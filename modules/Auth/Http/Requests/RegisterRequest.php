<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    private const ALLOWED_COUNTRIES = [
        'EG', // Egypt
        'US', // United States
        'CA', // Canada
        'SA', // Saudi Arabia
        'AE', // United Arab Emirates
        'KW', // Kuwait
        'QA', // Qatar
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[A-Za-z]+(?:[\s\'-][A-Za-z]+)*$/'],
            'email' => ['required', 'string', 'lowercase', 'max:255', 'email:rfc,filter,strict,spoof', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->max(255)],
            'mobile_number' => ['required', 'phone:INTERNATIONAL,EG,mobile', 'unique:users,mobile_number'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
            'email' => mb_strtolower(trim((string) $this->input('email'))),
            'mobile_number' => $this->normalizeMobile($this->input('mobile_number'))
        ]);
    }

    protected function normalizeMobile(mixed $value): mixed
    {
        try {
            return phone((string) $value, self::ALLOWED_COUNTRIES)->formatE164();
        } catch (\Throwable) {
            return $value;
        }
    }
}
