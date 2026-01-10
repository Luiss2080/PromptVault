<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Actualizar último acceso
            $user->update([
                'ultimo_acceso' => now(),
            ]);

            // Guardar información del usuario en sesión
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            $request->session()->put('user_email', $user->email);
            $request->session()->put('user_role', $user->role?->nombre ?? 'guest');
            $request->session()->put('user_role_id', $user->role_id);

            // Redirigir según el rol del usuario
            return $this->redirectByRole($user);
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Redirigir según el rol del usuario
     */
    protected function redirectByRole($user)
    {
        // Mensaje de bienvenida según el rol
        $mensaje = match ($user->role?->nombre) {
            'admin' => '¡Bienvenido Administrador!',
            'collaborator' => '¡Bienvenido Colaborador!',
            'user' => '¡Bienvenido Usuario!',
            default => '¡Bienvenido a PromptVault!',
        };

        // Todos los usuarios van al dashboard
        return redirect()->intended('/dashboard')->with('success', $mensaje);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
