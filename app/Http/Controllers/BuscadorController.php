<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt;
use App\Models\Categoria;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
                    'url' => route('prompts.show', $prompt->id)
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
                    'url' => route('prompts.index', ['categoria' => $categoria->id])
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
                    'url' => route('prompts.index', ['etiqueta' => $etiqueta->id])
                ];
            });
        
        // Vistas y opciones del sistema (solo admin)
        $vistas = [];
        if (auth()->user()->esAdmin()) {
            $rutasSistema = [
                ['titulo' => 'Dashboard', 'url' => route('dashboard'), 'tipo' => 'Vista'],
                ['titulo' => 'Prompts', 'url' => route('prompts.index'), 'tipo' => 'Vista'],
                ['titulo' => 'Crear Prompt', 'url' => route('prompts.create'), 'tipo' => 'Vista'],
                ['titulo' => 'Calendario', 'url' => route('calendario.index'), 'tipo' => 'Vista'],
                ['titulo' => 'Configuraciones', 'url' => route('configuraciones.index'), 'tipo' => 'Vista'],
                ['titulo' => 'Usuarios', 'url' => '#', 'tipo' => 'Vista'],
                ['titulo' => 'Categorías', 'url' => '#', 'tipo' => 'Vista'],
                ['titulo' => 'Etiquetas', 'url' => '#', 'tipo' => 'Vista'],
            ];
            
            $vistas = collect($rutasSistema)->filter(function ($item) use ($query) {
                return stripos($item['titulo'], $query) !== false;
            })->map(function ($item) {
                return [
                    'titulo' => $item['titulo'],
                    'descripcion' => 'Ir a ' . $item['titulo'],
                    'tipo' => $item['tipo'],
                    'icono' => 'desktop',
                    'url' => $item['url']
                ];
            })->take(5)->values();
        }
        
        // Combinar resultados
        $resultados = $vistas->concat($prompts)->concat($categorias)->concat($etiquetas)->take(10);
        
        return response()->json(['resultados' => $resultados]);
    }
    
    public function index(Request $request)
    {
        $query = $request->input('query');
        $tipos = $request->input('tipos', ['prompts', 'categorias', 'etiquetas', 'usuarios']);
        $orderBy = $request->input('orderBy', 'relevancia');
        
        $resultados = [];
        
        if ($query) {
            // Buscar en Prompts
            if (in_array('prompts', $tipos)) {
                $prompts = Prompt::where('titulo', 'like', "%{$query}%")
                    ->orWhere('contenido', 'like', "%{$query}%")
                    ->orWhere('descripcion', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($prompt) {
                        return [
                            'id' => $prompt->id,
                            'titulo' => $prompt->titulo,
                            'descripcion' => $prompt->descripcion ?? substr($prompt->contenido, 0, 150) . '...',
                            'tipo' => 'Prompt',
                            'icono' => 'file-alt',
                            'enlace' => route('prompts.show', $prompt->id)
                        ];
                    });
                
                if ($prompts->count() > 0) {
                    $resultados['prompts'] = $prompts;
                }
            }
            
            // Buscar en Categorías
            if (in_array('categorias', $tipos)) {
                $categorias = Categoria::where('nombre', 'like', "%{$query}%")
                    ->orWhere('descripcion', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($categoria) {
                        return [
                            'id' => $categoria->id,
                            'titulo' => $categoria->nombre,
                            'descripcion' => $categoria->descripcion ?? 'Sin descripción',
                            'tipo' => 'Categoría',
                            'icono' => 'folder',
                            'enlace' => '#'
                        ];
                    });
                
                if ($categorias->count() > 0) {
                    $resultados['categorias'] = $categorias;
                }
            }
            
            // Buscar en Etiquetas
            if (in_array('etiquetas', $tipos)) {
                $etiquetas = Etiqueta::where('nombre', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($etiqueta) {
                        return [
                            'id' => $etiqueta->id,
                            'titulo' => $etiqueta->nombre,
                            'descripcion' => "Etiqueta del sistema",
                            'tipo' => 'Etiqueta',
                            'icono' => 'tag',
                            'enlace' => '#'
                        ];
                    });
                
                if ($etiquetas->count() > 0) {
                    $resultados['etiquetas'] = $etiquetas;
                }
            }
            
            // Buscar en Usuarios (solo admin)
            if (in_array('usuarios', $tipos) && auth()->user()->esAdmin()) {
                $usuarios = User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(10)
                    ->get()
                    ->map(function ($usuario) {
                        return [
                            'id' => $usuario->id,
                            'titulo' => $usuario->name,
                            'descripcion' => $usuario->email,
                            'tipo' => 'Usuario',
                            'icono' => 'user',
                            'enlace' => '#'
                        ];
                    });
                
                if ($usuarios->count() > 0) {
                    $resultados['usuarios'] = $usuarios;
                }
            }
        }
        
        return view('buscador.index', [
            'query' => $query,
            'resultados' => $resultados,
            'total' => collect($resultados)->flatten(1)->count()
        ]);
    }
}
