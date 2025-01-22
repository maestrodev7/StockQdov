<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseRequest extends FormRequest
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
        $rules =  [
            'logo' => 'nullable|string',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:15',
            'email' => 'nullable|email',
                'site_web' => [
                'nullable',
                'regex:/^(http:\/\/|https:\/\/)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['nom'] = 'required|string|max:255';
        } else if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['nom'] = 'sometimes|string|max:255'; 
        }

        return $rules;
    }
}
