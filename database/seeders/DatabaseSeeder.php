<?php


namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // 1. Limpiar tablas para evitar duplicados en ejecuciones repetidas (opcional si usas migrate:fresh)
        // User::truncate();
        // Post::truncate();
        // Comment::truncate();

        // 2. Crear el usuario Administrador
        $admin = User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@bloggest.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // 3. Crear 15 usuarios normales
        $users = User::factory(15)->create();

        // 4. Crear 50 posts, asignando un autor aleatorio de los usuarios creados (incluido el admin)
        $allUsers = $users->push($admin);
        $posts = Post::factory(50)->make()->each(function ($post) use ($allUsers) {
            $post->user_id = $allUsers->random()->id;
            $post->save();
        });

        // 5. Crear 300 comentarios, asignando un post y un autor aleatorios
        Comment::factory(300)->make()->each(function ($comment) use ($posts, $allUsers) {
            $comment->post_id = $posts->random()->id;
            // 70% de probabilidad de que el autor sea un usuario registrado, 30% de ser un invitado
            if (rand(1, 10) > 3) {
                $comment->user_id = $allUsers->random()->id;
                $comment->name = null;
                $comment->email = null;
            }
            $comment->save();
        });
    }
}

