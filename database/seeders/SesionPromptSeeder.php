<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SesionPrompt;

class SesionPromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sesiones = [
            [
                'user_id' => 1,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'reciente',
                'filtros_activos' => ['categoria_id' => null, 'favoritos' => false],
                'busquedas_recientes' => ['Laravel', 'Python', 'API'],
            ],
            [
                'user_id' => 2,
                'vista_preferida' => 'lista',
                'orden_preferido' => 'titulo',
                'filtros_activos' => ['favoritos' => true],
                'busquedas_recientes' => ['usuarios', 'auth', 'security'],
            ],
            [
                'user_id' => 3,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'uso',
                'filtros_activos' => ['categoria_id' => 1],
                'busquedas_recientes' => ['código', 'optimización', 'tests'],
            ],
            [
                'user_id' => 4,
                'vista_preferida' => 'lista',
                'orden_preferido' => 'modificacion',
                'filtros_activos' => ['categoria_id' => 2],
                'busquedas_recientes' => ['documento', 'manual', 'informe'],
            ],
            [
                'user_id' => 5,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'reciente',
                'filtros_activos' => ['ia_destino' => 'Claude'],
                'busquedas_recientes' => ['Laravel', 'backend', 'API'],
            ],
            [
                'user_id' => 6,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'uso',
                'filtros_activos' => ['categoria_id' => 4],
                'busquedas_recientes' => ['marketing', 'redes', 'contenido'],
            ],
            [
                'user_id' => 7,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'reciente',
                'filtros_activos' => [],
                'busquedas_recientes' => ['arquitectura', 'planos', 'diseño'],
            ],
            [
                'user_id' => 8,
                'vista_preferida' => 'lista',
                'orden_preferido' => 'titulo',
                'filtros_activos' => ['categoria_id' => 6],
                'busquedas_recientes' => ['UI', 'UX', 'mockup'],
            ],
            [
                'user_id' => 9,
                'vista_preferida' => 'grid',
                'orden_preferido' => 'modificacion',
                'filtros_activos' => ['es_publico' => true],
                'busquedas_recientes' => ['estadística', 'datos', 'gráficos'],
            ],
            [
                'user_id' => 10,
                'vista_preferida' => 'lista',
                'orden_preferido' => 'reciente',
                'filtros_activos' => ['favoritos' => true],
                'busquedas_recientes' => ['SQL', 'base de datos', 'consultas'],
            ],
        ];

        foreach ($sesiones as $sesion) {
            SesionPrompt::create(array_merge($sesion, [
                'fecha_expiracion' => now()->addDays(30),
            ]));
        }
    }
}
