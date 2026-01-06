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
        ]);

        // Luego crear categorías y etiquetas
        $this->call([
            CategoriaSeeder::class,
            EtiquetaSeeder::class,
        ]);

        // Crear usuarios (admin y demo por defecto)
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

        // Crear usuarios adicionales
        $this->call([
            UserSeeder::class,
        ]);

        // Crear prompts y relaciones
        $this->call([
            PromptSeeder::class,
            VersionSeeder::class,
            CompartidoSeeder::class,
            ActividadSeeder::class,
            SesionPromptSeeder::class,
        ]);
    }
}
