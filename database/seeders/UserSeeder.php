<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Usuario Demo', 'email' => 'user@promptvault.com', 'role_id' => 2],
            ['name' => 'Colaborador Demo', 'email' => 'colaborador@promptvault.com', 'role_id' => 3],
            ['name' => 'Invitado Demo', 'email' => 'invitado@promptvault.com', 'role_id' => 4],
            ['name' => 'Carlos Martínez', 'email' => 'carlos@dev.com', 'role_id' => 2],
            ['name' => 'Ana López', 'email' => 'ana@escritora.com', 'role_id' => 2],
            ['name' => 'Pedro Sánchez', 'email' => 'pedro@ingeniero.com', 'role_id' => 2],
            ['name' => 'María García', 'email' => 'maria@marketing.com', 'role_id' => 2],
            ['name' => 'Luis Rodríguez', 'email' => 'luis@arquitecto.com', 'role_id' => 2],
            ['name' => 'Carmen Torres', 'email' => 'carmen@educadora.com', 'role_id' => 3],
            ['name' => 'Jorge Ramírez', 'email' => 'jorge@analista.com', 'role_id' => 2],
            ['name' => 'Laura Fernández', 'email' => 'laura@disenadora.com', 'role_id' => 3],
            ['name' => 'Roberto Díaz', 'email' => 'roberto@consultor.com', 'role_id' => 2],
            ['name' => 'Isabel Moreno', 'email' => 'isabel@investigadora.com', 'role_id' => 2],
        ];

        foreach ($usuarios as $usuario) {
            User::create([
                'name' => $usuario['name'],
                'email' => $usuario['email'],
                'role_id' => $usuario['role_id'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'cuenta_activa' => true,
            ]);
        }
    }
}
