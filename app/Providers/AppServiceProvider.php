<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate para verificar si el usuario es admin
        Gate::define('admin', function ($user) {
            return $user->esAdmin();
        });

        // Gate para verificar permisos específicos
        Gate::define('gestionar-usuarios', function ($user) {
            return $user->esAdmin() || $user->tienePermiso('usuarios.gestionar');
        });
    }
}
