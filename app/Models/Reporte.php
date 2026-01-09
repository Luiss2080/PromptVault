<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'parametros',
        'filtros',
        'columnas',
        'formato',
        'programado',
        'frecuencia',
        'usuario_id',
        'estado'
    ];

    protected $casts = [
        'parametros' => 'array',
        'filtros' => 'array',
        'columnas' => 'array',
        'programado' => 'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function ejecuciones()
    {
        return $this->hasMany(EjecucionReporte::class);
    }
}