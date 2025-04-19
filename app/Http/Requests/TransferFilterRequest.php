<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferFilterRequest extends FormRequest
{
    public const TYPE_STORE = 'magasins';
    public const TYPE_SHOP  = 'boutiques';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'start_date'  => ['sometimes', 'date', 'date_format:Y-m-d'],
            'end_date'    => ['sometimes', 'date', 'date_format:Y-m-d'],
            'from_type'   => ['sometimes', 'string', Rule::in([self::TYPE_STORE, self::TYPE_SHOP])],
            'from_id'     => ['sometimes', 'integer', 'min:1'],
            'to_type'     => ['sometimes', 'string', Rule::in([self::TYPE_STORE, self::TYPE_SHOP])],
            'to_id'       => ['sometimes', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.date_format' => 'The start_date must be in Y-m-d format.',
            'end_date.date_format'   => 'The end_date must be in Y-m-d format.',
            'from_type.in'           => 'from_type must be "magasins" or "boutiques".',
            'to_type.in'             => 'to_type must be "magasins" or "boutiques".',
        ];
    }
}
