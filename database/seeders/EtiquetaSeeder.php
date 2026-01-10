<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etiquetas = [
            'ChatGPT',
            'Claude',
            'Gemini',
            'Copilot',
            'Python',
            'JavaScript',
            'PHP',
            'Laravel',
            'React',
            'Vue',
            'SQL',
            'API',
            'Testing',
            'Debug',
            'Optimización',
            'SEO',
            'Social Media',
            'Email',
            'Blog',
            'Tutorial',
        ];

        foreach ($etiquetas as $nombre) {
            Etiqueta::create(['nombre' => $nombre]);
        }
    }
}
