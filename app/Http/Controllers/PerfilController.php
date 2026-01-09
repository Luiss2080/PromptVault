<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        // Recuperar usuario desde la sesión manual
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sesión no válida.');
        }

        // Obtener actividad reciente
        $logs = \App\Models\LogSistema::where('usuario_id', $userId)
                                       ->orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();

        return view('perfil.index', compact('user', 'logs'));
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        $user = \App\Models\User::find(session('user_id'));
        if (!$user) return redirect()->route('login');
        return view('perfil.edit', compact('user'));
    }

    public function cambiarPassword()
    {
        $user = \App\Models\User::find(session('user_id'));
        if (!$user) return redirect()->route('login');
        return view('perfil.security', compact('user'));
    }

    public function actualizarPassword(Request $request)
    {
        $user = \App\Models\User::find(session('user_id'));

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'La contraseña actual no es correcta.');
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return redirect()->route('perfil.index')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function update(Request $request)
    {
        $user = \App\Models\User::find(session('user_id'));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'ci' => 'nullable|string|max:20|unique:users,ci,'.$user->id,
            'fecha_nacimiento' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'biografia' => 'nullable|string|max:500',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'profesion' => 'nullable|string|max:255',
            'nivel_estudios' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->phone,
            'direccion' => $request->address,
            'biografia' => $request->biografia,
            'genero' => $request->genero,
            'profesion' => $request->profesion,
            'nivel_estudios' => $request->nivel_estudios,
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
        ]);

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }

    public function subirAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = \App\Models\User::find(session('user_id'));

        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('images/avatars'), $imageName);

            // Eliminar avatar anterior si no es el default
            if ($user->avatar && $user->avatar !== 'default-avatar.png' && file_exists(public_path('images/avatars/'.$user->avatar))) {
                unlink(public_path('images/avatars/'.$user->avatar));
            }

            $user->update(['avatar' => $imageName]);
            
            return response()->json(['success' => true, 'avatar_url' => asset('images/avatars/'.$imageName)]);
        }

        return response()->json(['success' => false], 400);
    }
}