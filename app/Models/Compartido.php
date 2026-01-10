<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compartido extends Model
{
    protected $fillable = [
        'prompt_id',
        'nombre_destinatario',
        'email_destinatario',
        'fecha_compartido',
        'notas',
        'token',
        'tipo_acceso',
        'fecha_expiracion',
        'requiere_autenticacion',
        'veces_accedido',
        'ultimo_acceso',
    ];

    protected $casts = [
        'fecha_compartido' => 'datetime',
        'fecha_expiracion' => 'datetime',
        'ultimo_acceso' => 'datetime',
        'requiere_autenticacion' => 'boolean',
    ];

    public function prompt(): BelongsTo
    {
        return $this->belongsTo(Prompt::class);
    }
}
