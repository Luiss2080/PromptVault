<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUsuarioRequest;
use App\Http\Requests\Usuario\UpdateUsuarioRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    /**
     * Listar usuarios
     */
    public function index(Request $request)
    {
        // Obtener filtros
        $query = User::with(['role', 'prompts'])->withCount('prompts');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rol')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('nombre', $request->rol);
            });
        }

        if ($request->has('cuenta_activa') && $request->cuenta_activa !== '') {
            $query->where('cuenta_activa', (bool) $request->cuenta_activa);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Obtener datos
        $perPage = $request->input('per_page', 10);
        $usuarios = $query->latest()->paginate($perPage);

        // Retornar vista
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        // Obtener datos
        $roles = Role::all();

        // Retornar vista
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Guardar usuario
     */
    public function store(StoreUsuarioRequest $request)
    {
        // Autorización: manejada en StoreUsuarioRequest::authorize()
        // Validación: manejada en StoreUsuarioRequest::rules()

        // Obtener datos validados
        $data = $request->validated();

        // Procesar foto si existe
        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Hash de contraseña
        $data['password'] = Hash::make($data['password']);

        // Crear usuario
        User::create($data);

        // Retornar vista
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Mostrar usuario
     */
    public function show($id)
    {
        // Obtener datos
        $usuario = User::with(['role', 'prompts'])
            ->withCount('prompts')
            ->findOrFail($id);

        // Retornar vista
        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        // Obtener datos
        $usuario = User::findOrFail($id);
        $roles = Role::all();

        // Retornar vista
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        // Autorización: manejada en UpdateUsuarioRequest::authorize()
        // Validación: manejada en UpdateUsuarioRequest::rules()

        // Obtener datos validados
        $data = $request->validated();
        $usuario = User::findOrFail($id);

        // Procesar foto si existe
        if ($request->hasFile('foto_perfil')) {
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Solo actualizar contraseña si se proporcionó
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Actualizar usuario
        $usuario->update($data);

        // Retornar vista
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id)
    {
        // Obtener datos
        $usuario = User::findOrFail($id);

        // No permitir eliminar al usuario autenticado
        if (auth()->id() === (int) $id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Eliminar foto si existe
        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        // Eliminar usuario
        $usuario->delete();

        // Retornar vista
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
