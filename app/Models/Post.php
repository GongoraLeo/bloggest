<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'published_at',
        'likes',
        'dislikes',
        'views',
        'shares',
    ];

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

    /**
     * Incrementa el contador de vistas para el post.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Incrementa el contador de compartidos para el post.
     */
    public function incrementShares(): void
    {
        $this->increment('shares');
    }

    /**
     * Obtiene los usuarios que han marcado este post como favorito.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_posts', 'post_id', 'user_id')->withTimestamps();
    }
}
