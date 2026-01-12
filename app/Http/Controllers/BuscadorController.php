<?php

namespace App\Http\Controllers;

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

        if (strlen($query) < 2) {
            return response()->json(['resultados' => []]);
        }

        // Buscar en Prompts (solo públicos o propios)
        $prompts = Prompt::where(function ($q) use ($query) {
            $q->where('titulo', 'like', "%{$query}%")
                ->orWhere('contenido', 'like', "%{$query}%");
        })
            ->where(function ($q) {
                $q->where('visibilidad', 'publico')
                    ->orWhere('user_id', auth()->id());
            })
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
                    'color' => $etiqueta->color_hex,
                    'url' => route('prompts.index', ['etiqueta' => $etiqueta->nombre]),
                ];
            });

        $resultados = $prompts->concat($etiquetas);

        return response()->json(['resultados' => $resultados]);
    }
}
