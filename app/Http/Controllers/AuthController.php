<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegistroRequest $request){
        //validar el registro
        // Al llamar al método validate, este ejecuta el método rules del RegistroRequest.

        // El método rules retorna al frontend un array con errores de acuerdo a la validación definida en dicho método.

        // Si se llega a pasar la validación, entonces la variable $data será un array asociativo que contendrá los datos enviados a través del Request de tipo POST.

        // Es importante destacar que si la validación no pasa, Laravel automáticamente manejará los errores y los devolverá al frontend, lo que detendrá la ejecución del código en el servidor y mostrará los mensajes de error correspondientes en el frontend.

        // dd($request->all());

        $data = $request->validated();

        //Creando el usuario
        $user = User::create([
            'nombre'=> $data['nombre'],
            'apellidos'=> $data['apellidos'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        
        //retornamos una respuesta al front
        return [
            // 'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }
    public function login(LoginRequest $request){
        // Paso 1: Recepción de la Solicitud y Validación
        $data = $request->validated();

        // Paso 2: Intento de Autenticación
        // Intentamos autenticar al usuario con los datos de inicio de sesión proporcionados.
        if (!auth()->attempt($data)) {
            // Paso 3: Respuesta de Error en Caso de Autenticación Fallida
            // Si la autenticación falla, respondemos con un mensaje de error.
            return response([
                'errors' => ['El email o el password son incorrectos.']
            ], 422);
        }

        //obtenenemos al usuario authenticado.
        $user = Auth::user();

        //verificamos si el usuario está o no esta activo
        if ($user->estado != 1) {
            // Si el estado del usuario no es activo (por ejemplo, estado = 0), puedes responder con un mensaje de error.
            return response([
                'errors' => ['Usuario no autorizado']
            ], 422);
            $user->currentAccessToken()->delete();
        }
        
        return [
            // Generamos un token de autenticación para el usuario autenticado.
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user  // Devolvemos el objeto del usuario autenticado.
        ];
    }
    public function logout(Request $request){
        //Laravel utiliza el token de autorización que se envió en el header de la solicitud (Authorization: `Bearer ${token}`) de esta forma accedemos al usuario authenticado que envió la solicitud y lo recuperamos de la siguiente forma:
        $user = $request->user();

        //Esto revoca el token de acceso actual del usuario, lo que significa que el token ya no es válido y no se puede utilizar para autenticar futuras solicitudes.
        $user->currentAccessToken()->delete();

        return [
            'user'=>null
        ];
    }
}
