<aside class="dashboard-sidebar" id="systemSidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        @php
            $dashboardRoute = 'dashboard';
        @endphp
        <a href="{{ route($dashboardRoute) }}" class="logo-container" style="text-decoration: none;">
            <div class="logo-icon">
                <img src="{{ asset('images/LogoLoginPrompt.png') }}" alt="PromptVault" class="sidebar-logo" style="width: 50px; height: 50px; object-fit: contain;">
            </div>
            <div class="logo-text">
                <h1 class="brand-name">PromptVault</h1>
                <span class="brand-subtitle">Gestión de Prompts IA</span>
            </div>
        </a>
    </div>

    <!-- Contenedor de Navegación con Scroll -->
    <div class="sidebar-scroll-content">
        
        <!-- Sección: Colaboración (COLLABORATOR) -->
        <div class="nav-section">
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-handshake section-title-icon"></i>
                COLABORACIÓN
                <i class="fas fa-chevron-down section-toggle-icon"></i>
            </h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>
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
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
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
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-edit section-title-icon"></i>
                EDICIÓN
                <i class="fas fa-chevron-down section-toggle-icon"></i>
            </h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
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
                                <polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
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
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-folder-open section-title-icon"></i>
                RECURSOS
                <i class="fas fa-chevron-down section-toggle-icon"></i>
            </h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Categorías</span>
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
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3v5h5"></path><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"></path><path d="M12 7v5l4 2"></path>
                            </svg>
                        </span>
                        <span class="nav-text">Historial</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Plantillas</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Comunidad (COLLABORATOR) -->
        <div class="nav-section">
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-users section-title-icon"></i>
                COMUNIDAD
                <i class="fas fa-chevron-down section-toggle-icon"></i>
            </h3>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </span>
                        <span class="nav-text">Populares</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                <polyline points="17 6 23 6 23 12"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Tendencias</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Footer del Sidebar -->
    <div class="sidebar-footer">
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
