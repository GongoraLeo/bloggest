<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- Rutas Públicas ---

Route::get('/', function () {
    return view('welcome');
});

// Rutas para Posts (visualización pública)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Ruta para que cualquiera (incluidos invitados) pueda crear comentarios.
// La migración de comentarios permite un user_id nulo.
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');


// --- Rutas para usuarios autenticados ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para que el autor de un comentario o un admin puedan editarlo o borrarlo.
    Route::resource('comments', CommentController::class)->only(['edit', 'update', 'destroy']);
});

// --- Rutas de Administración ---
// Protegidas para que solo usuarios con el rol 'admin' puedan acceder.
// Usamos el Gate 'access-admin-panel'
Route::middleware(['auth', 'can:access-admin-panel'])->prefix('admin')->name('admin.')->group(function () {
    // Rutas para crear, editar y borrar posts.
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    // Rutas para el CRUD completo de usuarios.
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
