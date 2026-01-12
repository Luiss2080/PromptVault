<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->esAdmin();
    }

    public function rules(): array
    {
        $usuarioId = $this->route('usuario');

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($usuarioId)],
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'cuenta_activa' => 'required|boolean',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'Este email ya está en uso',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'role_id.required' => 'Debe seleccionar un rol',
        ];
    }
}
