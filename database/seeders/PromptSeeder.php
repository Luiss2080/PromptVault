<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prompt;
use Illuminate\Support\Facades\DB;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompts = [
            [
                'user_id' => 3,
                'categoria_id' => 1,
                'titulo' => 'Revisar código Python',
                'contenido' => 'Analiza el siguiente código Python y sugiere mejoras en rendimiento y legibilidad. Identifica posibles bugs y propón soluciones.',
                'descripcion' => 'Prompt para revisión de código',
                'ia_destino' => 'ChatGPT',
                'es_favorito' => true,
                'veces_usado' => 5,
            ],
            [
                'user_id' => 4,
                'categoria_id' => 2,
                'titulo' => 'Redactar informe técnico',
                'contenido' => 'Crea un informe técnico profesional sobre [TEMA] con estructura: resumen ejecutivo, introducción, análisis, conclusiones y recomendaciones.',
                'descripcion' => 'Estructura para informes técnicos',
                'ia_destino' => 'Claude',
                'es_publico' => true,
                'veces_usado' => 12,
            ],
            [
                'user_id' => 5,
                'categoria_id' => 1,
                'titulo' => 'Crear API REST Laravel',
                'contenido' => 'Genera el código para una API REST en Laravel con autenticación JWT, CRUD completo para [ENTIDAD] y validaciones.',
                'descripcion' => 'Generador de APIs REST',
                'ia_destino' => 'ChatGPT',
                'es_favorito' => true,
                'veces_usado' => 8,
            ],
            [
                'user_id' => 6,
                'categoria_id' => 4,
                'titulo' => 'Estrategia redes sociales',
                'contenido' => 'Diseña una estrategia de contenido para redes sociales dirigida a [PÚBLICO OBJETIVO] con calendario mensual y métricas clave.',
                'descripcion' => 'Planificación de marketing digital',
                'ia_destino' => 'Gemini',
                'es_publico' => true,
                'veces_usado' => 15,
            ],
            [
                'user_id' => 3,
                'categoria_id' => 1,
                'titulo' => 'Optimizar consultas SQL',
                'contenido' => 'Revisa estas consultas SQL y optimízalas para mejorar el rendimiento. Sugiere índices apropiados y explica cada mejora.',
                'descripcion' => 'Optimización de base de datos',
                'ia_destino' => 'Claude',
                'veces_usado' => 3,
            ],
            [
                'user_id' => 4,
                'categoria_id' => 2,
                'titulo' => 'Manual de usuario',
                'contenido' => 'Redacta un manual de usuario para [SOFTWARE] con guía paso a paso, capturas y solución de problemas comunes.',
                'descripcion' => 'Documentación técnica',
                'ia_destino' => 'ChatGPT',
                'es_favorito' => true,
                'veces_usado' => 7,
            ],
            [
                'user_id' => 7,
                'categoria_id' => 6,
                'titulo' => 'Diseño de interfaz web',
                'contenido' => 'Crea wireframes y mockups para una interfaz web moderna con enfoque en UX/UI. Incluye paleta de colores y tipografía.',
                'descripcion' => 'Diseño UI/UX',
                'ia_destino' => 'Gemini',
                'veces_usado' => 4,
            ],
            [
                'user_id' => 8,
                'categoria_id' => 5,
                'titulo' => 'Plan de clase interactivo',
                'contenido' => 'Desarrolla un plan de clase de 45 minutos sobre [TEMA] con actividades interactivas y evaluación formativa.',
                'descripcion' => 'Planificación educativa',
                'ia_destino' => 'Claude',
                'es_publico' => true,
                'veces_usado' => 10,
            ],
            [
                'user_id' => 9,
                'categoria_id' => 3,
                'titulo' => 'Análisis de datos ventas',
                'contenido' => 'Analiza el conjunto de datos de ventas y genera insights clave. Incluye tendencias, patrones y recomendaciones.',
                'descripcion' => 'Análisis estadístico',
                'ia_destino' => 'ChatGPT',
                'veces_usado' => 6,
            ],
            [
                'user_id' => 5,
                'categoria_id' => 1,
                'titulo' => 'Tests unitarios automáticos',
                'contenido' => 'Genera tests unitarios completos para la clase [NOMBRE] usando PHPUnit. Incluye casos edge y mocks necesarios.',
                'descripcion' => 'Testing automatizado',
                'ia_destino' => 'Claude',
                'es_favorito' => true,
                'veces_usado' => 9,
            ],
        ];

        foreach ($prompts as $index => $promptData) {
            $prompt = Prompt::create(array_merge($promptData, [
                'fecha_creacion' => now()->subDays(rand(1, 30)),
                'version_actual' => 1,
            ]));

            // Asignar etiquetas aleatorias
            $etiquetas = DB::table('etiquetas')->inRandomOrder()->limit(rand(2, 4))->pluck('id');
            $prompt->etiquetas()->attach($etiquetas);
        }
    }
}
