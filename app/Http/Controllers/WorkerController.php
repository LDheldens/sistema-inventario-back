<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $productos = User::all();
        // return response()->json(['productos'=> $productos]);
        $users=User::paginate(8);
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return [
            'xd'=>'dwdw'
        ];
    }

    public function update(Request $request, string $id)
    {   
        $worker = User::find($id);

        if (!$worker) {
            return response()->json(['errors' => 'Trabajador no encontrado'], 404);
        }
        
        $worker->estado = $request->estado;
        $worker->rol = $request->rol;

        $worker->save();

        return [
            'message'=>'Cambios registrados'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);
        $usuario->delete();
        return[
            'message' => 'Usuario eliminado exitosamente' 
        ];
    }
}
