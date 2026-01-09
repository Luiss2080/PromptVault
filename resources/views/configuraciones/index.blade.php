<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración del Sistema - PromptVault</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/configuraciones/configuraciones.css') }}">
</head>

<body>
    @include('layouts.loading')
    
    <div class="dashboard-layout">
        @include('layouts.sidebar')
        
        <div class="main-content">
            @include('layouts.header', ['header_title' => 'Configuración'])
            
            <div class="dashboard-content">

    <!-- Control Panel Header -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="title-content">
                    <h2>Configuración del Sistema</h2>
                    <p class="subtitle">Gestiona las preferencias generales, seguridad y personalización de la plataforma.</p>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="header-actions">
               <!-- Stats Toolbar -->
               <div class="stats-toolbar">
                    <div class="toolbar-item">
                        <i class="fas fa-code-branch text-red"></i>
                        <span class="toolbar-val">v2.5.0</span>
                    </div>
                    <div class="toolbar-divider"></div>
                    <div class="toolbar-item">
                        <i class="fab fa-php text-blue"></i>
                        <span class="toolbar-val">{{ phpversion() }}</span>
                    </div>
                    <div class="toolbar-divider"></div>
                     <div class="toolbar-item">
                        <i class="fas fa-database text-yellow"></i>
                        <span class="toolbar-val">MySQL</span>
                    </div>
                    <div class="toolbar-divider"></div>
                    <div class="toolbar-item">
                        <i class="fas fa-circle text-green" style="font-size: 0.6rem;"></i>
                        <span class="toolbar-val">Online</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-content" style="padding-top: 0;">
            <!-- Navigation Tabs (Full Width now that stats are in header) -->
            <div class="stats-group config-tabs-container" style="width: 100%; overflow-x: auto; justify-content: start; gap: 1rem;">
                <button class="stat-pill tab-trigger active" data-target="general">
                    <i class="fas fa-sliders-h"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">General</span>
                    </div>
                </button>
                
                <button class="stat-pill tab-trigger" data-target="security">
                    <i class="fas fa-shield-alt"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">Seguridad</span>
                    </div>
                </button>

                <button class="stat-pill tab-trigger" data-target="appearance">
                    <i class="fas fa-paint-brush"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">Apariencia</span>
                    </div>
                </button>
                
                <button class="stat-pill tab-trigger" data-target="notifications">
                    <i class="fas fa-bell"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">Notificaciones</span>
                    </div>
                </button>

                <button class="stat-pill tab-trigger" data-target="backups">
                    <i class="fas fa-database"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">Respaldos</span>
                    </div>
                </button>

                <button class="stat-pill tab-trigger" data-target="system">
                    <i class="fas fa-server"></i>
                    <div class="info">
                        <span class="label">CONFIGURACIÓN</span>
                        <span class="value">Sistema</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-section">
        <div class="profile-container"> 
            
            <!-- LEFT COLUMN (Sidebar) -->
            <div class="left-column-stack sticky-sidebar" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- CARD 1: Help Center & Actions -->
                <div class="profile-card">
                    <div class="profile-avatar-wrapper" style="width: 80px; height: 80px; margin-bottom: 20px;">
                    <div style="width: 100%; height: 100%; border-radius: 50%; background: #1f2937; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #ef4444; border: 2px solid #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-life-ring"></i>
                    </div>
                    </div>
                    
                    <h2 class="profile-name" style="font-size: 1.2rem; margin-bottom: 0.5rem;">Centro de Soporte</h2>
                    <span class="profile-role" style="margin-bottom: 2rem;">Recursos & Ayuda</span>

                    <div class="help-tips">
                        <div class="tip-card" style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; border-left: 3px solid #ef4444; margin-bottom: 1rem;">
                            <h4 style="color: white; font-size: 0.9rem; margin-bottom: 0.5rem;"><i class="fas fa-book text-red mr-2"></i> Documentación</h4>
                            <p style="font-size: 0.8rem; color: #9ca3af; line-height: 1.4;">
                                Guía completa para administradores del sistema.
                            </p>
                            <a href="#" style="display: block; margin-top: 0.5rem; font-size: 0.8rem; color: #ef4444; text-decoration: none;">Ver Manual <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="action-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; width: 100%;">
                         <button class="btn-submit" style="padding: 0.6rem; font-size: 0.8rem; justify-content: center; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: none;">
                            <i class="fas fa-bug"></i> Reportar
                        </button>
                        <button class="btn-submit" style="padding: 0.6rem; font-size: 0.8rem; justify-content: center;">
                            <i class="fas fa-headset"></i> Chat
                        </button>
                    </div>
                </div>

                <!-- CARD 2: Server Status & Resources -->
                <div class="profile-card">
                     <div class="card-header" style="margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); width: 100%; display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-server text-red"></i> Estado del Servidor
                        </h3>
                         <span class="stat-pill-mini" style="font-size: 0.7rem; padding: 2px 8px; background: rgba(16, 185, 129, 0.2); color: #10b981; border-radius: 10px; display: flex; align-items: center; gap: 4px;"><span style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block;"></span> Óptimo</span>
                    </div>
                    
                    <div style="width: 100%; display: flex; flex-direction: column; gap: 1rem;">
                        <div class="resource-bar">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.3rem;">
                                <span style="font-size: 0.8rem; color: #9ca3af;"><i class="fas fa-microchip"></i> CPU</span>
                                <span style="font-size: 0.8rem; color: white;">12%</span>
                            </div>
                            <div style="width: 100%; height: 6px; background: #374151; border-radius: 3px; overflow: hidden;">
                                <div style="width: 12%; height: 100%; background: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);"></div>
                            </div>
                        </div>

                        <div class="resource-bar">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.3rem;">
                                <span style="font-size: 0.8rem; color: #9ca3af;"><i class="fas fa-memory"></i> RAM</span>
                                <span style="font-size: 0.8rem; color: white;">2.1 GB / 4 GB</span>
                            </div>
                            <div style="width: 100%; height: 6px; background: #374151; border-radius: 3px; overflow: hidden;">
                                <div style="width: 55%; height: 100%; background: #3b82f6;"></div>
                            </div>
                        </div>
                         
                         <div class="resource-bar">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.3rem;">
                                <span style="font-size: 0.8rem; color: #9ca3af;"><i class="fas fa-hdd"></i> Almacenamiento</span>
                                <span style="font-size: 0.8rem; color: white;">120 GB Libres</span>
                            </div>
                            <div style="width: 100%; height: 6px; background: #374151; border-radius: 3px; overflow: hidden;">
                                <div style="width: 28%; height: 100%; background: #10b981;"></div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 0.5rem; padding-top: 0.8rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; font-size: 0.75rem; color: #6b7280;">
                            <span><i class="fas fa-network-wired"></i> Latencia: 24ms</span>
                            <span><i class="fas fa-clock"></i> Uptime: 3d 4h</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (Settings Content) -->
            <div class="profile-content">
                
                <!-- GENERAL -->
                <div id="general" class="config-section active">
                    @include('configuraciones.general')
                </div>

                <!-- SECURITY -->
                <div id="security" class="config-section">
                    @include('configuraciones.seguridad')
                </div>

                <!-- APPEARANCE -->
                <div id="appearance" class="config-section">
                    @include('configuraciones.apariencia')
                </div>

                <!-- NOTIFICATIONS -->
                <div id="notifications" class="config-section">
                    @include('configuraciones.notificaciones')
                </div>

                <!-- BACKUPS -->
                <div id="backups" class="config-section">
                    @include('configuraciones.respaldos')
                </div>
                
                <!-- SYSTEM -->
                <div id="system" class="config-section">
                    @include('configuraciones.sistema')
                </div>

            </div>
        </div>
    </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('JavaScript/layouts/loading.js') }}"></script>
    <script src="{{ asset('JavaScript/components/sidebar.js') }}"></script>
    <script src="{{ asset('JavaScript/configuraciones/configuraciones.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for cards
            const cards = document.querySelectorAll('.settings-card, .profile-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>

</body>
</html>