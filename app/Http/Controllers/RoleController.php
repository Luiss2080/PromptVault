<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::withCount('usuarios');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
        }

        if ($request->has('tipo') && $request->tipo != '') {
            $esSistema = $request->tipo == 'sistema';
            $query->where('es_sistema', $esSistema);
        }

        $perPage = $request->input('per_page', 10);
        $roles = $query->latest()->paginate($perPage);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisosGrouped = \App\Models\Permiso::agrupadosPorModulo();
        return view('admin.roles.create', compact('permisosGrouped'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['permisos', 'usuarios']);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permisosGrouped = \App\Models\Permiso::agrupadosPorModulo();
        $role->load('permisos');
        return view('admin.roles.edit', compact('role', 'permisosGrouped'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
