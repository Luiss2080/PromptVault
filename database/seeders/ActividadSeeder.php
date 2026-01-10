<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actividades = [
            // Actividades de creación
            ['prompt_id' => 1, 'user_id' => 3, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 2, 'user_id' => 4, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 3, 'user_id' => 5, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 4, 'user_id' => 6, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 5, 'user_id' => 3, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 6, 'user_id' => 4, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 7, 'user_id' => 7, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],
            ['prompt_id' => 8, 'user_id' => 8, 'accion' => 'Creó el prompt', 'descripcion' => 'Prompt creado'],

            // Actividades de edición
            ['prompt_id' => 1, 'user_id' => 3, 'accion' => 'Editó el prompt', 'descripcion' => 'Contenido modificado'],
            ['prompt_id' => 3, 'user_id' => 5, 'accion' => 'Editó el prompt', 'descripcion' => 'Actualización de contenido'],
            ['prompt_id' => 4, 'user_id' => 6, 'accion' => 'Editó el prompt', 'descripcion' => 'Mejoras aplicadas'],
            ['prompt_id' => 2, 'user_id' => 4, 'accion' => 'Editó el prompt', 'descripcion' => 'Corrección de formato'],
            ['prompt_id' => 6, 'user_id' => 4, 'accion' => 'Editó el prompt', 'descripcion' => 'Actualización menor'],

            // Actividades de compartir
            ['prompt_id' => 4, 'user_id' => 6, 'accion' => 'Compartió el prompt', 'descripcion' => 'Compartido con usuario'],
            ['prompt_id' => 8, 'user_id' => 8, 'accion' => 'Compartió el prompt', 'descripcion' => 'Compartido públicamente'],
            ['prompt_id' => 2, 'user_id' => 4, 'accion' => 'Compartió el prompt', 'descripcion' => 'Compartido con equipo'],
            ['prompt_id' => 1, 'user_id' => 3, 'accion' => 'Compartió el prompt', 'descripcion' => 'Compartido con colaborador'],

            // Actividades de versión
            ['prompt_id' => 1, 'user_id' => 3, 'accion' => 'Creó nueva versión', 'descripcion' => 'Versión 2.0'],
            ['prompt_id' => 3, 'user_id' => 5, 'accion' => 'Creó nueva versión', 'descripcion' => 'Versión mejorada'],
            ['prompt_id' => 6, 'user_id' => 4, 'accion' => 'Creó nueva versión', 'descripcion' => 'Versión actualizada'],

            // Actividades de eliminación
            ['prompt_id' => 5, 'user_id' => 3, 'accion' => 'Eliminó versión', 'descripcion' => 'Versión antigua eliminada'],

            // Más actividades variadas
            ['prompt_id' => 1, 'user_id' => 3, 'accion' => 'Marcó como favorito', 'descripcion' => 'Favorito'],
            ['prompt_id' => 6, 'user_id' => 4, 'accion' => 'Marcó como favorito', 'descripcion' => 'Favorito'],
            ['prompt_id' => 3, 'user_id' => 5, 'accion' => 'Usó el prompt', 'descripcion' => 'Copiado'],
            ['prompt_id' => 2, 'user_id' => 5, 'accion' => 'Usó el prompt', 'descripcion' => 'Copiado'],
        ];

        foreach ($actividades as $index => $actividad) {
            Actividad::create(array_merge($actividad, [
                'fecha' => now()->subDays(rand(1, 20))->subHours(rand(0, 23)),
            ]));
        }
    }
}
