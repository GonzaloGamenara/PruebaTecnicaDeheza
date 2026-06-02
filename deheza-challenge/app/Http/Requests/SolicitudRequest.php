<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Directamente true porque el path esta protegido directamente por el middelware "AUTH"
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'titulo'       => 'required|string|max:100',
            'descripcion'  => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
        ];

        
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['estado'] = 'required|in:pendiente,en proceso,resuelto';
        }

        return $rules;
    }
}