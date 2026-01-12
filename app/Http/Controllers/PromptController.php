<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\EtiquetaRepositoryInterface;
use App\Contracts\Services\CompartirServiceInterface;
use App\Contracts\Services\PromptServiceInterface;
use App\Http\Requests\Prompt\CompartirPromptRequest;
use App\Http\Requests\Prompt\StorePromptRequest;
use App\Http\Requests\Prompt\UpdatePromptRequest;
use App\Models\Prompt;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromptController extends Controller
{
    public function __construct(
        private PromptServiceInterface $promptService,
        private CompartirServiceInterface $compartirService,
        private EtiquetaRepositoryInterface $etiquetaRepository
    ) {}

    /**
     * Lista de prompts del usuario autenticado
     */
    public function index(Request $request)
    {
        // Obtener filtros del request
        $filters = [
            'buscar' => $request->get('buscar'),
            'etiqueta' => $request->get('etiqueta'),
            'visibilidad' => $request->get('visibilidad'),
            'orden' => $request->get('orden', 'reciente'),
            'solo_mios' => true,
        ];

        // Usar servicio
        $prompts = $this->promptService->listar(Auth::user(), 15, $filters);
        $etiquetas = $this->etiquetaRepository->all();

        // Retornar vista
        return view('prompts.index', compact('prompts', 'etiquetas'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        // Obtener datos
        $etiquetas = $this->etiquetaRepository->all();

        // Retornar vista
        return view('prompts.create', compact('etiquetas'));
    }

    /**
     * Guardar nuevo prompt
     */
    public function store(StorePromptRequest $request)
    {
        // Autorización: manejada en StorePromptRequest::authorize()
        // Validación: manejada en StorePromptRequest::rules()

        // Obtener datos validados
        $data = $request->validated();

        // Usar servicio
        $prompt = $this->promptService->crear($request->user(), $data);

        // Retornar vista
        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt creado exitosamente');
    }

    /**
     * Mostrar un prompt
     */
    public function show(Prompt $prompt)
    {
        // Autorización manual (no hay FormRequest para show)
        $this->authorize('view', $prompt);

        // Usar servicio
        $this->promptService->incrementarVistas($prompt);

        // Obtener datos
        $prompt->load(['etiquetas', 'versiones', 'accesosCompartidos.user', 'comentarios.user', 'calificaciones.user']);

        // Retornar vista
        return view('prompts.show', compact('prompt'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Prompt $prompt)
    {
        // Autorización manual
        $this->authorize('update', $prompt);

        // Obtener datos
        $etiquetas = $this->etiquetaRepository->all();

        // Retornar vista
        return view('prompts.edit', compact('prompt', 'etiquetas'));
    }

    /**
     * Actualizar prompt
     */
    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {
        // Autorización: manejada en UpdatePromptRequest::authorize()
        // Validación: manejada en UpdatePromptRequest::rules()

        // Obtener datos validados
        $data = $request->validated();

        // Usar servicio
        $this->promptService->actualizar($prompt, $data);

        // Retornar vista
        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Prompt actualizado exitosamente');
    }

    /**
     * Eliminar prompt
     */
    public function destroy(Prompt $prompt)
    {
        // Autorización manual
        $this->authorize('delete', $prompt);

        // Usar servicio
        $this->promptService->eliminar($prompt);

        // Retornar vista
        return redirect()->route('prompts.index')
            ->with('success', 'Prompt eliminado exitosamente');
    }

    /**
     * Compartir prompt con un usuario
     */
    public function compartir(CompartirPromptRequest $request, Prompt $prompt)
    {
        // Autorización: manejada en CompartirPromptRequest::authorize()
        // Validación: manejada en CompartirPromptRequest::rules()

        // Obtener datos validados
        $data = $request->validated();

        // Obtener usuario
        $usuario = User::where('email', $data['email'])->first();

        // Validar que no sea el propietario
        if ($usuario->id === $prompt->user_id) {
            return back()->with('error', 'No puedes compartir contigo mismo');
        }

        // Usar servicio
        $this->compartirService->compartir($prompt, $usuario, $data['nivel_acceso']);

        // Retornar vista
        return back()->with('success', "Prompt compartido con {$usuario->name}");
    }

    /**
     * Quitar acceso a un usuario
     */
    public function quitarAcceso(Prompt $prompt, User $user)
    {
        // Autorización manual
        $this->authorize('share', $prompt);

        // Usar servicio
        $this->compartirService->quitarAcceso($prompt, $user);

        // Retornar vista
        return back()->with('success', 'Acceso removido');
    }

    /**
     * Ver historial de versiones
     */
    public function historial(Prompt $prompt)
    {
        // Autorización manual
        $this->authorize('view', $prompt);

        // Obtener datos
        $versiones = $prompt->versiones()
            ->orderBy('numero_version', 'desc')
            ->paginate(20);

        // Retornar vista
        return view('prompts.historial', compact('prompt', 'versiones'));
    }

    /**
     * Restaurar una versión
     */
    public function restaurarVersion(Prompt $prompt, Version $version)
    {
        // Autorización manual
        $this->authorize('update', $prompt);

        // Validar
        if ($version->prompt_id !== $prompt->id) {
            abort(403);
        }

        // Usar servicio
        $this->promptService->actualizar($prompt, [
            'contenido' => $version->contenido,
            'mensaje_cambio' => "Restaurado desde versión {$version->numero_version}",
        ]);

        // Retornar vista
        return redirect()->route('prompts.show', $prompt)
            ->with('success', 'Versión restaurada exitosamente');
    }

    /**
     * Prompts compartidos conmigo
     */
    public function compartidosConmigo(Request $request)
    {
        // Obtener filtros
        $filters = [
            'compartidos_conmigo' => true,
            'orden' => $request->get('orden', 'reciente'),
        ];

        // Usar servicio
        $prompts = $this->promptService->listar(Auth::user(), 15, $filters);

        // Retornar vista
        return view('prompts.compartidos', compact('prompts'));
    }
}
