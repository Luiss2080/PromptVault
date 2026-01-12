<?php

namespace App\Services;

use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Contracts\Repositories\VersionRepositoryInterface;
use App\Contracts\Services\PromptServiceInterface;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PromptService implements PromptServiceInterface
{
    public function __construct(
        private PromptRepositoryInterface $promptRepository,
        private VersionRepositoryInterface $versionRepository
    ) {}

    public function listar(?User $user, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $userId = $user?->id;

        return $this->promptRepository->getPrompts($userId, $perPage, $filters);
    }

    public function crear(User $user, array $data): Prompt
    {
        // Crear el prompt usando el repositorio
        $prompt = $this->promptRepository->create([
            'user_id' => $user->id,
            'titulo' => $data['titulo'],
            'contenido' => $data['contenido'],
            'descripcion' => $data['descripcion'] ?? null,
            'visibilidad' => $data['visibilidad'] ?? 'privado',
            'version_actual' => 1,
        ]);

        // Crear primera versión usando el repositorio
        $this->versionRepository->create([
            'prompt_id' => $prompt->id,
            'numero_version' => 1,
            'contenido' => $prompt->contenido,
            'mensaje_cambio' => 'Versión inicial',
        ]);

        // Sincronizar etiquetas si existen
        if (isset($data['etiquetas']) && is_array($data['etiquetas'])) {
            $this->promptRepository->syncEtiquetas($prompt, $data['etiquetas']);
        }

        return $prompt->load('etiquetas');
    }

    public function actualizar(Prompt $prompt, array $data): Prompt
    {
        $contenidoCambio = $prompt->contenido !== ($data['contenido'] ?? $prompt->contenido);

        // Si el contenido cambió, crear nueva versión usando el repositorio
        if ($contenidoCambio) {
            $prompt->version_actual++;

            $this->versionRepository->create([
                'prompt_id' => $prompt->id,
                'numero_version' => $prompt->version_actual,
                'contenido' => $data['contenido'],
                'mensaje_cambio' => $data['mensaje_cambio'] ?? null,
            ]);
        }

        // Actualizar el prompt usando el repositorio
        $this->promptRepository->update($prompt, [
            'titulo' => $data['titulo'] ?? $prompt->titulo,
            'contenido' => $data['contenido'] ?? $prompt->contenido,
            'descripcion' => $data['descripcion'] ?? $prompt->descripcion,
            'visibilidad' => $data['visibilidad'] ?? $prompt->visibilidad,
            'version_actual' => $prompt->version_actual,
        ]);

        // Sincronizar etiquetas si se proporcionaron
        if (isset($data['etiquetas'])) {
            $this->promptRepository->syncEtiquetas($prompt, $data['etiquetas']);
        }

        return $prompt->fresh(['etiquetas']);
    }

    public function eliminar(Prompt $prompt): bool
    {
        return $this->promptRepository->delete($prompt);
    }

    public function incrementarVistas(Prompt $prompt): void
    {
        $prompt->increment('conteo_vistas');
    }
}
