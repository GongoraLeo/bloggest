<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Rellena el modelo de usuario con los datos validados del formulario.
        // Esto incluye name, email, username, bio, y social_links.
        $user->fill($request->validated());

        // Si el usuario subió un nuevo avatar...
        if ($request->hasFile('avatar')) {
            // Guarda la ruta del avatar antiguo para borrarlo después.
            $oldAvatar = $user->avatar_path;

            // Almacena el nuevo avatar en 'storage/app/public/avatars' y obtén la ruta.
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Actualiza la ruta del avatar en el modelo de usuario.
            $user->avatar_path = $path;

            // Si existía un avatar antiguo, bórralo del almacenamiento.
            if ($oldAvatar) {
                Storage::disk('public')->delete($oldAvatar);
            }
        }

        // Si el email ha cambiado, marca la cuenta como no verificada.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
