<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prompt extends Model
{
    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'contenido',
        'descripcion',
        'fecha_creacion',
        'ia_destino',
        'es_favorito',
        'es_publico',
        'version_actual',
        'veces_usado',
        'fecha_modificacion',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'es_favorito' => 'boolean',
        'es_publico' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function versiones(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function compartidos(): HasMany
    {
        return $this->hasMany(Compartido::class);
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'etiqueta_prompt');
    }
}
