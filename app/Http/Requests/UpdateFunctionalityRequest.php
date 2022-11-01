<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFunctionalityRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'state' => ['required'],
        ];
    }

    public function messages(){
        return [
            'name.required' => 'El input de nombre es requerido',
            'description.required' => 'El input de descripción es requerido',
            'name.max' => 'El nombre de la funcionalidad no puede ser mayor a :max caracteres.',
            'description.max' => 'La descripción no puede ser mayor a :max caracteres.',
            'state.required' => 'Debe seleccionar un estado de funcionalidad.',
            // 'state.in' => 'Debe seleccionar alguna de las siguientes opciones ":values".',
        ];
    }

}
