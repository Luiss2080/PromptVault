<?php

namespace Database\Seeders;

use App\Models\Compartido;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compartidos = [
            [
                'prompt_id' => 2,
                'nombre_destinatario' => 'Pedro Sánchez',
                'email_destinatario' => 'pedro@ingeniero.com',
                'tipo_acceso' => 'puede_editar',
                'notas' => 'Compartido para revisión',
            ],
            [
                'prompt_id' => 4,
                'nombre_destinatario' => 'Laura Fernández',
                'email_destinatario' => 'laura@disenadora.com',
                'tipo_acceso' => 'puede_copiar',
                'notas' => 'Para referencia de diseño',
            ],
            [
                'prompt_id' => 8,
                'nombre_destinatario' => 'Carlos Martínez',
                'email_destinatario' => 'carlos@dev.com',
                'tipo_acceso' => 'solo_lectura',
                'token' => Str::uuid(),
                'fecha_expiracion' => now()->addDays(30),
            ],
            [
                'prompt_id' => 1,
                'nombre_destinatario' => 'Ana López',
                'email_destinatario' => 'ana@escritora.com',
                'tipo_acceso' => 'puede_editar',
                'notas' => 'Colaboración en proyecto',
            ],
            [
                'prompt_id' => 6,
                'nombre_destinatario' => 'Jorge Ramírez',
                'email_destinatario' => 'jorge@analista.com',
                'tipo_acceso' => 'puede_copiar',
            ],
            [
                'prompt_id' => 3,
                'nombre_destinatario' => 'Externa Cliente',
                'email_destinatario' => 'cliente@empresa.com',
                'tipo_acceso' => 'solo_lectura',
                'token' => Str::uuid(),
                'fecha_expiracion' => now()->addDays(7),
                'requiere_autenticacion' => false,
            ],
            [
                'prompt_id' => 10,
                'nombre_destinatario' => 'Isabel Moreno',
                'email_destinatario' => 'isabel@investigadora.com',
                'tipo_acceso' => 'puede_editar',
                'notas' => 'Proyecto conjunto',
            ],
            [
                'prompt_id' => 4,
                'nombre_destinatario' => 'Roberto Díaz',
                'email_destinatario' => 'roberto@consultor.com',
                'tipo_acceso' => 'puede_copiar',
            ],
            [
                'prompt_id' => 7,
                'nombre_destinatario' => 'Externo Freelance',
                'email_destinatario' => 'freelance@design.com',
                'tipo_acceso' => 'solo_lectura',
                'token' => Str::uuid(),
                'fecha_expiracion' => now()->addDays(15),
            ],
            [
                'prompt_id' => 9,
                'nombre_destinatario' => 'Carmen Torres',
                'email_destinatario' => 'carmen@educadora.com',
                'tipo_acceso' => 'puede_editar',
                'notas' => 'Compartido para adaptación educativa',
            ],
        ];

        foreach ($compartidos as $compartido) {
            Compartido::create(array_merge($compartido, [
                'fecha_compartido' => now()->subDays(rand(1, 20)),
                'veces_accedido' => rand(0, 5),
            ]));
        }
    }
}
