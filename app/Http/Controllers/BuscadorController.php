<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\Prompt;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    /**
     * Búsqueda en tiempo real (AJAX)
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $resultados = [];

        if (strlen($query) < 2) {
            return response()->json(['resultados' => []]);
        }

        // Buscar en Prompts
        $prompts = Prompt::where('titulo', 'like', "%{$query}%")
            ->orWhere('contenido', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($prompt) {
                return [
                    'titulo' => $prompt->titulo,
                    'descripcion' => substr($prompt->descripcion ?? $prompt->contenido, 0, 80),
                    'tipo' => 'Prompt',
                    'icono' => 'file-alt',
                    'url' => route('prompts.show', $prompt->id),
                ];
            });

        // Buscar en Categorías
        $categorias = Categoria::where('nombre', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($categoria) {
                return [
                    'titulo' => $categoria->nombre,
                    'descripcion' => $categoria->descripcion ?? 'Categoría',
                    'tipo' => 'Categoría',
                    'icono' => 'folder',
                    'url' => route('prompts.index', ['categoria' => $categoria->id]),
                ];
            });

        // Buscar en Etiquetas
        $etiquetas = Etiqueta::where('nombre', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($etiqueta) {
                return [
                    'titulo' => $etiqueta->nombre,
                    'descripcion' => 'Etiqueta',
                    'tipo' => 'Etiqueta',
                    'icono' => 'tag',
                    'url' => route('prompts.index', ['etiqueta' => $etiqueta->id]),
                ];
            });
    }
}
