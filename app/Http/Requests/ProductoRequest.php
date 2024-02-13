<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
        $rules = [
            'nombre' => ['required', 'string'],
            'stock' => ['required', 'numeric'],
            'precio' => ['required', 'numeric'],
            'categoria' => ['required', 'exists:categorias,id'],
        ];
    
        // Verificar si hay una imagen presente
        if ($this->hasFile('imagen')) {
            // Aplicar reglas de validación de imagen solo si hay una imagen presente
            $rules['imagen'] = [
                'mimes:jpeg,png,jpg',
                'max:2048',
            ];
        } else {
            // Personalizar el mensaje si la imagen es obligatoria y no está presente
            //$attribute: Es el nombre del campo que estamos validando. En este caso, será 'imagen'.
            // $value: Es el valor del campo.
            // $fail: Es una función que se ejecuta si falla alguna validacion, toma como parametro el mensaje personalizado.
            $rules['imagen'] = ['required', function ($attribute, $value, $fail) {
                $fail('La imagen es obligatoria.');
            }];
        }
    
        return $rules;
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string'=>'Formato del nombre no válido',
            'stock.required' => 'El stock es obligatorio.',
            'stock.numeric' => 'El stock tiene que ser un número',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio tiene que ser un número',
            'categoria.required' => 'La categoria es obligatorio',
            'categoria.exists' => 'La categoria no existe',
            'imagen.sometimes' => 'La imagen es obligatoria',
            'imagen.mimes' => 'Solo se aceptan imagenes en cualquiera de estos formatos: jpeg,png,jpg.',
            'imagen.max' => 'El peso máximo de la imagen es de 2MB.',
        ];
    }
}
