<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;



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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


/* Mueve la lógica de /api/user al metodo user de TokenController */
// Ruta para obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', [TokenController::class, 'user']);
// Ruta para registrar un nuevo usuario
Route::post('/register', [TokenController::class, 'register'])->middleware('guest');
// Ruta para iniciar sesión
Route::post('/login', [TokenController::class, 'login'])->middleware('guest');
// Ruta para cerrar sesión
Route::post('/logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('files', FileController::class);

Route::post('files/{file}', [FileController::class, 'update_workaround']);


// Rutas para los posts
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);

// Rutas para los "me gusta" de los posts
Route::post('/posts/{post}/likes', [PostController::class, 'like']);
Route::delete('/posts/{post}/likes', [PostController::class, 'unlike']);

Route::post('posts/{post}', [PostController::class, 'update_workaround']);