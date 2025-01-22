<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagasinRequest extends FormRequest
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
            'entreprise_id' => 'required|exists:entreprises,id',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom du magasin est obligatoire.',
            'entreprise_id.required' => "L'entreprise associée est obligatoire.",
            'entreprise_id.exists' => "L'entreprise n'existe pas.",
        ];
    }
}
