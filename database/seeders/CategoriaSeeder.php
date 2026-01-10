<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Programación',
                'descripcion' => 'Prompts relacionados con desarrollo de software, código y debugging',
                'color' => '#3B82F6',
            ],
            [
                'nombre' => 'Redacción',
                'descripcion' => 'Prompts para escritura creativa, copywriting y contenido',
                'color' => '#10B981',
            ],
            [
                'nombre' => 'Análisis de datos',
                'descripcion' => 'Prompts para análisis, interpretación y visualización de datos',
                'color' => '#F59E0B',
            ],
            [
                'nombre' => 'Marketing',
                'descripcion' => 'Prompts para estrategias de marketing y publicidad',
                'color' => '#EC4899',
            ],
            [
                'nombre' => 'Educación',
                'descripcion' => 'Prompts para enseñanza y aprendizaje',
                'color' => '#8B5CF6',
            ],
            [
                'nombre' => 'Diseño',
                'descripcion' => 'Prompts para diseño gráfico, UI/UX y creatividad visual',
                'color' => '#EF4444',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
