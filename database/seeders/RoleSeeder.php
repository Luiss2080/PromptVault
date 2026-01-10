<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'nombre' => 'admin',
                'descripcion' => 'Administrador con control total del sistema',
                'nivel_acceso' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'user',
                'descripcion' => 'Usuario registrado estándar',
                'nivel_acceso' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'collaborator',
                'descripcion' => 'Usuario colaborador con permisos ampliados',
                'nivel_acceso' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'guest',
                'descripcion' => 'Usuario externo con acceso por token',
                'nivel_acceso' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
