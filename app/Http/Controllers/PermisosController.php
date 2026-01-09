<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Permiso::withCount('roles');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->has('modulo') && $request->modulo != '') {
            $query->where('modulo', $request->modulo);
        }

        $perPage = $request->input('per_page', 10);
        $permisos = $query->orderBy('modulo')->paginate($perPage);

        // Get unique modules for filter
        $modulos = \App\Models\Permiso::select('modulo')->distinct()->pluck('modulo');

        return view('admin.permisos.index', compact('permisos', 'modulos'));
    }

    public function create()
    {
        // Get unique modules and actions for suggestions
        $modulos = \App\Models\Permiso::select('modulo')->distinct()->pluck('modulo');
        $acciones = \App\Models\Permiso::select('accion')->distinct()->pluck('accion');
        
        return view('admin.permisos.create', compact('modulos', 'acciones'));
    }

    public function store(Request $request)
    {
        // Placeholder for store logic
    }

    public function show($id)
    {
        $permiso = \App\Models\Permiso::withCount('roles')->findOrFail($id);
        return view('admin.permisos.show', compact('permiso'));
    }

    public function edit($id)
    {
        $permiso = \App\Models\Permiso::findOrFail($id);
        // Get unique modules and actions for suggestions
        $modulos = \App\Models\Permiso::select('modulo')->distinct()->pluck('modulo');
        $acciones = \App\Models\Permiso::select('accion')->distinct()->pluck('accion');

        return view('admin.permisos.edit', compact('permiso', 'modulos', 'acciones'));
    }

    public function update(Request $request, $id)
    {
        // Placeholder for update logic
    }

    public function destroy($id)
    {
        // Placeholder for destroy logic
    }
}