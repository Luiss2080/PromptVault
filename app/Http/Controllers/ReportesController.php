<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.reportes.index');
    }

    public function estudiantes()
    {
        return view('admin.reportes.estudiantes');
    }

    public function docentes()
    {
        return view('admin.reportes.docentes');
    }

    public function materias()
    {
        return view('admin.reportes.materias');
    }

    public function calificaciones()
    {
        return view('admin.reportes.calificaciones');
    }
}
