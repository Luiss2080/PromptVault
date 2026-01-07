<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Mostrar el formulario de recuperación de contraseña
     */
    public function showLinkRequestForm()
    {
        return view('auth.recuperar', ['step' => 'email']);
    }

    /**
     * Enviar el enlace de recuperación
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('success', 'Te hemos enviado un enlace de recuperación por correo electrónico.');
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
