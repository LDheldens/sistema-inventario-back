<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductoResource;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Realizar búsqueda si se proporciona un término de búsqueda
        if ($request->has('s')) {
            $searchTerm = $request->input('s');
            $query->where('nombre', 'like', "%$searchTerm%");
        }
    
        $productos = $query->paginate(10);
    
        return ProductoResource::collection($productos);
    }

    public function store(ProductoRequest $request)
    {   
        // Valida y obtén los datos validados
        $datos = $request->validated();

        // Obtén el archivo de imagen desde la solicitud
        $imagen = $request->file('imagen');

        // Genera un nombre único para la imagen
        $nombreImagen = $imagen->getClientOriginalName() . '_' . Str::random(20) . time() . uniqid(). '.'. $imagen->getClientOriginalExtension();

        // Guarda la imagen en el almacenamiento con el nombre único
        $imagen->storeAs('images/productos', $nombreImagen, 'public');

        // Guarda la referencia en la base de datos
        Producto::create([
            'nombre' => $datos['nombre'],
            'stock' => $datos['stock'],
            'precio' => $datos['precio'],
            'categoria_id' => $datos['categoria'],
            'imagen' => $nombreImagen, // Almacena la ruta de la imagen
        ]);

        return[
            'message'=>'Producto registrado exitosamente.'
        ];
    }
    public function update_Producto(Request $request, string $id)
    {         
        $request->validate([
            'nombre' => ['required', 'string'],
            'stock' => ['required', 'numeric'],
            'precio' => ['required', 'numeric'],
            'categoria' => ['required', 'exists:categorias,id'],
        ],[
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string'=>'Formato del nombre no válido',
            'stock.required' => 'El stock es obligatorio.',
            'stock.numeric' => 'El stock tiene que ser un número',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio tiene que ser un número',
            'categoria.required' => 'La categoria es obligatorio',
            'categoria.exists' => 'La categoria no existe',
        ]);

        $producto = Producto::find($id);

        if ($request->hasFile('imagen')) {
            // Obtén el archivo de imagen desde la solicitud
            $imagen = $request->file('imagen');

            // Genera un nombre único para la imagen
            $nombreImagen = $imagen->getClientOriginalName() . '_' . Str::random(20) . time() . uniqid(). '.'. $imagen->getClientOriginalExtension();

            // Eliminar la imagen anterior si existe
            if ($producto->imagen) {
                // Elimina el archivo físico de la carpeta storage/app/public/images
                Storage::disk('public')->delete('images/productos/' . $producto->imagen);

                // Elimina el enlace simbólico en public/storage/images
                Storage::delete('images/productos/' . $producto->imagen);
            }
                // Guarda la nueva imagen
            $imagen->storeAs('public/images/productos/', $nombreImagen);

            // Actualiza el campo de imagen en la base de datos
            $producto->imagen = $nombreImagen;
        }
            // Actualiza los otros campos del producto
        $producto->nombre = $request->input('nombre');
        $producto->stock = $request->input('stock');
        $producto->precio = $request->input('precio');
        $producto->categoria_id = $request->input('categoria');
        
        // Guarda los cambios
        $producto->save();

        // Devuelve la respuesta que desees
        return response()->json(['message' => 'Producto actualizado correctamente']);
    }

    public function productosPorCategoria(Request $request, string $id)
    {
        $categoria = Categoria::find($id);
        $productos = $categoria->productos;
        return[
            'productos'=>$productos,
        ];
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $producto = Producto::find($id);
        $producto->delete();
        
        return[
            'message' => 'Producto eliminado exitosamente' 
        ];
    }
}
