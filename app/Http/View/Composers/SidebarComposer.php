<?php

namespace App\Http\View\Composers;

use App\Models\AccesoCompartido;
use App\Models\Calificacion;
use App\Models\Comentario;
use App\Models\Etiqueta;
use App\Models\Prompt;
use App\Models\Role;
use App\Models\User;
use App\Models\Version;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('sidebarStats', [
            'prompts' => Prompt::count(),
            'etiquetas' => Etiqueta::count(),
            'accesos_compartidos' => AccesoCompartido::count(),
            'versiones' => Version::count(),
            'comentarios' => Comentario::count(),
            'calificaciones' => Calificacion::count(),
            'users' => User::count(),
            'roles' => Role::count(),
        ]);
    }
}
