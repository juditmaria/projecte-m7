<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostLikeController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\FavoriteController;


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

Route::apiResource('token', TokenController::class);
Route::middleware('auth:sanctum')->get('/user', [TokenController::class, 'user']);
Route::post('/register', [TokenController::class, 'register'])->middleware('guest');
Route::post('/login', [TokenController::class, 'login'])->middleware('guest');
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('places', PlaceController::class);
    Route::post('places/{place}', [PlaceController::class, 'update_workaround']);

    // Rutas para los favoritos
    Route::get('/places/{place}/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/places/{place}/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/places/{place}/favorites/{favorite}', [FavoriteController::class, 'show'])->name('favorites.show');
    Route::put('/places/{place}/favorites/{favorite}', [FavoriteController::class, 'update'])->name('favorites.update');
    Route::delete('/places/{place}/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/places/{place}/favorites/{favorite}', [FavoriteController::class, 'update_workaround']);
});
