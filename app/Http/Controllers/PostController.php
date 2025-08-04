<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Proteger las rutas de administración con middleware.
     * Solo los usuarios con el Gate 'access-admin-panel' podrán acceder.
     */
    public function __construct()
    {
        // Aplica el middleware a todos los métodos EXCEPTO a los públicos 'index' y 'show'.
        // Esto asegura que solo los administradores puedan crear, editar o eliminar posts.
        $this->middleware('can:access-admin-panel')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource. (Ruta Pública)
     * Muestra una lista paginada de todos los posts.
     */
    public function index()
    {
        // Carga los posts con su autor (user) y el conteo de comentarios de forma eficiente.
        // Esto evita el problema N+1 al no tener que hacer una consulta por cada post en la vista.
        $posts = Post::with('user')->withCount('comments')->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource. (Ruta Pública)
     * Muestra un post específico junto con sus comentarios.
     */
    public function show(Post $post)
    {
        // Incrementa el contador de vistas cada vez que se muestra el post.
        $post->incrementViews();

        // Carga el autor del post y sus comentarios paginados.
        // Los comentarios se ordenan por el más reciente y se cargan con su autor.
        $post->load(['user', 'comments' => function ($query) {
            $query->with('user')->latest()->paginate(10, ['*'], 'comments_page');
        }]);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for creating a new resource. (Ruta de Admin)
     * Muestra el formulario para crear un nuevo post.
     */
    public function create()
    {
        // La autorización se maneja en el constructor.
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage. (Ruta de Admin)
     * Guarda un nuevo post en la base de datos.
     */
    public function store(Request $request)
    {
        // La autorización se maneja en el constructor. 
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts'],
            'content' => ['required', 'string'],
        ]);

        // Crea el post asociándolo al usuario autenticado.
        $post = Auth::user()->posts()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']), // Genera un slug amigable para la URL.
            'content' => $validated['content'],
            'published_at' => now(), // Publica el post inmediatamente.
        ]);

        // Redirige a la vista pública del post recién creado.
        return redirect()->route('posts.show', $post)->with('success', 'Post creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource. (Ruta de Admin)
     * Muestra el formulario para editar un post existente.
     */
    public function edit(Post $post)
    {
        // La autorización se maneja en el constructor.
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage. (Ruta de Admin)
     * Actualiza un post existente en la base de datos.
     */
    public function update(Request $request, Post $post)
    {
        // La autorización se maneja en el constructor.
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts,title,' . $post->id],
            'content' => ['required', 'string'],
        ]);

        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']), // Actualiza el slug si el título cambia.
            'content' => $validated['content'],
        ]);

        // Redirige a la vista pública del post actualizado.
        return redirect()->route('posts.show', $post)->with('success', 'Post actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage. (Ruta de Admin)
     * Elimina un post de la base de datos.
     */
    public function destroy(Post $post)
    {
        // La autorización se maneja en el constructor.
        $post->delete();

        // Redirige al índice de posts en el panel de administración.
        // Como no hay una ruta 'admin.posts.index', lo redirigimos a la de usuarios.
        // Lo ideal sería crear una vista para listar posts en el admin.
        return redirect()->route('admin.users.index')->with('success', 'Post eliminado correctamente.');
    }
}
