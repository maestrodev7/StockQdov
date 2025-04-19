<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
{
    public const TYPE_STORE = 'STORE';
    public const TYPE_SHOP  = 'SHOP';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Adjust as needed (e.g. permissions)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'from_type'  => ['required', 'string', Rule::in([self::TYPE_STORE, self::TYPE_SHOP])],
            'from_id'    => ['required', 'integer', 'min:1'],
            'to_type'    => ['required', 'string', Rule::in([self::TYPE_STORE, self::TYPE_SHOP])],
            'to_id'      => ['required', 'integer', 'min:1'],
            'product_id' => ['required', 'integer', 'min:1'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'from_type.in'  => sprintf(
                'Origin type must be either "%s" or "%s".',
                self::TYPE_STORE,
                self::TYPE_SHOP
            ),
            'to_type.in'    => sprintf(
                'Destination type must be either "%s" or "%s".',
                self::TYPE_STORE,
                self::TYPE_SHOP
            ),
        ];
    }
}
