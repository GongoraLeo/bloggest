<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Permite a un administrador realizar cualquier acción.
     * Este método se ejecuta antes que cualquier otro en la policy.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null; // Dejar que la policy continúe con el método específico de la habilidad.
    }

    /**
     * Determina si el usuario puede actualizar el comentario.
     * Solo el autor del comentario puede actualizarlo.
     * (Los administradores ya están autorizados por el método 'before').
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el comentario.
     * Solo el autor del comentario puede eliminarlo.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}