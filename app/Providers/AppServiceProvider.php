<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        // app/Providers/AuthServiceProvider.php
        
            // ... otras policies
            \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
       
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate para administradores
        Gate::define('access-admin-panel', function (User $user) { 
            return $user->isAdmin();
        });

        // Gate para crear posts (solo administradores)
        Gate::define('create-post', function (User $user) {
            return $user->isAdmin();
        });
    }
}
