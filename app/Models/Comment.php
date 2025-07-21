<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * Obtiene el post al que pertenece el comentario.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Obtiene el usuario al que pertenece el comentario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
