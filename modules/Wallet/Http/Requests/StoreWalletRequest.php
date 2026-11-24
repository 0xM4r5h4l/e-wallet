<?php

declare(strict_types=1);

namespace Modules\Wallet\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Wallet\Enums\Currency;

class StoreWalletRequest extends FormRequest
{
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
            'currency' => [
                'required', 'string',
                'max:3', Rule::enum(Currency::class),
                Rule::unique('wallets', 'currency')->where('user_id', $this->user()->id)
            ],
        ];
    }
}
