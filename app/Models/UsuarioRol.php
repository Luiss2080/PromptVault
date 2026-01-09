<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioRol extends Model
{
    use HasFactory;

    protected $table = 'usuario_roles';

    protected $fillable = [
        'user_id',
        'rol_id',
        'colegio_id',
        'fecha_asignacion',
        'fecha_expiracion',
        'activo',
        'observaciones',
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_expiracion' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Relación con el usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Relación con el colegio (opcional)
     */
    public function colegio(): BelongsTo
    {
        return $this->belongsTo(Colegio::class, 'colegio_id');
    }

    /**
     * Scope para asignaciones activas
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para asignaciones no expiradas
     */
    public function scopeVigentes($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('fecha_expiracion')
              ->orWhere('fecha_expiracion', '>', now());
        });
    }

    /**
     * Verificar si la asignación está vigente
     */
    public function estaVigente(): bool
    {
        if (!$this->activo) {
            return false;
        }

        if ($this->fecha_expiracion && $this->fecha_expiracion < now()) {
            return false;
        }

        return true;
    }
}