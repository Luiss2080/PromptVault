<aside class="dashboard-sidebar" id="systemSidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        @php
            $dashboardRoute = 'dashboard';
        @endphp
        <a href="{{ route($dashboardRoute) }}" class="logo-container" style="text-decoration: none;">
            <div class="logo-icon">
                <img src="{{ asset('images/LogoPestañaPrompt.jpg') }}" alt="PromptVault" class="sidebar-logo">
            </div>
            <div class="logo-text">
                <h1 class="brand-name">PromptVault</h1>
                <span class="brand-subtitle">Gestión de Prompts IA</span>
            </div>
        </a>
    </div>

    <!-- Contenedor de Navegación con Scroll -->
    <div class="sidebar-scroll-content">
        
        @if(session('user_role') == 'admin')
        <!-- Sección: Biblioteca de Prompts (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">BIBLIOTECA</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('prompts.index') }}" class="nav-link {{ request()->routeIs('prompts.index') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Todos los Prompts</span>
                        <span class="nav-badge">{{ \App\Models\Prompt::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prompts.create') }}" class="nav-link {{ request()->routeIs('prompts.create') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Crear Prompt</span>
                    </a>
                </li>
                <li class="nav-item">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Favoritos</span>
                        <span class="nav-badge">12</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Más Utilizados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Plantillas</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Organización (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">ORGANIZACIÓN</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Categorías</span>
                        <span class="nav-badge">{{ \App\Models\Categoria::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Etiquetas</span>
                        <span class="nav-badge">{{ \App\Models\Etiqueta::count() }}</span>
                    </a>
                </li>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Colaboración (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">COLABORACIÓN</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Compartidos</span>
                        <span class="nav-badge">{{ \App\Models\Compartido::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Compartir Nuevo</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Historial (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">HISTORIAL</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Versiones</span>
                        <span class="nav-badge">{{ \App\Models\Version::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Actividades</span>
                        <span class="nav-badge">{{ \App\Models\Actividad::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Sesiones de Uso</span>
                        <span class="nav-badge">{{ \App\Models\SesionPrompt::count() }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Análisis y Reportes (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">ANÁLISIS</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Estadísticas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Tendencias</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Administración (ADMIN) -->
        <div class="nav-section">
            <h3 class="section-title">ADMINISTRACIÓN</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Usuarios</span>
                        <span class="nav-badge">{{ \App\Models\User::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Roles</span>
                        <span class="nav-badge">{{ \App\Models\Role::count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Permisos</span>
                    </a>
                </li>
            </ul>
        </div>
        
        @elseif(session('user_role') == 'user')
        <!-- Sección: Mi Biblioteca (USER) -->
        <div class="nav-section">
            <h3 class="section-title">MI BIBLIOTECA</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prompts.index') }}" class="nav-link {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Mis Prompts</span>
                        <span class="nav-badge">5</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prompts.create') }}" class="nav-link {{ request()->routeIs('prompts.create') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Crear Prompt</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Favoritos</span>
                        <span class="nav-badge">8</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Explorar (USER) -->
        <div class="nav-section">
            <h3 class="section-title">EXPLORAR</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Categorías</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Compartidos Conmigo</span>
                        <span class="nav-badge">3</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Historial (USER) -->
        <div class="nav-section">
            <h3 class="section-title">HISTORIAL</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Recientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Mis Actividades</span>
                    </a>
                </li>
            </ul>
        </div>
        
        @elseif(session('user_role') == 'collaborator')
        <!-- Sección: Colaboración (COLLABORATOR) -->
        <div class="nav-section">
            <h3 class="section-title">COLABORACIÓN</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Compartidos Conmigo</span>
                        <span class="nav-badge">8</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prompts.index') }}" class="nav-link {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Mis Contribuciones</span>
                        <span class="nav-badge">12</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Edición (COLLABORATOR) -->
        <div class="nav-section">
            <h3 class="section-title">EDICIÓN</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Ediciones Pendientes</span>
                        <span class="nav-badge">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Revisiones Completadas</span>
                        <span class="nav-badge">15</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Recursos (COLLABORATOR) -->
        <div class="nav-section">
            <h3 class="section-title">RECURSOS</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Categorías</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Historial</span>
                    </a>
                </li>
            </ul>
        </div>
        
        @else
        <!-- Sección: Explorar (GUEST) -->
        <div class="nav-section">
            <h3 class="section-title">EXPLORAR</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prompts.index') }}" class="nav-link {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Prompts Públicos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Categorías</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Comunidad (GUEST) -->
        <div class="nav-section">
            <h3 class="section-title">COMUNIDAD</h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Más Populares</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Recientes</span>
                    </a>
                </li>
            </ul>
        </div>
        @endif
    </div>

    <!-- Footer del Sidebar -->
    <div class="sidebar-footer">
        <a href="/" target="_blank" class="visit-site-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
            <span>Visitar Sitio Web</span>
        </a>

        <div class="theme-toggle-card">
            <div class="theme-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle><path d="M12 2a7 7 0 1 0 10 10"></path>
                </svg>
            </div>
            <span class="theme-text">Oscuro</span>
            <label class="switch">
                <input type="checkbox" id="themeSwitch">
                <span class="slider round">
                    <svg class="sun-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </span>
            </label>
        </div>
    </div>
</aside>