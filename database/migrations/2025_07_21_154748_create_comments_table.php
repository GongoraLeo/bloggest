<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Relaciona el comentario con un post. Si el post se borra, sus comentarios también.
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            // Relaciona el comentario con un usuario (puede ser nulo para invitados).
            // Si el usuario se borra, el user_id del comentario se pone a NULL.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
