<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Actividad;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actividades = [
            [
                'prompt_id' => 1,
                'user_id' => 3,
                'accion' => 'creado',
                'descripcion' => 'Prompt creado',
            ],
            [
                'prompt_id' => 1,
                'user_id' => 3,
                'accion' => 'editado',
                'descripcion' => 'Contenido modificado - versión 2',
            ],
            [
                'prompt_id' => 2,
                'user_id' => 4,
                'accion' => 'creado',
                'descripcion' => 'Prompt creado',
            ],
            [
                'prompt_id' => 1,
                'user_id' => 3,
                'accion' => 'marcado_favorito',
                'descripcion' => 'Marcado como favorito',
            ],
            [
                'prompt_id' => 3,
                'user_id' => 5,
                'accion' => 'usado',
                'descripcion' => 'Prompt copiado/usado',
            ],
            [
                'prompt_id' => 4,
                'user_id' => 6,
                'accion' => 'compartido',
                'descripcion' => 'Compartido con laura@disenadora.com',
            ],
            [
                'prompt_id' => 2,
                'user_id' => 5,
                'accion' => 'usado',
                'descripcion' => 'Prompt copiado/usado',
            ],
            [
                'prompt_id' => 6,
                'user_id' => 4,
                'accion' => 'marcado_favorito',
                'descripcion' => 'Marcado como favorito',
            ],
            [
                'prompt_id' => 3,
                'user_id' => 5,
                'accion' => 'editado',
                'descripcion' => 'Contenido modificado - versión 2',
            ],
            [
                'prompt_id' => 8,
                'user_id' => 8,
                'accion' => 'compartido',
                'descripcion' => 'Compartido con carlos@dev.com',
            ],
        ];

        foreach ($actividades as $index => $actividad) {
            Actividad::create(array_merge($actividad, [
                'fecha' => now()->subDays(rand(1, 20))->subHours(rand(0, 23)),
            ]));
        }
    }
}
