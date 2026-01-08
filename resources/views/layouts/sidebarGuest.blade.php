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
        
        <!-- Sección: Explorar (GUEST) -->
        <div class="nav-section">
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-search section-title-icon"></i>
                EXPLORAR
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
                    <a href="{{ route('prompts.index') }}" class="nav-link {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                        </span>
                        <span class="nav-text">Prompts Públicos</span>
                    </a>
                </li>
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
                                <rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span class="nav-text">Plantillas</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sección: Comunidad (GUEST) -->
        <div class="nav-section">
            <h3 class="section-title" data-toggle="collapse">
                <i class="fas fa-globe section-title-icon"></i>
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
