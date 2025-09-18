<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Asegura que solo los usuarios autenticados puedan usar este controlador.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sigue a un usuario.
     *
     * @param  \App\Models\User  $user El usuario a seguir.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user): RedirectResponse
    {
        $currentUser = Auth::user();

        // Un usuario no puede seguirse a sí mismo.
        if ($currentUser->id === $user->id) {
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }

        // Añade la relación de seguimiento.
        $currentUser->following()->attach($user->id);

        return back()->with('success', 'Ahora sigues a ' . $user->name);
    }

    /**
     * Deja de seguir a un usuario.
     *
     * @param  \App\Models\User  $user El usuario a dejar de seguir.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // Elimina la relación de seguimiento.
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'Has dejado de seguir a ' . $user->name);
    }
}
