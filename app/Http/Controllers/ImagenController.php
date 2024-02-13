<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Obtén el usuario autenticado que realiza la solicitud
        $user = $request->user();

        // Verifica si se ha enviado un archivo con el nombre "image" en la solicitud
        if ($request->hasFile('imagen')) {
            // Obtiene el archivo de la solicitud con el nombre "image"
            $file = $request->file('imagen');

            // Genera un nombre de archivo único basado en el tiempo actual y un identificador único
            $finalName = time() . '_' . uniqid() . '.' . $file->getClientOriginalName();

            // Eliminar la imagen anterior si existe
            if ($user->imagen && $user->imagen!='perfil.jpg') {
                // Elimina el archivo físico de la carpeta storage/app/public/images
                Storage::disk('public')->delete('images/usuarios' . $user->imagen);

                // Elimina el enlace simbólico en public/storage/images
                Storage::delete('images/usuarios' . $user->imagen);
            }
            // Almacena la nueva imagen en la carpeta 'storage/app/public/images/usuarios' con el nuevo nombre.
            //1 -> El primer argumento es el directorio dentro del disco en el que deseas almacenar el archivo.
            //2 -> El segundo argumento es el nombre del archivo que deseas darle al archivo almacenado.
            //3 -> El tercer argumento es el disco en el que deseas almacenar el archivo.
            $file->storeAs('images/usuarios', $finalName, 'public');

            // Actualiza la imagen del usuario
            $user->imagen = $finalName;
            $user->save();
            
            // Devuelve una respuesta JSON indicando que la imagen se cargó con éxito
            return response()->json(["message" => "Imagen cargada exitosamente"]);
        }


        // Si no se encontró un archivo con el nombre "image" en la solicitud, devuelve un mensaje de error
        return response()->json(['message' => 'Error en subida de imagen']);
    }

}
