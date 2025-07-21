<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    /**
     * Obtiene el usuario al que pertenece el post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene los comentarios para el post del blog.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
