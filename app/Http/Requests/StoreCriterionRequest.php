<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriterionRequest extends FormRequest
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
            'scenary' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'state' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'scenary.required' => 'El input de escenario es requerido',
            'description.required' => 'El input de descripción es requerido',
            'scenary.max' => 'El escenario no puede ser mayor a :max caracteres.',
            'description.max' => 'La descripción no puede ser mayor a :max caracteres.',
            'state.required' => 'Debe seleccionar un estado.',
        ];
    } 
}
