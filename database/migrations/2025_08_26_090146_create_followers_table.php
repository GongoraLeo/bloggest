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
        Schema::create('followers', function (Blueprint $table) {
            // ID del usuario que sigue (el seguidor).
            // Se especifica la tabla 'users' para que constrained() funcione correctamente.
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            // ID del usuario que es seguido.
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');

            // Clave primaria compuesta para evitar que un usuario siga a otro más de una vez.
            $table->primary(['follower_id', 'followed_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
