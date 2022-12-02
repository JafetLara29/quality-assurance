<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255'],
            'password_confirmation' => ['required', 'max:255'],
            'type' => ['required'],
            
        ];

    }
    public function messages()
    {
        return [
            'name.required' => 'Ingrese el nombre del usuario.',
            'email.max' => 'Ingrese el correo electronico.',
            'password.required' => 'Debe ingresar una contraseña.',
            'password_confirmation.required' => 'Debe ingresar una contraseña de confirmación.',
            'type.required' => 'Seleccione un tipo de usuario.',
            'name.max' => 'El nombre no puede contener más de :max caracteres.',
            'email.max' => 'El email no puede contener más de :max caracteres.',
            'password.max' => 'La contraseña no puede contener más de :max caracteres.',
        ];
    }
}
