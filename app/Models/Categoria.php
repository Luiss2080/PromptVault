<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
    ];

    public function prompts(): HasMany
    {
        return $this->hasMany(Prompt::class);
    }
}
