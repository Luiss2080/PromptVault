<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuraciones.index');
    }

    /**
     * Show the general settings page.
     */
    public function general()
    {
        return view('configuraciones.general');
    }

    /**
     * Show the security settings page.
     */
    public function seguridad()
    {
        return view('configuraciones.seguridad');
    }

    /**
     * Show the notifications settings page.
     */
    public function notificaciones()
    {
        return view('configuraciones.notificaciones');
    }

    /**
     * Show the appearance settings page.
     */
    public function apariencia()
    {
        return view('configuraciones.apariencia');
    }

    /**
     * Show the system settings page.
     */
    public function sistema()
    {
        return view('configuraciones.sistema');
    }

    /**
     * Show the backups settings page.
     */
    public function respaldos()
    {
        return view('configuraciones.respaldos');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Lógica para actualizar configuraciones
        return redirect()->route('configuraciones.index')->with('success', 'Configuración actualizada exitosamente.');
    }
}
