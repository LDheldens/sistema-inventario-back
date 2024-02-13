<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WorkerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/imagen-perfil', [ImagenController::class,'uploadImage']);

    //cambiar password e informacion
    Route::put('/user/update-info',[UserController::class, 'updateInfo']);
    Route::put('/user/update-password',[UserController::class, 'updatePassword']);

    //obtiene todos los usuarios registrados
    Route::apiResource('/workers', WorkerController::class);

    //Categorias
    // Route::apiResource('/categorias', CategoriaController::class);
    Route::apiResource('/categorias', CategoriaController::class)->except(['show']);
    Route::get('/categorias/distribucion-productos', [CategoriaController::class, 'distribucionProductos']);
    
    //productos
    Route::apiResource('/productos', ProductoController::class);
    Route::post('/productos/{id}/actualizar-producto', [ProductoController::class,'update_producto']);
    Route::get('/categorias/{id}/productos', [ProductoController::class,'productosPorCategoria']);
    
});

// Route::apiResource('/categorias',CategoriaController::class);
// Route::apiResource('/productos',ProductoController::class);



// Authenticación
Route::post('/registro',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);


