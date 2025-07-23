<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix_achat' => 'required|numeric',
            'prix_vente' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'date_peremption' => 'nullable|date',
            'type' => 'nullable|string|max:50',
            'quantite' => 'required|integer|min:0',
            'magasin_id' => 'nullable|exists:magasins,id',
            'boutique_id' => 'nullable|exists:boutiques,id',
            'from_magazin' => 'nullable|boolean',

            'tailles' => 'nullable|array',
            'tailles.*.taille' => 'required|string|max:50',
            'tailles.*.prix_achat' => 'required|numeric',
            'tailles.*.prix_vente' => 'required|numeric',
            'tailles.*.quantite' => 'required|integer|min:0',
        ];
    }
}
