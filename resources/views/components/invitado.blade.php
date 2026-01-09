<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Invitado - PromptVault')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">

    
    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Meta tags -->
    <meta name="description" content="Dashboard administrativo de Tech Home Books. Sistema de gestión educativa.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS del Dashboard -->
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/loading.css') }}">
    
    @stack('styles')
</head>

<body>
    
    <!-- Loading Screen -->
    @include('layouts.loading')
    
    <!-- Layout del Dashboard -->
    <div class="dashboard-layout">
        
        <!-- Sidebar Component -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <div class="main-content">
            
            <!-- Header Component -->
            @include('layouts.header', ['header_title' => $header_title ?? 'Dashboard Admin'])
            
            <!-- Contenido principal -->
            <div class="dashboard-content">
                
                <!-- Stats Section -->
                <!-- Stats Section -->
                <div class="stats-grid">
                    <!-- Users Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['users'] ?? 0 }}</h3>
                                <p class="stat-label">Usuarios</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Nuevos</span>
                                <strong>+{{ $stats['recent_users_count'] ?? $stats['new_users_count'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['users'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Prompts Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ \App\Models\Prompt::count() }}</h3>
                                <p class="stat-label">Prompts</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Publicados</span>
                                <i class="fas fa-check-circle" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ \App\Models\Prompt::count() }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-folder"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ \App\Models\Categoria::count() }}</h3>
                                <p class="stat-label">Categorías</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row">
                                <span>Activas</span>
                                <strong>{{ \App\Models\Categoria::count() }}</strong>
                            </div>
                            <div class="stat-mini-row accent">
                                <span>Organizadas</span>
                                <i class="fas fa-sitemap" style="font-size: 0.8rem;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ \App\Models\Etiqueta::count() }}</h3>
                                <p class="stat-label">Etiquetas</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Recientes</span>
                                <strong>+{{ \App\Models\Etiqueta::latest()->take(5)->count() }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ \App\Models\Etiqueta::count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- LEGACY ANALYTICS SECTION REMOVED -->

                <!-- SECTION: Middle Split (Table + Chart) -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 2rem;" class="dashboard-split-layout">
                    
                    <!-- Left: Recent Users Table (More space) -->
                    <div class="dashboard-card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios Recientes</h3>
                            <a href="#" class="card-action-link" style="color: #fff !important;">Ver todos</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive-compact">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-3"><i class="fas fa-user me-2 text-danger"></i>Usuario</th>
                                            <th class="text-center"><i class="fas fa-user-tag me-2 text-danger"></i>Rol</th>
                                            <th class="text-center"><i class="fas fa-clock me-2 text-danger"></i>Sesión</th>
                                            <th class="text-center"><i class="fas fa-toggle-on me-2 text-danger"></i>Estado</th>
                                            <th class="text-center" style="width: 140px; white-space: nowrap;">ACTIONS <i class="fas fa-cog text-danger ms-1"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        @forelse($recentUsers as $user)
                                            <tr class="hover-scale">
                                                <td class="ps-3">
                                                    <div class="user-info-compact">
                                                        <div class="user-avatar-xs {{ $user->rol === 'admin' ? 'pulse-red' : '' }}">{{ substr($user->name, 0, 1) }}</div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="user-name-styled">{{ $user->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-modern-red">
                                                        @if($user->rol == 'admin') <i class="fas fa-crown"></i>
                                                        @elseif($user->rol == 'docente') <i class="fas fa-chalkboard-teacher"></i>
                                                        @else <i class="fas fa-user-graduate"></i>
                                                        @endif
                                                        {{ ucfirst($user->rol) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="session-time">
                                                        <i class="fas fa-history text-danger me-1"></i> Hace {{ rand(1, 59) }} min
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-modern-status online">
                                                        <span class="status-dot-pulse"></span> Activo
                                                    </span>
                                                </td>
                                                <td class="text-center" style="white-space: nowrap;">
                                                    <div class="action-buttons-row">
                                                        <button class="btn-icon-modern red" title="Editar">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Ver Perfil">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-users-slash mb-2 text-danger" style="font-size: 2rem; opacity: 0.5;"></i>
                                                    <p>No hay usuarios recientes</p>
                                                </div>
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right: User Distribution Chart -->
                    <div class="dashboard-card glow-effect h-100 d-flex flex-column">
                        <div class="card-header border-0 pb-0 flex-shrink-0">
                            <h3 class="card-title">Distribución</h3>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center pt-2 pb-4 flex-grow-1" style="gap: 2rem;">
                            
                            <!-- Chart Area with Center Text -->
                            <div style="width: 220px; height: 220px; position: relative; margin: 0 auto !important;">
                                <canvas id="userRolesChart"></canvas>
                                <div class="chart-center-text">
                                    <span class="total-number">{{ array_sum($roleDistribution ?? []) }}</span>
                                    <span class="total-label">Total</span>
                                </div>
                            </div>


                            <!-- Legend Grid (Compact) -->
                            <div class="legend-grid px-3">
                                @php $total = array_sum($roleDistribution ?? []) ?: 1; @endphp
                                
                                <!-- Admin -->
                                <div class="legend-item-compact">
                                    <div class="legend-box" style="background: #3b82f6;"></div>
                                    <span class="legend-text">Admin <span style="opacity: 0.7;">({{ round(($roleDistribution['admin'] ?? 0) / $total * 100) }}%)</span></span>
                                </div>

                                <!-- Docente -->
                                <div class="legend-item-compact">
                                    <div class="legend-box" style="background: #a855f7;"></div>
                                    <span class="legend-text">Docente <span style="opacity: 0.7;">({{ round(($roleDistribution['docente'] ?? 0) / $total * 100) }}%)</span></span>
                                </div>

                                <!-- Estudiante -->
                                <div class="legend-item-compact">
                                    <div class="legend-box" style="background: #10b981;"></div>
                                    <span class="legend-text">Estud. <span style="opacity: 0.7;">({{ round(($roleDistribution['estudiante'] ?? 0) / $total * 100) }}%)</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Modules Grid (3 Cols) -->
                <!-- SECTION: Analytics Grid (New Design) -->
                <!-- SECTION: Analytics Grid (New Design) -->
                <!-- SECTION: Analytics Grid (New Design) -->
                <div class="analytics-grid" style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
                    
                    <!-- Row 1: Large Charts (Attendance & Activity) -->
                    <div class="analytics-row-1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Prompts Creados -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Prompts Creados</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="attendanceChart" height="250"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Actividad Global -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Actividad Global</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="activityGlobalChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Small Charts (Grades, Resources) -->
                    <div class="analytics-row-2" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Versiones por Prompt -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Versiones por Prompt</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="gradesBarChart" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Prompts Compartidos -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Prompts Compartidos</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="resourcesBarChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Additional Charts -->
                    <div class="analytics-row-3" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Prompts por Categoría -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Prompts por Categoría</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Top 5</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="categoriesChart" height="250"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Usuarios Más Activos -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Usuarios Más Activos</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Top 5</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="activeUsersChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer Component -->
            @include('layouts.footer')
            
        </div>
    </div>
    
    @php
        // Datos para gráficas del dashboard de invitado
        
        // 1. Prompts creados por día (últimos 7 días)
        $promptsPorDia = [];
        for ($i = 6; $i >= 0; $i--) {
            $promptsPorDia[] = \App\Models\Prompt::whereDate('created_at', now()->subDays($i))->count();
        }
        
        // 2. Actividad global por tipo
        $actividadPorTipo = [
            \App\Models\Actividad::where('accion', 'LIKE', '%Creó%')->count(),
            \App\Models\Actividad::where('accion', 'LIKE', '%Editó%')->count(),
            \App\Models\Actividad::where('accion', 'LIKE', '%Compartió%')->count(),
            \App\Models\Actividad::where('accion', 'LIKE', '%versión%')->count(),
            \App\Models\Actividad::where('accion', 'LIKE', '%Eliminó%')->count()
        ];
        
        // 3. Top 5 prompts con más versiones
        $topPromptsVersiones = \App\Models\Prompt::withCount('versiones')
            ->orderByDesc('versiones_count')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'titulo' => \Str::limit($p->titulo, 20),
                'count' => $p->versiones_count
            ]);
        
        // 4. Top 5 prompts más compartidos
        $topPromptsCompartidos = \App\Models\Prompt::withCount('compartidos')
            ->orderByDesc('compartidos_count')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'titulo' => \Str::limit($p->titulo, 20),
                'count' => $p->compartidos_count
            ]);
        
        // 5. Distribución de usuarios por rol
        $roleDistribution = [
            'admin' => \App\Models\User::where('role_id', 1)->count(),
            'docente' => \App\Models\User::where('role_id', 2)->count(),
            'estudiante' => \App\Models\User::where('role_id', 3)->count(),
        ];
        
        // 6. Top 5 categorías con más prompts
        $topCategorias = \App\Models\Categoria::withCount('prompts')
            ->orderByDesc('prompts_count')
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'nombre' => \Str::limit($c->nombre, 20),
                'count' => $c->prompts_count
            ]);
        
        // 7. Top 5 usuarios más activos
        $usuariosActivos = \App\Models\User::withCount('actividades')
            ->orderByDesc('actividades_count')
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'nombre' => \Str::limit($u->name, 20),
                'count' => $u->actividades_count
            ]);
        
        // Consolidar todos los datos en un array
        $guestChartData = [
            'promptsPorDia' => $promptsPorDia,
            'actividadPorTipo' => $actividadPorTipo,
            'topPromptsVersiones' => $topPromptsVersiones,
            'topPromptsCompartidos' => $topPromptsCompartidos,
            'roleDistribution' => $roleDistribution,
            'topCategorias' => $topCategorias,
            'usuariosActivos' => $usuariosActivos
        ];
    @endphp
    
    <div id="guest-chart-data" data-config="{{ json_encode($guestChartData) }}" style="display:none;"></div>

    <!-- Configuración global -->
    <script>
        window.appConfig = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
            user: {
                id: '{{ Auth::id() }}',
                name: '{{ Auth::user()->name ?? "" }}',
                role: '{{ Auth::user()->role->nombre ?? "guest" }}'
            }
        };
    </script>
    
    <!-- JavaScript del Dashboard -->
    <script src="{{ asset('js/components/loading.js') }}"></script>
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('js/components/footer.js') }}"></script>
    
    <!-- Gráficas Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Obtener datos desde el data-attribute
            window.guestChartData = JSON.parse(document.getElementById('guest-chart-data').getAttribute('data-config'));
            
            // Gráfico 1: Prompts Creados por Día
            const ctxAttendance = document.getElementById('attendanceChart');
            if (ctxAttendance) {
                new Chart(ctxAttendance, {
                    type: 'line',
                    data: {
                        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                        datasets: [{
                            label: 'Prompts Creados',
                            data: window.guestChartData.promptsPorDia,
                            borderColor: '#e11d48',
                            backgroundColor: 'rgba(225, 29, 72, 0.1)',
                            tension: 0.4,
                            fill: true,
                            borderWidth: 3,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Gráfico 2: Actividad Global por Tipo
            const ctxActivity = document.getElementById('activityGlobalChart');
            if (ctxActivity) {
                new Chart(ctxActivity, {
                    type: 'bar',
                    data: {
                        labels: ['Creación', 'Edición', 'Compartir', 'Versión', 'Eliminación'],
                        datasets: [{
                            label: 'Actividades',
                            data: window.guestChartData.actividadPorTipo,
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Gráfico 3: Versiones por Prompt (Top 5)
            const ctxGrades = document.getElementById('gradesBarChart');
            if (ctxGrades) {
                new Chart(ctxGrades, {
                    type: 'bar',
                    data: {
                        labels: window.guestChartData.topPromptsVersiones.map(p => p.titulo),
                        datasets: [{
                            label: 'Versiones',
                            data: window.guestChartData.topPromptsVersiones.map(p => p.count),
                            backgroundColor: '#e11d48',
                            borderRadius: 8,
                            barThickness: 40
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            y: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Gráfico 4: Prompts Compartidos (Top 5)
            const ctxResources = document.getElementById('resourcesBarChart');
            if (ctxResources) {
                new Chart(ctxResources, {
                    type: 'bar',
                    data: {
                        labels: window.guestChartData.topPromptsCompartidos.map(p => p.titulo),
                        datasets: [{
                            label: 'Compartidos',
                            data: window.guestChartData.topPromptsCompartidos.map(p => p.count),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                            borderRadius: 8,
                            barThickness: 40
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        },
                        scales: {
                            x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            y: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Gráfico 5: Distribución de Roles
            const ctxRoles = document.getElementById('userRolesChart');
            if (ctxRoles) {
                new Chart(ctxRoles, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Docente', 'Estudiante'],
                        datasets: [{
                            data: [
                                window.guestChartData.roleDistribution.admin,
                                window.guestChartData.roleDistribution.docente,
                                window.guestChartData.roleDistribution.estudiante
                            ],
                            backgroundColor: ['#3b82f6', '#a855f7', '#10b981'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: { 
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }

            // Gráfico 6: Prompts por Categoría (Top 5)
            const ctxCategories = document.getElementById('categoriesChart');
            if (ctxCategories) {
                new Chart(ctxCategories, {
                    type: 'bar',
                    data: {
                        labels: window.guestChartData.topCategorias.map(c => c.nombre),
                        datasets: [{
                            label: 'Prompts',
                            data: window.guestChartData.topCategorias.map(c => c.count),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                            borderRadius: 8,
                            barThickness: 40
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            y: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }

            // Gráfico 7: Usuarios Más Activos (Top 5)
            const ctxActiveUsers = document.getElementById('activeUsersChart');
            if (ctxActiveUsers) {
                new Chart(ctxActiveUsers, {
                    type: 'bar',
                    data: {
                        labels: window.guestChartData.usuariosActivos.map(u => u.nombre),
                        datasets: [{
                            label: 'Actividades',
                            data: window.guestChartData.usuariosActivos.map(u => u.count),
                            backgroundColor: ['#e11d48', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'],
                            borderRadius: 8,
                            barThickness: 40
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } },
                            y: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                        }
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')

</body>
</html>
