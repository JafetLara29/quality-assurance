<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreattachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => ['required'],
            'description' => ['required', 'max:1000']
        ];
    }

    public function messages(){
        return [
            'image.required' => 'Debe seleccionar una imagen',
            'description.required' => 'El input de descripción es requerido',
            'description.max' => 'La descripción no puede ser mayor a :max caracteres.',
        ];
    }
}
