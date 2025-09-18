<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Validación para el nombre de usuario: requerido, único (ignorando al usuario actual),
            // y alpha_dash (permite letras, números, guiones y guiones bajos).
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                Rule::unique(User::class, 'username')->ignore($this->user()->id),
            ],
            // Validación para el avatar: opcional, debe ser una imagen y no superar 2MB.
            'avatar' => ['nullable', 'image', 'max:2048'],
            // Validación para la biografía: opcional, texto.
            'bio' => ['nullable', 'string', 'max:1000'],
            // Validación para los enlaces sociales: opcional, debe ser un JSON válido.
            'social_links' => ['nullable', 'json'],
        ];
    }
}
