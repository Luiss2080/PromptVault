<?php

namespace App\Providers;

use App\Http\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Composer para sidebars - inyecta estadísticas
        View::composer(
            ['layouts.sidebar', 'layouts.sidebarAdmin'],
            SidebarComposer::class
        );
    }
}
