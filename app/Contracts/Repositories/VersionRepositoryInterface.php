<?php

namespace App\Contracts\Repositories;

use App\Models\Version;
use Illuminate\Support\Collection;

interface VersionRepositoryInterface
{
    /**
     * Crear una nueva versión
     */
    public function create(array $data): Version;

    /**
     * Obtener versiones de un prompt
     */
    public function getByPrompt(int $promptId): Collection;

    /**
     * Buscar versión por ID
     */
    public function find(int $id): ?Version;

    /**
     * Obtener última versión de un prompt
     */
    public function getLatestByPrompt(int $promptId): ?Version;
}
