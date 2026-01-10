<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            // Administradores
            ['name' => 'Admin Principal', 'email' => 'admin@promptvault.com', 'role_id' => 1],
            ['name' => 'Admin Secundario', 'email' => 'admin2@promptvault.com', 'role_id' => 1],
            ['name' => 'Super Admin', 'email' => 'superadmin@promptvault.com', 'role_id' => 1],

            // Colaboradores
            ['name' => 'Colaborador Demo', 'email' => 'colaborador@promptvault.com', 'role_id' => 3],
            ['name' => 'Carmen Torres', 'email' => 'carmen@educadora.com', 'role_id' => 3],
            ['name' => 'Laura Fernández', 'email' => 'laura@disenadora.com', 'role_id' => 3],
            ['name' => 'Diego Morales', 'email' => 'diego@content.com', 'role_id' => 3],
            ['name' => 'Patricia Ruiz', 'email' => 'patricia@writer.com', 'role_id' => 3],

            // Usuarios normales
            ['name' => 'Carlos Martínez', 'email' => 'carlos@dev.com', 'role_id' => 2],
            ['name' => 'Ana López', 'email' => 'ana@escritora.com', 'role_id' => 2],
            ['name' => 'Pedro Sánchez', 'email' => 'pedro@ingeniero.com', 'role_id' => 2],
            ['name' => 'María García', 'email' => 'maria@marketing.com', 'role_id' => 2],
            ['name' => 'Luis Rodríguez', 'email' => 'luis@arquitecto.com', 'role_id' => 2],
            ['name' => 'Jorge Ramírez', 'email' => 'jorge@analista.com', 'role_id' => 2],
            ['name' => 'Roberto Díaz', 'email' => 'roberto@consultor.com', 'role_id' => 2],
            ['name' => 'Isabel Moreno', 'email' => 'isabel@investigadora.com', 'role_id' => 2],
            ['name' => 'Fernando Silva', 'email' => 'fernando@tech.com', 'role_id' => 2],
            ['name' => 'Sofía Vargas', 'email' => 'sofia@design.com', 'role_id' => 2],
            ['name' => 'Ricardo Castro', 'email' => 'ricardo@sales.com', 'role_id' => 2],
            ['name' => 'Valentina Ortiz', 'email' => 'valentina@pr.com', 'role_id' => 2],
        ];

        foreach ($usuarios as $usuario) {
            User::updateOrCreate(
                ['email' => $usuario['email']],
                [
                    'name' => $usuario['name'],
                    'role_id' => $usuario['role_id'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'cuenta_activa' => true,
                ]
            );
        }
    }
}
