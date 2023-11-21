<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlaceController;

use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    Log::info('Loading welcome page');
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $request->session()->flash('info', 'TEST flash messages');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Mail

Route::get('mail/test', [MailController::class, 'test']);

// Files

Route::resource('files', FileController::class)
    ->middleware(['auth', 'role:' . Role::ADMIN]);

Route::get('files/{file}/delete', [FileController::class, 'delete'])->name('files.delete')
    ->middleware(['auth', 'role:' . Role::ADMIN]);

// Posts

Route::resource('posts', PostController::class)
    ->middleware(['auth', 'role.any:' . implode(',', [Role::ADMIN, Role::AUTHOR])]);

Route::get('posts/{post}/delete', [PostController::class, 'delete'])->name('posts.delete')
    ->middleware(['auth', 'role.any:' . implode(',', [Role::ADMIN, Role::AUTHOR])]);

// Places

Route::resource('places', PlaceController::class)
    ->middleware(['auth', 'role.any:' . implode(',', [Role::ADMIN, Role::AUTHOR])]);

Route::get('places/{place}/delete', [PlaceController::class, 'delete'])->name('places.delete')
    ->middleware(['auth', 'role.any:' . implode(',', [Role::ADMIN, Role::AUTHOR])]);
