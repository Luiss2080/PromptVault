<?php

namespace App\Providers;

use App\Contracts\Repositories\EtiquetaRepositoryInterface;
use App\Contracts\Repositories\PromptRepositoryInterface;
use App\Contracts\Repositories\VersionRepositoryInterface;
use App\Contracts\Services\CompartirServiceInterface;
use App\Contracts\Services\PromptServiceInterface;
use App\Repositories\EtiquetaRepository;
use App\Repositories\PromptRepository;
use App\Repositories\VersionRepository;
use App\Services\CompartirService;
use App\Services\PromptService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(PromptRepositoryInterface::class, PromptRepository::class);
        $this->app->bind(EtiquetaRepositoryInterface::class, EtiquetaRepository::class);
        $this->app->bind(VersionRepositoryInterface::class, VersionRepository::class);

        // Services
        $this->app->bind(PromptServiceInterface::class, PromptService::class);
        $this->app->bind(CompartirServiceInterface::class, CompartirService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
