<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Colaborador - PromptVault')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">

    
    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Meta tags -->
    <meta name="description" content="Dashboard para colaboradores de PromptVault. Sistema de gestión y colaboración de prompts.">
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
            @include('layouts.header', ['header_title' => $header_title ?? 'Dashboard Colaborador'])
            
            <!-- Contenido principal -->
            <div class="dashboard-content">
                
                <!-- Stats Section -->
                <div class="stats-grid">
                    <!-- Prompts Compartidos Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['prompts_compartidos'] ?? 0 }}</h3>
                                <p class="stat-label">Prompts Compartidos</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Activos</span>
                                <strong>{{ $stats['compartidos_activos'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['prompts_compartidos'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Ediciones Realizadas Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['ediciones_pendientes'] ?? 0 }}</h3>
                                <p class="stat-label">Ediciones Pendientes</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row accent">
                                <span>Por Revisar</span>
                                <strong>{{ $stats['ediciones_pendientes'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row success">
                                <span>Completadas</span>
                                <strong>{{ $stats['ediciones_completadas'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Contribuciones Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['contribuciones_totales'] ?? 0 }}</h3>
                                <p class="stat-label">Contribuciones</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Este Mes</span>
                                <strong>{{ $stats['contribuciones_mes'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['contribuciones_totales'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Revisiones Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ number_format($stats['porcentaje_revisiones'] ?? 0, 0) }}%</h3>
                                <p class="stat-label">Tasa de Revisión</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Aprobadas</span>
                                <strong>{{ $stats['revisiones_aprobadas'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row accent">
                                <span>Pendientes</span>
                                <strong>{{ $stats['revisiones_pendientes'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Middle Split (Prompts Compartidos + Estadísticas) -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 2rem;" class="dashboard-split-layout">
                    
                    <!-- Left: Prompts Compartidos Conmigo Table -->
                    <div class="dashboard-card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Prompts Compartidos Conmigo</h3>
                            <a href="#" class="card-action-link" style="color: #fff !important;">Ver todos</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive-compact">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-3"><i class="fas fa-file-alt me-2 text-danger"></i>Prompt</th>
                                            <th class="text-center"><i class="fas fa-user me-2 text-danger"></i>Compartido por</th>
                                            <th class="text-center"><i class="fas fa-edit me-2 text-danger"></i>Ediciones</th>
                                            <th class="text-center"><i class="fas fa-toggle-on me-2 text-danger"></i>Estado</th>
                                            <th class="text-center" style="width: 140px; white-space: nowrap;">ACTIONS <i class="fas fa-cog text-danger ms-1"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        @forelse($promptsCompartidos ?? [] as $compartido)
                                            <tr class="hover-scale">
                                                <td class="ps-3">
                                                    <div class="user-info-compact">
                                                        <div class="user-avatar-xs">{{ substr($compartido->prompt->titulo ?? 'P', 0, 1) }}</div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="user-name-styled">{{ $compartido->prompt->titulo ?? 'Prompt Sin Título' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="session-time">
                                                        <i class="fas fa-user text-danger me-1"></i> {{ $compartido->usuario_compartio->name ?? 'Usuario' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-modern-red">
                                                        <i class="fas fa-edit"></i>
                                                        {{ $compartido->prompt->versiones_count ?? 0 }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($compartido->permiso_edicion ?? false)
                                                        <span class="badge-modern-status online">
                                                            <span class="status-dot-pulse"></span> Editable
                                                        </span>
                                                    @else
                                                        <span class="badge-modern-status" style="background: rgba(100, 116, 139, 0.15); color: #94a3b8;">
                                                            Solo Lectura
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center" style="white-space: nowrap;">
                                                    <div class="action-buttons-row">
                                                        <button class="btn-icon-modern red" title="Ver Detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Historial">
                                                            <i class="fas fa-history"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-share-alt mb-2 text-danger" style="font-size: 2rem; opacity: 0.5;"></i>
                                                    <p>No tienes prompts compartidos</p>
                                                </div>
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actividad de Colaboración -->
                    <div class="dashboard-card glow-effect h-100 d-flex flex-column">
                        <div class="card-header border-0 pb-0 flex-shrink-0">
                            <h3 class="card-title">Mi Actividad</h3>
                        </div>
                        <div class="card-body flex-grow-1" style="overflow-y: auto;">
                            <div class="horario-list">
                                @forelse($actividadesRecientes ?? [] as $actividad)
                                    <div class="horario-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 15px; margin-bottom: 12px; color: white;">
                                        <div class="horario-time" style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 5px;">
                                            <i class="fas fa-clock me-1"></i> {{ $actividad->created_at->diffForHumans() ?? 'Hace unos minutos' }}
                                        </div>
                                        <div class="horario-materia" style="font-weight: 600; font-size: 1rem; margin-bottom: 5px;">
                                            {{ $actividad->tipo ?? 'Edición realizada' }}
                                        </div>
                                        <div class="horario-aula" style="font-size: 0.85rem; opacity: 0.8;">
                                            <i class="fas fa-file-alt me-1"></i> {{ $actividad->prompt->titulo ?? 'Prompt sin título' }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state text-center py-4">
                                        <i class="fas fa-history mb-2 text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted">No hay actividades recientes</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Analytics Grid -->
                <div class="analytics-grid" style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
                    
                    <!-- Row 1: Large Charts (Ediciones & Contribuciones) -->
                    <div class="analytics-row-1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Ediciones Realizadas -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Ediciones Realizadas</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="edicionesChart" height="250"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Contribuciones por Tipo -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Contribuciones por Tipo</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="contribucionesChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Small Charts (Actividad & Revisiones) -->
                    <div class="analytics-row-2" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Actividad Semanal -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Actividad Semanal</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="actividadChart" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Estado de Revisiones -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Estado de Revisiones</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Todo</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="revisionesChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer Component -->
            @include('layouts.footer')
            
        </div>
    </div>
    
    <!-- Configuración global -->
    <script>
        // @ts-nocheck
        /* eslint-disable */
        window.appConfig = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
            user: {
                id: '{{ session("user_id") }}',
                name: '{{ session("user_name") }}',
                role: '{{ session("user_role") }}'
            }
        };
        window.appConfig.chartData = @json($chartData ?? []);
        /* eslint-enable */
    </script>
    
    <!-- JavaScript del Dashboard -->
    <script src="{{ asset('js/components/loading.js') }}"></script>
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('js/components/footer.js') }}"></script>
    
    @stack('scripts')
    <script src="{{ asset('js/dashboard/colaborador.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfica de Ediciones Realizadas
            const ctxEdiciones = document.getElementById('edicionesChart');
            if (ctxEdiciones) {
                new Chart(ctxEdiciones, {
                    type: 'line',
                    data: {
                        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                        datasets: [{
                            label: 'Ediciones',
                            data: [5, 8, 6, 10, 7, 3, 2],
                            borderColor: '#a855f7',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Gráfica de Contribuciones por Tipo
            const ctxContribuciones = document.getElementById('contribucionesChart');
            if (ctxContribuciones) {
                new Chart(ctxContribuciones, {
                    type: 'bar',
                    data: {
                        labels: ['Nuevos', 'Ediciones', 'Revisiones', 'Comentarios', 'Versiones'],
                        datasets: [{
                            label: 'Contribuciones',
                            data: [12, 25, 18, 32, 15],
                            backgroundColor: '#00b4db'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Gráfica de Actividad Semanal
            const ctxActividad = document.getElementById('actividadChart');
            if (ctxActividad) {
                new Chart(ctxActividad, {
                    type: 'line',
                    data: {
                        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                        datasets: [{
                            label: 'Actividades',
                            data: [15, 22, 18, 25, 20, 12, 8],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Gráfica de Estado de Revisiones
            const ctxRevisiones = document.getElementById('revisionesChart');
            if (ctxRevisiones) {
                new Chart(ctxRevisiones, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aprobadas', 'Pendientes', 'Rechazadas'],
                        datasets: [{
                            data: [75, 20, 5],
                            backgroundColor: ['#10b981', '#f59e0b', '#e11d48']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>