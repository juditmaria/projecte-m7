<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostLikeController;



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

Route::apiResource('token', TokenController::class);
/* Mueve la l贸gica de /api/user al metodo user de TokenController */
// Ruta para obtener informaci贸n del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', [TokenController::class, 'user']);
// Ruta para registrar un nuevo usuario
Route::post('/register', [TokenController::class, 'register'])->middleware('guest');
// Ruta para iniciar sesi贸n
Route::post('/login', [TokenController::class, 'login'])->middleware('guest');
// Ruta para cerrar sesi贸n
Route::post('/logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);


Route::apiResource('posts', PostController::class);
// Rutas para los posts
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
Route::post('posts/{post}', [PostController::class, 'update_workaround']);

Route::apiResource('postslikes', PostLikeController::class);
// Rutas para los "me gusta" de los posts
Route::get('/posts/{post}/likes', [PostLikeController::class, 'index']);
Route::post('/posts/{post}/likes', [PostLikeController::class, 'store']);
Route::get('/posts/{post}/likes/{like}', [PostLikeController::class, 'show']);
Route::put('/posts/{post}/likes/{like}', [PostLikeController::class, 'update']);
Route::delete('/posts/{post}/likes/{like}', [PostLikeController::class, 'destroy']);
Route::post('/posts/{post}/likes/{like}', [PostLikeController::class, 'update_workaround']);