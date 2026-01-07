<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Usuario - PromptVault')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">

    
    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Meta tags -->
    <meta name="description" content="Dashboard para docentes de Tech Home Books. Sistema de gestión educativa.">
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
            @include('layouts.header', ['header_title' => $header_title ?? 'Dashboard Docente'])
            
            <!-- Contenido principal -->
            <div class="dashboard-content">
                
                <!-- Stats Section -->
                <div class="stats-grid">
                    <!-- Materias Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['materias'] ?? 0 }}</h3>
                                <p class="stat-label">Mis Materias</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Activas</span>
                                <strong>{{ $stats['materias_activas'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['materias'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Estudiantes Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['estudiantes'] ?? 0 }}</h3>
                                <p class="stat-label">Estudiantes</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Activos</span>
                                <i class="fas fa-check-circle" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['estudiantes'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Tareas Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ $stats['tareas_pendientes'] ?? 0 }}</h3>
                                <p class="stat-label">Tareas Pendientes</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row accent">
                                <span>Por Revisar</span>
                                <strong>{{ $stats['tareas_pendientes'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Total</span>
                                <strong>{{ $stats['tareas_total'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Calificaciones Card -->
                    <div class="stat-card rich-stat">
                        <div class="stat-left">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="stat-value">{{ number_format($stats['promedio_general'] ?? 0, 1) }}</h3>
                                <p class="stat-label">Promedio General</p>
                            </div>
                        </div>
                        <div class="stat-right">
                            <div class="stat-mini-row success">
                                <span>Calificadas</span>
                                <strong>{{ $stats['calificaciones_realizadas'] ?? 0 }}</strong>
                            </div>
                            <div class="stat-mini-row">
                                <span>Pendientes</span>
                                <strong>{{ $stats['calificaciones_pendientes'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Middle Split (Materias + Horario) -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 2rem;" class="dashboard-split-layout">
                    
                    <!-- Left: Mis Materias Table -->
                    <div class="dashboard-card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Mis Materias</h3>
                            <a href="#" class="card-action-link" style="color: #fff !important;">Ver todas</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive-compact">
                                <table class="dashboard-table">
                                    <thead>
                                        <tr>
                                            <th class="ps-3"><i class="fas fa-book me-2 text-danger"></i>Materia</th>
                                            <th class="text-center"><i class="fas fa-users me-2 text-danger"></i>Estudiantes</th>
                                            <th class="text-center"><i class="fas fa-clock me-2 text-danger"></i>Horario</th>
                                            <th class="text-center"><i class="fas fa-toggle-on me-2 text-danger"></i>Estado</th>
                                            <th class="text-center" style="width: 140px; white-space: nowrap;">ACTIONS <i class="fas fa-cog text-danger ms-1"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        @forelse($misMaterias ?? [] as $materia)
                                            <tr class="hover-scale">
                                                <td class="ps-3">
                                                    <div class="user-info-compact">
                                                        <div class="user-avatar-xs">{{ substr($materia->nombre ?? 'M', 0, 1) }}</div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="user-name-styled">{{ $materia->nombre ?? 'Materia' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-modern-red">
                                                        <i class="fas fa-user-graduate"></i>
                                                        {{ $materia->estudiantes_count ?? 0 }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="session-time">
                                                        <i class="fas fa-calendar-alt text-danger me-1"></i> {{ $materia->horario ?? 'L-M-V 10:00' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge-modern-status online">
                                                        <span class="status-dot-pulse"></span> Activo
                                                    </span>
                                                </td>
                                                <td class="text-center" style="white-space: nowrap;">
                                                    <div class="action-buttons-row">
                                                        <button class="btn-icon-modern red" title="Ver Detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Calificar">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                        <button class="btn-icon-modern red" title="Material">
                                                            <i class="fas fa-file-alt"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-book-open mb-2 text-danger" style="font-size: 2rem; opacity: 0.5;"></i>
                                                    <p>No tienes materias asignadas</p>
                                                </div>
                                            </td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Horario Semanal -->
                    <div class="dashboard-card glow-effect h-100 d-flex flex-column">
                        <div class="card-header border-0 pb-0 flex-shrink-0">
                            <h3 class="card-title">Horario Hoy</h3>
                        </div>
                        <div class="card-body flex-grow-1" style="overflow-y: auto;">
                            <div class="horario-list">
                                @forelse($horarioHoy ?? [] as $clase)
                                    <div class="horario-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 15px; margin-bottom: 12px; color: white;">
                                        <div class="horario-time" style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 5px;">
                                            <i class="fas fa-clock me-1"></i> {{ $clase->hora_inicio ?? '08:00' }} - {{ $clase->hora_fin ?? '09:30' }}
                                        </div>
                                        <div class="horario-materia" style="font-weight: 600; font-size: 1rem; margin-bottom: 5px;">
                                            {{ $clase->materia ?? 'Matemáticas' }}
                                        </div>
                                        <div class="horario-aula" style="font-size: 0.85rem; opacity: 0.8;">
                                            <i class="fas fa-door-open me-1"></i> {{ $clase->aula ?? 'Aula 101' }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state text-center py-4">
                                        <i class="fas fa-calendar-times mb-2 text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted">No hay clases programadas hoy</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Analytics Grid -->
                <div class="analytics-grid" style="display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem;">
                    
                    <!-- Row 1: Large Charts (Asistencia & Rendimiento) -->
                    <div class="analytics-row-1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Asistencia de Estudiantes -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Asistencia de Estudiantes</h3>
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

                        <!-- Chart: Rendimiento Académico -->
                        <div class="dashboard-card glow-effect h-100" style="overflow: hidden;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Rendimiento Académico</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="rendimientoChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Small Charts (Tareas & Exámenes) -->
                    <div class="analytics-row-2" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        
                        <!-- Chart: Tareas Entregadas -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Tareas Entregadas</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="tareasChart" height="200"></canvas>
                            </div>
                        </div>

                        <!-- Chart: Resultados de Exámenes -->
                        <div class="dashboard-card h-100" style="overflow: hidden !important; background-image: none !important;">
                            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Resultados de Exámenes</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; font-weight: 600;">Semana</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Mes</button>
                                    <button type="button" class="btn" style="background-color: #e11d48 !important; color: #ffffff !important; border: none; border-radius: 8px; padding: 5px 15px; opacity: 0.6; font-weight: 600;">Año</button>
                                </div>
                            </div>
                            <div class="card-body" style="position: relative;">
                                <canvas id="examenesChart" height="200"></canvas>
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
    <script src="{{ asset('js/components/sidebar.js') }}"></script>
    <script src="{{ asset('js/components/footer.js') }}"></script>
    
    @stack('scripts')
    <script src="{{ asset('js/dashboard/docente.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gráfica de Asistencia
            const ctxAttendance = document.getElementById('attendanceChart');
            if (ctxAttendance) {
                new Chart(ctxAttendance, {
                    type: 'line',
                    data: {
                        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
                        datasets: [{
                            label: 'Asistencia',
                            data: [85, 90, 78, 92, 88],
                            borderColor: '#e11d48',
                            backgroundColor: 'rgba(225, 29, 72, 0.1)',
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

            // Gráfica de Rendimiento
            const ctxRendimiento = document.getElementById('rendimientoChart');
            if (ctxRendimiento) {
                new Chart(ctxRendimiento, {
                    type: 'bar',
                    data: {
                        labels: ['Matemáticas', 'Física', 'Química', 'Programación', 'Base de Datos'],
                        datasets: [{
                            label: 'Promedio',
                            data: [85, 78, 92, 88, 90],
                            backgroundColor: '#e11d48'
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

            // Gráfica de Tareas
            const ctxTareas = document.getElementById('tareasChart');
            if (ctxTareas) {
                new Chart(ctxTareas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Entregadas', 'Pendientes', 'Retrasadas'],
                        datasets: [{
                            data: [75, 15, 10],
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

            // Gráfica de Exámenes
            const ctxExamenes = document.getElementById('examenesChart');
            if (ctxExamenes) {
                new Chart(ctxExamenes, {
                    type: 'bar',
                    data: {
                        labels: ['0-50', '51-60', '61-70', '71-80', '81-90', '91-100'],
                        datasets: [{
                            label: 'Estudiantes',
                            data: [2, 5, 12, 18, 15, 8],
                            backgroundColor: '#667eea'
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
        });
    </script>
</body>
</html>