<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'prompts'])
            ->withCount('prompts');

        // Búsqueda por nombre o email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($request->has('rol') && $request->rol != '') {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        // Filtro por estado de cuenta
        if ($request->has('cuenta_activa') && $request->cuenta_activa !== '') {
            $query->where('cuenta_activa', (bool) $request->cuenta_activa);
        }

        // Filtro por fecha de registro (desde)
        if ($request->has('fecha_desde') && $request->fecha_desde != '') {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        // Filtro por fecha de registro (hasta)
        if ($request->has('fecha_hasta') && $request->fecha_hasta != '') {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Filtro por número mínimo de prompts
        if ($request->has('prompts_min') && $request->prompts_min !== '') {
            $query->having('prompts_count', '>=', (int) $request->prompts_min);
        }

        // Filtro por último acceso
        if ($request->has('tiene_acceso') && $request->tiene_acceso !== '') {
            if ($request->tiene_acceso == '1') {
                $query->whereNotNull('ultimo_acceso');
            } else {
                $query->whereNull('ultimo_acceso');
            }
        }

        $perPage = $request->input('per_page', 10);
        $usuarios = $query->latest()->paginate($perPage);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'cuenta_activa' => 'required|boolean',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Hash de la contraseña
        $validated['password'] = Hash::make($validated['password']);

        $usuario = User::create($validated);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show($id)
    {
        $usuario = User::with(['role', 'prompts'])
            ->withCount('prompts')
            ->findOrFail($id);

        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'cuenta_activa' => 'required|boolean',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto anterior
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Solo actualizar contraseña si se proporcionó una nueva
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // No permitir eliminar al usuario autenticado
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        if ($auth->check() && $auth->user()->id === (int) $id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Eliminar foto de perfil si existe
        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
