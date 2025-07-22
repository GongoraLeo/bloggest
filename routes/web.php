<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rutas de Recursos de la Aplicación
|--------------------------------------------------------------------------
| Aquí agrupamos todas las rutas de tipo "resource".
*/
Route::resource('posts', PostController::class);
Route::resource('users', UserController::class);

// Rutas anidadas para los comentarios de un post
Route::resource('posts.comments', CommentController::class)->shallow();
