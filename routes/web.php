<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromptController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Preparar estadísticas según el rol
    $stats = [];
    
    if ($user->esAdmin()) {
        $stats = [
            'users' => \App\Models\User::count(),
            'students' => \App\Models\User::where('role_id', 2)->count(),
            'teachers' => \App\Models\User::where('role_id', 3)->count(),
            'prompts' => \App\Models\Prompt::count(),
            'categories' => \App\Models\Categoria::count(),
            'tags' => \App\Models\Etiqueta::count(),
            'shared' => \App\Models\Compartido::count(),
            'versions' => \App\Models\Version::count(),
            'recent_users_count' => \App\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
            'active_prompts' => \App\Models\Prompt::where('es_publico', true)->count(),
        ];
    } else {
        $stats = [
            'prompts' => \App\Models\Prompt::where('user_id', $user->id)->count(),
            'categories' => \App\Models\Categoria::count(),
            'tags' => \App\Models\Etiqueta::count(),
            'shared' => \App\Models\Compartido::where('email_destinatario', $user->email)->count(),
            'versions' => \App\Models\Version::whereHas('prompt', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
        ];
    }
    
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Prompts
    Route::resource('prompts', PromptController::class);
    
    // Rutas adicionales de Prompts
    Route::post('/prompts/{prompt}/favorito', [PromptController::class, 'toggleFavorito'])->name('prompts.favorito');
    Route::post('/prompts/{prompt}/uso', [PromptController::class, 'incrementarUso'])->name('prompts.uso');
    Route::post('/prompts/{prompt}/compartir', [PromptController::class, 'compartir'])->name('prompts.compartir');
    Route::get('/prompts/{prompt}/historial', [PromptController::class, 'historial'])->name('prompts.historial');
    Route::post('/prompts/{prompt}/versiones/{version}/restaurar', [PromptController::class, 'restaurarVersion'])->name('prompts.restaurar');
});

require __DIR__.'/auth.php';
