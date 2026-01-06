<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Version;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $versiones = [
            [
                'prompt_id' => 1,
                'numero' => 1,
                'contenido' => 'Analiza el siguiente código Python y sugiere mejoras en rendimiento y legibilidad. Identifica posibles bugs y propón soluciones.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 2,
                'numero' => 1,
                'contenido' => 'Crea un informe técnico profesional sobre [TEMA] con estructura: resumen ejecutivo, introducción, análisis, conclusiones y recomendaciones.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 3,
                'numero' => 1,
                'contenido' => 'Genera el código para una API REST en Laravel con autenticación JWT, CRUD completo para [ENTIDAD] y validaciones.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 1,
                'numero' => 2,
                'contenido' => 'Analiza el siguiente código Python y sugiere mejoras en rendimiento, legibilidad y mantenibilidad. Identifica bugs, code smells y propón soluciones con ejemplos.',
                'contenido_anterior' => 'Analiza el siguiente código Python y sugiere mejoras en rendimiento y legibilidad. Identifica posibles bugs y propón soluciones.',
                'motivo_cambio' => 'Agregado análisis de mantenibilidad',
            ],
            [
                'prompt_id' => 4,
                'numero' => 1,
                'contenido' => 'Diseña una estrategia de contenido para redes sociales dirigida a [PÚBLICO OBJETIVO] con calendario mensual y métricas clave.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 5,
                'numero' => 1,
                'contenido' => 'Revisa estas consultas SQL y optimízalas para mejorar el rendimiento. Sugiere índices apropiados y explica cada mejora.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 6,
                'numero' => 1,
                'contenido' => 'Redacta un manual de usuario para [SOFTWARE] con guía paso a paso, capturas y solución de problemas comunes.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 3,
                'numero' => 2,
                'contenido' => 'Genera el código para una API REST en Laravel 11 con autenticación Sanctum, CRUD completo para [ENTIDAD], validaciones y tests.',
                'contenido_anterior' => 'Genera el código para una API REST en Laravel con autenticación JWT, CRUD completo para [ENTIDAD] y validaciones.',
                'motivo_cambio' => 'Actualizado a Laravel 11 y Sanctum',
            ],
            [
                'prompt_id' => 8,
                'numero' => 1,
                'contenido' => 'Desarrolla un plan de clase de 45 minutos sobre [TEMA] con actividades interactivas y evaluación formativa.',
                'motivo_cambio' => 'Versión inicial',
            ],
            [
                'prompt_id' => 10,
                'numero' => 1,
                'contenido' => 'Genera tests unitarios completos para la clase [NOMBRE] usando PHPUnit. Incluye casos edge y mocks necesarios.',
                'motivo_cambio' => 'Versión inicial',
            ],
        ];

        foreach ($versiones as $version) {
            Version::create(array_merge($version, [
                'fecha_version' => now()->subDays(rand(1, 25)),
            ]));
        }
    }
}
