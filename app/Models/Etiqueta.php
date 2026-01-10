<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Etiqueta extends Model
{
    protected $fillable = [
        'nombre',
    ];

    public function prompts(): BelongsToMany
    {
        return $this->belongsToMany(Prompt::class, 'etiqueta_prompt');
    }
}
