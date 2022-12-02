<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'type' => ['required'],
            'password' => ['max:255'],
            'password_confirmation' => ['max:255'],
        ];

    }
    public function messages()
    {
        return [
            'name.required' => 'Ingrese el nombre del usuario.',
            'email.max' => 'Ingrese el correo electronico.',
            'type.required' => 'Seleccione un tipo de usuario.',
            'name.max' => 'El nombre no puede contener más de :max caracteres.',
            'email.max' => 'El email no puede contener más de :max caracteres.',
            'password.max' => 'La contraseña no puede contener más de :max caracteres.',
        ];
    }
}
