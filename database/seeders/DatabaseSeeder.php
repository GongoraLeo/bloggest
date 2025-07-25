<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //crear usuario con rol administrador
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@bloggest.com',
            'password' => Hash::make('admin'),
            'role' => User::ROLE_ADMIN,
        ]);
        
        // User::factory(10)->create();
    }
}
