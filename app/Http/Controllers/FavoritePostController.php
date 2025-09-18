<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FavoritePostController extends Controller
{
    /**
     * Asegura que solo los usuarios autenticados puedan usar este controlador.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Marca un post como favorito para el usuario autenticado.
     *
     * @param  \App\Models\Post  $post El post a marcar como favorito.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Post $post): RedirectResponse
    {
        Auth::user()->favoritePosts()->attach($post->id);

        return back()->with('success', 'Post añadido a favoritos.');
    }

    /**
     * Elimina un post de los favoritos del usuario autenticado.
     *
     * @param  \App\Models\Post  $post El post a quitar de favoritos.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        Auth::user()->favoritePosts()->detach($post->id);

        return back()->with('success', 'Post eliminado de favoritos.');
    }
}
