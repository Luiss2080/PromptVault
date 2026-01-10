<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        // Recuperar usuario autenticado
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Sesión no válida.');
        }

        // Obtener actividad reciente del usuario
        $logs = \App\Models\Actividad::where('user_id', $user->id)
            ->with(['prompt'])
            ->orderBy('fecha', 'desc')
            ->take(5)
            ->get();

        // Variables necesarias para los componentes (administrador e invitado requieren recentUsers)
        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

        return view('perfil.index', compact('user', 'logs', 'recentUsers'));
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

        return view('perfil.edit', compact('user', 'recentUsers'));
    }

    public function cambiarPassword()
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

        return view('perfil.security', compact('user', 'recentUsers'));
    }

    public function actualizarPassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (! \Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'La contraseña actual no es correcta.');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return redirect()->route('perfil.index')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }

    public function subirAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        /** @var User $user */
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

            return response()->json([
                'success' => true,
                'foto_url' => asset($rutaFoto),
                'message' => 'Foto de perfil actualizada correctamente',
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No se recibió ninguna imagen'], 400);
    }
}
