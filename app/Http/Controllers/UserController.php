<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateInfo(Request $request){
        //obteniene el usuario authenticado atrvez del token que envia en el header del fetch
        $user = $request->user();
        // return response()->json(['message' => $user]);
        $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:users,email,'. $user->id,
        ],[
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'apellidos.string' => 'Los apellidos deben ser una cadena de texto.',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del correo electrónico es incorrecto',
            'email.unique' => 'Este correo electrónico ya está en uso.',
        ]);

        $user->update($request->all());

        return response()->json(['message' => 'Información actualizada']);
    }
    public function updatePassword(Request $request){
        $user = $request->user();

        //La regla de validación 'same' en Laravel se utiliza para verificar si el valor de un campo es el mismo que otro campo en el formulario. 
        $request->validate([
            'password' => 'required',
            'newPassword' => 'required|min:10',
            'newPasswordConfirmation' => 'required|same:newPassword',
        ], [
            'password.required' => 'Ingrese la contraseña actual',
            'newPassword.required' => 'Ingrese la nueva contraseña',
            'newPassword.min' => 'La nueva contraseña debe tener al menos 10 caracteres',
            'newPasswordConfirmation.required' => 'Confirme la nueva contraseña',
            'newPasswordConfirmation.same' => 'Las nuevas contraseñas no coinciden',
        ]);
        

        // Verificar que la contraseña actual sea correcta
        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(
                ['errors' => ['La contraseña actual es incorrecta']
            ], 422);
        }

        // Actualizar la contraseña del usuario
        $user->update([
            'password' => bcrypt($request->input('newPassword')),
        ]);

        return response()->json(['message' => 'Contraseña actualizada']);
    }
}
