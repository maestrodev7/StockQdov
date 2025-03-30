<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:fournisseurs,id',
            'product_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0'
        ];
    }
}
