<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero crear roles y permisos
        $this->call([
            RoleSeeder::class,
            PermisoSeeder::class,
            CategoriaSeeder::class,
            EtiquetaSeeder::class,
        ]);

        // Luego crear usuarios con roles asignados
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@promptvault.com',
            'role_id' => 1, // Admin
        ]);

        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'user@promptvault.com',
            'role_id' => 2, // User
        ]);
    }
}
