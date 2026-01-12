<?php

namespace App\Http\Controllers;

use App\Http\Requests\Perfil\UpdatePasswordRequest;
use App\Http\Requests\Perfil\UpdatePerfilRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    /**
     * Mostrar perfil del usuario
     */
    public function index()
    {
        // Obtener datos
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Sesión no válida.');
        }

        $promptsRecientes = $user->prompts()
            ->with('etiquetas')
            ->latest()
            ->take(5)
            ->get();

        $estadisticas = [
            'total_prompts' => $user->prompts()->count(),
            'prompts_publicos' => $user->prompts()->where('visibilidad', 'publico')->count(),
            'prompts_compartidos' => $user->accesosCompartidos()->count(),
            'total_comentarios' => $user->comentarios()->count(),
        ];

        $recentUsers = User::with('role')->latest()->take(5)->get();

        // Retornar vista
        return view('perfil.index', compact('user', 'promptsRecientes', 'estadisticas', 'recentUsers'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit()
    {
        // Obtener datos
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $recentUsers = User::with('role')->latest()->take(5)->get();

        // Retornar vista
        return view('perfil.edit', compact('user', 'recentUsers'));
    }

    /**
     * Actualizar perfil
     */
    public function update(UpdatePerfilRequest $request)
    {
        // Autorización: manejada en UpdatePerfilRequest::authorize()
        // Validación: manejada en UpdatePerfilRequest::rules()

        // Obtener datos validados
        $data = $request->validated();

        // Actualizar usuario
        $request->user()->update($data);

        // Retornar vista
        return redirect()->route('perfil.index')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Mostrar formulario de cambio de contraseña
     */
    public function cambiarPassword()
    {
        // Obtener datos
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $recentUsers = User::with('role')->latest()->take(5)->get();

        // Retornar vista
        return view('perfil.security', compact('user', 'recentUsers'));
    }

    /**
     * Actualizar contraseña
     */
    public function actualizarPassword(UpdatePasswordRequest $request)
    {
        // Autorización: manejada en UpdatePasswordRequest::authorize()
        // Validación: manejada en UpdatePasswordRequest::rules() + withValidator()

        // Obtener datos validados
        $data = $request->validated();

        // Actualizar contraseña
        $request->user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        // Retornar vista
        return redirect()->route('perfil.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Subir avatar (AJAX)
     */
    public function subirAvatar(Request $request)
    {
        // Validación
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Obtener datos
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $imageName = 'profile_'.$user->id.'_'.time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('uploads/profile'), $imageName);

            // Eliminar foto anterior si existe
            if ($user->foto_perfil && file_exists(public_path($user->foto_perfil))) {
                unlink(public_path($user->foto_perfil));
            }

            $rutaFoto = 'uploads/profile/'.$imageName;
            $user->update(['foto_perfil' => $rutaFoto]);

            // Retornar JSON
            return response()->json([
                'success' => true,
                'foto_url' => asset($rutaFoto),
                'message' => 'Foto de perfil actualizada correctamente',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No se recibió ninguna imagen'], 400);
    }
}
