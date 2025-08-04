<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Aplicar las policies de autorización a los métodos del controlador.
     */
    public function __construct()
    {
        // Aplica la autorización de la policy a los métodos del resource controller.
        // Los métodos 'edit', 'update', 'destroy' están protegidos por el middleware 'auth' en web.php
        // y aquí se les aplica la policy correspondiente ('update' y 'delete').
        // El método 'store' no se ve afectado porque no es parte de este resource en las rutas.
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Store a newly created resource in storage.
     * Cualquiera (invitado o autenticado) puede crear un comentario.
     */
    public function store(Request $request, Post $post)
    {
        $rules = [
            'content' => ['required', 'string', 'max:2000'],
        ];

        // Si el usuario no está autenticado, requerir nombre y email.
        if (!Auth::check()) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(), // Será null para invitados
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        return back()->with('success', 'Comentario añadido correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     * Solo el autor o un admin pueden acceder.
     */
    public function edit(Comment $comment)
    {
        // La autorización se maneja en el constructor con authorizeResource.
        // La vista debería estar en una carpeta 'comments', quizás dentro de 'admin' o una general.
        // Como tanto usuarios como admins pueden editar, una carpeta general 'comments' parece mejor.
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     * Solo el autor o un admin pueden acceder.
     */
    public function update(Request $request, Comment $comment)
    {
        // La autorización se maneja en el constructor.
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $comment->update($validated);

        // Redirigir al post al que pertenece el comentario.
        return redirect()->route('posts.show', $comment->post)->with('success', 'Comentario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Solo el autor o un admin pueden acceder.
     */
    public function destroy(Comment $comment)
    {
        // La autorización se maneja en el constructor.
        $post = $comment->post; // Guardar el post para la redirección.
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comentario eliminado correctamente.');
    }
}
