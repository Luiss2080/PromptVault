<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro
     */
    public function showRegistrationForm()
    {
        return view('auth.registro');
    }

    /**
     * Procesar el registro
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'ci' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'acepta_terminos' => ['required', 'accepted'],
        ]);

        // Obtener el rol de usuario por defecto (user)
        $roleUser = Role::where('nombre', 'user')->first();

        // Concatenar nombre y apellido si existe apellido
        $nombreCompleto = $request->name;
        if ($request->apellido) {
            $nombreCompleto .= ' ' . $request->apellido;
        }

        $user = User::create([
            'name' => $nombreCompleto,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser ? $roleUser->id : null,
            'cuenta_activa' => true,
            'ultimo_acceso' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/prompts')->with('success', '¡Cuenta creada exitosamente! Bienvenido a PromptVault.');
    }
}
