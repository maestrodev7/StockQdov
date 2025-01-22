<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
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
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'date_peremption' => 'nullable|date',
            'type' => 'nullable|string|max:50',
            'quantite' => 'required|integer|min:1',
            'magasin_id' => 'nullable|exists:magasins,id',
            'boutique_id' => 'nullable|exists:boutiques,id',
            'from_magazin' => 'nullable|boolean',
        ];
    }
}
