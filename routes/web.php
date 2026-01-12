<?php

use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Preparar estadísticas según el rol
    $stats = [];

    if ($user->esAdmin()) {
        $stats = [
            'users' => \App\Models\User::count(),
            'prompts' => \App\Models\Prompt::count(),
            'tags' => \App\Models\Etiqueta::count(),
            'shared' => \App\Models\AccesoCompartido::count(),
            'versions' => \App\Models\Version::count(),
            'comments' => \App\Models\Comentario::count(),
            'ratings' => \App\Models\Calificacion::count(),
            'recent_users_count' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
            'public_prompts' => \App\Models\Prompt::where('visibilidad', 'publico')->count(),
        ];
        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentUsers'));
    } elseif ($user->role && in_array($user->role->nombre, ['user', 'collaborator'])) {
        $stats = [
            'prompts' => \App\Models\Prompt::where('user_id', $user->id)->count(),
            'tags' => \App\Models\Etiqueta::count(),
            'shared_with_me' => $user->promptsCompartidos()->count(),
            'my_shares' => \App\Models\AccesoCompartido::whereHas('prompt', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
            'versions' => \App\Models\Version::whereHas('prompt', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
        ];

        return view('dashboard', compact('stats'));
    } else {
        // Guest
        $stats = [
            'prompts' => \App\Models\Prompt::where('visibilidad', 'publico')->count(),
            'tags' => \App\Models\Etiqueta::count(),
        ];
        $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentUsers'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/seguridad', [PerfilController::class, 'cambiarPassword'])->name('perfil.security');
    Route::post('/perfil/password', [PerfilController::class, 'actualizarPassword'])->name('perfil.password');
    Route::post('/perfil/avatar', [PerfilController::class, 'subirAvatar'])->name('perfil.avatar');

    // Rutas de Prompts
    Route::resource('prompts', PromptController::class);

    // Rutas adicionales de Prompts
    Route::post('/prompts/{prompt}/compartir', [PromptController::class, 'compartir'])->name('prompts.compartir');
    Route::delete('/prompts/{prompt}/acceso/{user}', [PromptController::class, 'quitarAcceso'])->name('prompts.quitarAcceso');
    Route::get('/prompts/{prompt}/historial', [PromptController::class, 'historial'])->name('prompts.historial');
    Route::post('/prompts/{prompt}/versiones/{version}/restaurar', [PromptController::class, 'restaurarVersion'])->name('prompts.restaurar');
    Route::get('/compartidos-conmigo', [PromptController::class, 'compartidosConmigo'])->name('prompts.compartidosConmigo');

    // Rutas de Calendario
    Route::resource('calendario', CalendarioController::class);

    // Rutas de Buscador
    Route::get('buscador', [BuscadorController::class, 'search'])->name('buscador.index');
    Route::get('buscador/search', [BuscadorController::class, 'search'])->name('buscador.search');

    // Rutas de Configuraciones
    Route::get('configuraciones', [ConfiguracionesController::class, 'index'])->name('configuraciones.index');
    Route::get('configuraciones/general', [ConfiguracionesController::class, 'general'])->name('configuraciones.general');
    Route::get('configuraciones/seguridad', [ConfiguracionesController::class, 'seguridad'])->name('configuraciones.seguridad');
    Route::get('configuraciones/notificaciones', [ConfiguracionesController::class, 'notificaciones'])->name('configuraciones.notificaciones');
    Route::get('configuraciones/apariencia', [ConfiguracionesController::class, 'apariencia'])->name('configuraciones.apariencia');
    Route::get('configuraciones/sistema', [ConfiguracionesController::class, 'sistema'])->name('configuraciones.sistema');
    Route::get('configuraciones/respaldos', [ConfiguracionesController::class, 'respaldos'])->name('configuraciones.respaldos');
    Route::post('configuraciones/update', [ConfiguracionesController::class, 'update'])->name('configuraciones.update');

    // Rutas de Administración de Usuarios (solo admin)
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class);
    });
});

require __DIR__.'/auth.php';
