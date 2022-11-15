<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModuleRequest extends FormRequest
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
            'module' => ['required', 'max:255'],
            'user_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'module.required' => 'El input de modulo es requerido',
            'module.max' => 'El nombre del módulo no puede ser mayor a :max caracteres.',
            'user_id.required' => 'Debe seleccionar a un usuario encargado del módulo.',
        ];
    }
}
