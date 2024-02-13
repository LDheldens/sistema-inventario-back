<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(){
        $categorias = Categoria::paginate(10);
        return [
            'categorias' => $categorias
        ];
    }
    public function store(Request $request){

        $request->validate([
            'nombre'=>'required|string',
            'descripcion'=>'required|min:10|max:200'
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'descripcion.required'=>'La descripción es obligatoria',
            'descripcion.min'=>'La descripción debe tener como mínimo 10 caracteres',
            'descripcion.max'=>'La descripción debe tener como máximo 200 caracteres'
        ]);
        Categoria::create([
            'nombre'=> $request->nombre,
            'descripcion'=> $request->descripcion,
        ]);

        return response()->json([
            'message'=>'Categoria registrada'
        ]);
    }
    public function update(Request $request, string $id){

        $request->validate([
            'nombre'=>'required|string',
            'descripcion'=>'required|min:10|max:200'
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'descripcion.required'=>'La descripción es obligatoria',
            'descripcion.min'=>'La descripción debe tener como mínimo 10 caracteres',
            'descripcion.max'=>'La descripción debe tener como máximo 200 caracteres'
        ]);
        
        $categoria = Categoria::find($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        // $categoria->updated_at= now();
        $categoria->save();

        return [
            'message'=>'Cambios registrados'
        ];
    }
    public function destroy(Request $request, string $id){
        $categoria = Categoria::find($id);
        $categoria->delete();
        
        return[
            'message' => 'Categoria eliminada exitosamente' 
        ];
    }

    //metodos personalizados
    public function distribucionProductos(Request $request)
    {
        // Obtener la distribución de productos por categoría
        $distribucion = Categoria::withCount('productos')->get();

        return [
            'distribucion' => $distribucion,
        ];
    }

}
