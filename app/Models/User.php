<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'cuenta_activa',
        'ultimo_acceso',
        'foto_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'cuenta_activa' => 'boolean',
            'ultimo_acceso' => 'datetime',
        ];
    }

    // Relaciones
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class);
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }

    public function compartidos(): HasMany
    {
        return $this->hasMany(Compartido::class, 'user_id');
    }

    public function sesionPrompt(): HasOne
    {
        return $this->hasOne(SesionPrompt::class);
    }

    // Métodos helper para roles y permisos
    public function esAdmin(): bool
    {
        return $this->role?->nombre === 'admin';
    }

    public function esUsuario(): bool
    {
        return $this->role?->nombre === 'user';
    }

    public function esColaborador(): bool
    {
        return $this->role?->nombre === 'collaborator';
    }

    public function esGuest(): bool
    {
        return $this->role?->nombre === 'guest';
    }

    public function tienePermiso(string $nombrePermiso): bool
    {
        return $this->role?->tienePermiso($nombrePermiso) ?? false;
    }

    public function tieneAlgunoDeEstosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if ($this->tienePermiso($permiso)) {
                return true;
            }
        }

        return false;
    }

    public function tieneTodosEstosPermisos(array $permisos): bool
    {
        foreach ($permisos as $permiso) {
            if (! $this->tienePermiso($permiso)) {
                return false;
            }
        }

        return true;
    }

    public function puedeEditar(Prompt $prompt): bool
    {
        // El propietario siempre puede editar
        if ($this->id === $prompt->user_id) {
            return true;
        }

        // Admin puede editar todos
        if ($this->esAdmin()) {
            return true;
        }

        // Verificar si tiene permiso de editar compartidos
        if ($this->tienePermiso('prompts.editar_compartidos')) {
            // Verificar si el prompt está compartido con este usuario con permiso de edición
            $compartido = $prompt->compartidos()
                ->where('email_destinatario', $this->email)
                ->where('tipo_acceso', 'puede_editar')
                ->first();

            return $compartido !== null;
        }

        return false;
    }

    public function puedeVer(Prompt $prompt): bool
    {
        // Prompt público
        if ($prompt->es_publico) {
            return true;
        }

        // Propietario
        if ($this->id === $prompt->user_id) {
            return true;
        }

        // Admin puede ver todos
        if ($this->esAdmin()) {
            return true;
        }

        // Verificar si está compartido con este usuario
        $compartido = $prompt->compartidos()
            ->where('email_destinatario', $this->email)
            ->first();

        return $compartido !== null;
    }

    public function actualizarUltimoAcceso(): void
    {
        $this->update(['ultimo_acceso' => now()]);
    }
}
