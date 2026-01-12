<?php

namespace App\Repositories;

use App\Contracts\Repositories\VersionRepositoryInterface;
use App\Models\Version;
use Illuminate\Support\Collection;

class VersionRepository implements VersionRepositoryInterface
{
    public function create(array $data): Version
    {
        return Version::create($data);
    }

    public function getByPrompt(int $promptId): Collection
    {
        return Version::where('prompt_id', $promptId)
            ->orderBy('numero_version', 'desc')
            ->get();
    }

    public function find(int $id): ?Version
    {
        return Version::find($id);
    }

    public function getLatestByPrompt(int $promptId): ?Version
    {
        return Version::where('prompt_id', $promptId)
            ->orderBy('numero_version', 'desc')
            ->first();
    }
}
