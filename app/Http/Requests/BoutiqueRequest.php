<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoutiqueRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:15',
            'magasin_id' => 'required|exists:magasins,id',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom de la boutique est obligatoire.',
            'magasin_id.required' => 'Le magasin associé est obligatoire.',
            'magasin_id.exists' => 'Le magasin n’existe pas.',
        ];
    }
}

