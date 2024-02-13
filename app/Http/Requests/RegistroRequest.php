<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
        return [
            'nombre' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(10)],
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El Email es obligatorio.',
            'email.email' => 'El Email no tiene el formato adecuado.',
            'email.unique' => 'Este Email ya está registrado.',
            'password.required'=>'El password es obligatorio.',
            'password.confirmed'=>'Las contraseñas no coinsiden.',
            'password.min' => 'El password tiene que tener al menos 10 caracteres.'
        ];
    }

}
