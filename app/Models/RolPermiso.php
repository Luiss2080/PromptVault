<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolPermiso extends Model
{
    use HasFactory;

    protected $table = 'rol_permisos';

    protected $fillable = [
        'rol_id',
        'permiso_id',
        'permitir',
        'condiciones',
    ];

    protected $casts = [
        'permitir' => 'boolean',
        'condiciones' => 'array',
    ];

    /**
     * Relación con el rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Relación con el permiso
     */
    public function permiso(): BelongsTo
    {
        return $this->belongsTo(Permiso::class, 'permiso_id');
    }

    /**
     * Scope para permisos permitidos
     */
    public function scopePermitidos($query)
    {
        return $query->where('permitir', true);
    }

    /**
     * Scope para permisos denegados
     */
    public function scopeDenegados($query)
    {
        return $query->where('permitir', false);
    }
}