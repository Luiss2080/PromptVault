<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesionPrompt extends Model
{
    protected $table = 'sesiones_prompts';

    protected $fillable = [
        'user_id',
        'filtros_activos',
        'busquedas_recientes',
        'vista_preferida',
        'columnas_visibles',
        'orden_preferido',
        'fecha_expiracion',
    ];

    protected $casts = [
        'filtros_activos' => 'array',
        'busquedas_recientes' => 'array',
        'columnas_visibles' => 'array',
        'fecha_expiracion' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
