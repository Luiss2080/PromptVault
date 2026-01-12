<?php

namespace App\Http\Controllers;

use App\Models\AccesoCompartido;
use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prompt::with(['etiquetas', 'user'])
            ->where('user_id', Auth::id());

        // Búsqueda por palabra clave
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                    ->orWhere('contenido', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Filtro por visibilidad
        if ($request->filled('visibilidad')) {
            $query->where('visibilidad', $request->visibilidad);
        }

        // Filtro por etiqueta
        if ($request->filled('etiqueta')) {
            $query->whereHas('etiquetas', function ($q) use ($request) {
                $q->where('nombre', $request->etiqueta);
            });
        }

        // Ordenamiento
        $orden = $request->get('orden', 'reciente');
        switch ($orden) {
            case 'titulo':
                $query->orderBy('titulo');
                break;
            case 'vistas':
                $query->orderBy('conteo_vistas', 'desc');
                break;
            case 'calificacion':
                $query->orderBy('promedio_calificacion', 'desc');
                break;
            default:
                $query->latest();
        }

        $prompts = $query->paginate(15);
        $etiquetas = Etiqueta::all();

        return view('prompts.index', compact('prompts', 'etiquetas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etiquetas = Etiqueta::all();

        return view('prompts.create', compact('etiquetas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'in:privado,publico,enlace',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

        $prompt = Prompt::create([
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
            'descripcion' => $validated['descripcion'] ?? null,
            'visibilidad' => $validated['visibilidad'] ?? 'privado',
            'version_actual' => 1,
        ]);

        // Asignar etiquetas
        if ($request->filled('etiquetas')) {
            $prompt->etiquetas()->attach($request->etiquetas);
        }

        // Crear primera versión
        Version::create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => $prompt->contenido,
            'mensaje_cambio' => 'Versión inicial',
        ]);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prompt $prompt)
    {
        $this->authorize('view', $prompt);

        // Incrementar vistas
        $prompt->incrementarVistas();

        $prompt->load(['etiquetas', 'versiones', 'accesosCompartidos.user', 'comentarios.user', 'calificaciones.user']);

        return view('prompts.show', compact('prompt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $etiquetas = Etiqueta::all();

        return view('prompts.edit', compact('prompt', 'etiquetas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $validated = $request->validate([
            'titulo' => 'required|string|max:150',
            'contenido' => 'required|string',
            'descripcion' => 'nullable|string',
            'visibilidad' => 'in:privado,publico,enlace',
            'etiquetas' => 'array',
            'etiquetas.*' => 'exists:etiquetas,id',
            'mensaje_cambio' => 'nullable|string|max:255',
        ]);

        // Verificar si el contenido cambió para crear nueva versión
        $contenidoCambio = $prompt->contenido !== $validated['contenido'];

        if ($contenidoCambio) {
            // Crear nueva versión
            $prompt->version_actual++;
            Version::create([
                'prompt_id' => $prompt->id,
                'numero_version' => $prompt->version_actual,
                'contenido' => $validated['contenido'],
                'mensaje_cambio' => $validated['mensaje_cambio'] ?? null,
            ]);
        }

        $prompt->update([
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
            'descripcion' => $validated['descripcion'] ?? null,
            'visibilidad' => $validated['visibilidad'] ?? 'privado',
        ]);

        // Actualizar etiquetas
        if ($request->has('etiquetas')) {
            $prompt->etiquetas()->sync($request->etiquetas);
        }

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prompt $prompt)
    {
        $this->authorize('delete', $prompt);

        $prompt->delete();

        return redirect()->route('prompts.index')
            ->with('success', 'Prompt eliminado exitosamente');
    }

    /**
     * Compartir prompt con un usuario
     */
    public function compartir(Request $request, Prompt $prompt)
    {
        $this->authorize('update', $prompt);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'nivel_acceso' => 'required|in:lector,comentador,editor',
        ]);

        $usuario = User::where('email', $validated['email'])->first();

        // Verificar que no sea el propietario
        if ($usuario->id === $prompt->user_id) {
            return back()->with('error', 'No puedes compartir contigo mismo');
        }

        // Crear o actualizar acceso
        AccesoCompartido::updateOrCreate(
            ['prompt_id' => $prompt->id, 'user_id' => $usuario->id],
            ['nivel_acceso' => $validated['nivel_acceso']]
        );

        return back()->with('success', "Prompt compartido con {$usuario->name}");
    }

    /**
     * Eliminar acceso compartido
     */
    public function quitarAcceso(Prompt $prompt, User $user)
    {
        $this->authorize('update', $prompt);

        AccesoCompartido::where('prompt_id', $prompt->id)
            ->where('user_id', $user->id)
            ->delete();

        return back()->with('success', 'Acceso removido');
    }

    /**
     * Ver historial de versiones
     */
    public function historial(Prompt $prompt)
    {
        $this->authorize('view', $prompt);

        $versiones = $prompt->versiones()
            ->orderBy('numero_version', 'desc')
            ->paginate(20);

        return view('prompts.historial', compact('prompt', 'versiones'));
    }

    /**
     * Restaurar una versión específica
     */
    public function restaurarVersion(Prompt $prompt, Version $version)
    {
        $this->authorize('update', $prompt);

        if ($version->prompt_id !== $prompt->id) {
            abort(403);
        }

        // Crear nueva versión con el contenido restaurado
        $prompt->version_actual++;
        Version::create([
            'prompt_id' => $prompt->id,
            'numero_version' => $prompt->version_actual,
            'contenido' => $version->contenido,
            'mensaje_cambio' => "Restaurado desde versión {$version->numero_version}",
        ]);

        $prompt->update([
            'contenido' => $version->contenido,
        ]);

        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Versión restaurada exitosamente');
    }

    /**
     * Prompts compartidos conmigo
     */
    public function compartidosConmigo()
    {
        $prompts = Auth::user()->promptsCompartidos()
            ->with(['user', 'etiquetas'])
            ->paginate(15);

        return view('prompts.compartidos', compact('prompts'));
    }
}
