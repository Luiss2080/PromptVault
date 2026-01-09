@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $userRole = $user && $user->role ? $user->role->nombre : 'guest';
    
    // Mapear roles a nombres de componentes
    $roleComponentMap = [
        'admin' => 'administrador',
        'user' => 'usuario',
        'collaborator' => 'colaborador',
        'guest' => 'invitado'
    ];
    
    $componentName = 'components.' . ($roleComponentMap[$userRole] ?? 'invitado');
@endphp

@component($componentName, ['title' => 'Seguridad - Cambiar Contraseña', 'recentUsers' => $recentUsers ?? collect()])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/edit.css') }}">
@endsection

@section('content')
    <!-- Header Tipo Panel de Control -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper" style="background: linear-gradient(135deg, #ef4444, #b91c1c);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="title-content">
                    <h2>Seguridad</h2>
                    <p class="subtitle">Gestiona tu contraseña y protección de cuenta</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('perfil.index') }}" class="action-btn-red">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver al Perfil</span>
                </a>
            </div>
        </div>

        <div class="panel-content">
            <!-- Barra de Estado -->
            <div class="stats-group">
                <div class="stat-pill">
                    <i class="fas fa-id-card"></i>
                    <div class="info">
                        <span class="label">Rol</span>
                        <span class="value">{{ $user->rol ?? 'Usuario' }}</span>
                    </div>
                </div>
                
                <div class="stat-pill">
                    <i class="fas fa-toggle-on"></i>
                    <div class="info">
                        <span class="label">Estado</span>
                        <span class="value" style="color: #10b981;">Activo</span>
                    </div>
                </div>

                <div class="stat-pill">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="info">
                        <span class="label">Miembro Desde</span>
                        <span class="value">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>

                <div class="stat-pill">
                    <i class="fas fa-clock"></i>
                    <div class="info">
                        <span class="label">Último Acceso</span>
                        <span class="value">{{ $user->ultimo_acceso ? \Carbon\Carbon::parse($user->ultimo_acceso)->diffForHumans() : 'Ahora' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor Principal -->
    <div class="dashboard-section">
        <div class="profile-container">
            
            <!-- Izquierda: Sidebar Sticky con Multiple Cards -->
            <!-- FIX: Apply sticky here, and align-self start to prevent stretching -->
            <div class="profile-sidebar" style="display: flex; flex-direction: column; gap: 0; position: sticky; top: 2rem; height: fit-content;">
                
                <!-- Card 1: Avatar -->
                <div class="profile-card" style="width: 100%; position: relative; top: 0; padding: 1rem; border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-bottom: none;">
                    <div class="profile-avatar-wrapper">
                        <img src="{{ $user->foto_perfil && file_exists(public_path($user->foto_perfil)) ? asset($user->foto_perfil) : asset('images/default-avatar.svg') }}" alt="Foto de Perfil" class="profile-avatar" id="avatarPreview">
                        
                        <!-- Removed edit button for security view context or keep it if desired, but user asked for "IGUAL". 
                             If "IGUAL", I should probably keep it even if it doesn't work or hide it? 
                             The prompt says "CARDS ... SEAN IGUAL". I will keep the structure exactly. 
                             However, the avatar upload form is specific to the edit page. 
                             I will keep the VISUALS but maybe disable the functional part if it requires JS not present? 
                             The JS is in 'js/perfil/edit.js' or similar. 
                             In security view, renaming the form ID might be safer if we don't want conflicts, but for "IGUAL" I'll stick to the structure.
                             I will change the link at the bottom to "Editar Perfil" though, as discussed. -->
                        
                        <!-- Keeping the edit button visual but maybe it shouldn't be functional on security page? 
                             The user said "IGUAL". I will copy it. -->
                        <button type="button" class="avatar-edit-btn" style="cursor: default; opacity: 0.5;" title="Ir a editar perfil para cambiar foto">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <span class="profile-role">
                        <i class="fas fa-user-shield"></i> {{ $user->rol ?? 'Administrador' }}
                    </span>
                    
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem;">{{ $user->email }}</p>

                    <div class="profile-stats" style="margin-bottom: 0.5rem; padding: 0.8rem 0; padding-top: 0.8rem; margin-top: 0.5rem;">
                        <div class="stat-item">
                            <span class="stat-value">{{ intval(\Carbon\Carbon::parse($user->created_at)->diffInDays()) }}</span>
                            <span class="stat-label">Días</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value" style="color: #10b981;">Active</span>
                            <span class="stat-label">Estado</span>
                        </div>
                    </div>
                    
                    <div style="margin-top: 0.8rem; width: 100%; text-align: left;">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <a href="{{ route('perfil.edit') }}" class="action-btn-red" style="justify-content: center; display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <i class="fas fa-user-edit"></i> Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Nivel de Perfil y Detalles de Cuenta -->
                <div class="profile-card" style="width: 100%; position: relative; padding: 1.5rem; align-items: flex-start; text-align: left; border-top-left-radius: 0; border-top-right-radius: 0;">
                    <!-- Header: Nivel -->
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; width: 100%; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                        <div style="width: 45px; height: 45px; background: rgba(220, 38, 38, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-red); font-size: 1.2rem;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.1rem; margin: 0; color: var(--text-dark); font-weight: 700;">Nivel de Perfil</h3>
                            <span style="font-size: 0.85rem; color: var(--text-muted);">Estadísticas de cuenta</span>
                        </div>
                    </div>

                    <!-- Progreso -->
                    <div style="width: 100%; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                            <span style="color: var(--text-dark); font-weight: 600;">Intermedio</span>
                            <span style="color: var(--primary-red); font-weight: 700;">85%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: var(--bg-body); border-radius: 3px; overflow: hidden;">
                            <div style="width: 85%; height: 100%; background: var(--primary-red); border-radius: 3px; box-shadow: 0 0 10px rgba(220, 38, 38, 0.4);"></div>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i> Completa tu biografía para llegar al 100%.
                        </p>
                    </div>

                    <!-- Grid de Badges -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; width: 100%; margin-bottom: 1.5rem;">
                        <div style="background: var(--bg-body); padding: 0.8rem; border-radius: 10px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.2rem; margin-bottom: 0.3rem;"></i>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Email</span>
                            <span style="font-weight: 600; color: var(--text-dark); font-size: 0.85rem;">Verificado</span>
                        </div>
                        <div style="background: var(--bg-body); padding: 0.8rem; border-radius: 10px; text-align: center;">
                            <i class="fas fa-shield-alt" style="color: #f59e0b; font-size: 1.2rem; margin-bottom: 0.3rem;"></i>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Seguridad</span>
                            <span style="font-weight: 600; color: var(--text-dark); font-size: 0.85rem;">Alta</span>
                        </div>
                    </div>

                    <!-- Lista de Detalles Adicionales -->
                    <div style="width: 100%;">
                        <h4 style="font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 1rem; letter-spacing: 0.5px;">Detalles de Cuenta</h4>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                                <span style="color: var(--text-muted);"><i class="fas fa-fingerprint" style="width: 20px;"></i> ID Usuario</span>
                                <span style="color: var(--text-dark); font-family: monospace; background: var(--bg-body); padding: 0.2rem 0.5rem; border-radius: 4px;">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                                <span style="color: var(--text-muted);"><i class="fas fa-globe-americas" style="width: 20px;"></i> Región</span>
                                <span style="color: var(--text-dark);">Bolivia (BOT)</span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                                <span style="color: var(--text-muted);"><i class="fas fa-key" style="width: 20px;"></i> 2FA</span>
                                <a href="#" class="action-btn-red" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; width: auto; min-width: auto; border-radius: 8px;">
                                    Activar <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Derecha: Formulario de Seguridad -->
            <div class="profile-content">
                <div class="settings-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="card-title">
                            <h3>Cambiar Contraseña</h3>
                            <p>Actualiza y fortalece la seguridad de tu cuenta</p>
                        </div>
                    </div>

                    <form action="{{ route('perfil.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-grid" style="grid-template-columns: 1fr; margin-bottom: 2rem;">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-key"></i> Contraseña Actual</label>
                                <div class="password-group">
                                    <input type="password" name="current_password" class="form-input" required placeholder="Ingresa tu contraseña actual">
                                    <button type="button" class="toggle-password"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-top: 1rem;">
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-lock"></i> Nueva Contraseña</label>
                                    <div class="password-group">
                                        <input type="password" name="new_password" class="form-input" required placeholder="Mínimo 6 caracteres">
                                        <button type="button" class="toggle-password"><i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><i class="fas fa-check-circle"></i> Confirmar Contraseña</label>
                                    <div class="password-group">
                                        <input type="password" name="new_password_confirmation" class="form-input" required placeholder="Repite la nueva contraseña">
                                        <button type="button" class="toggle-password"><i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones Grid -->
                        <div class="actions-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                            <a href="{{ route('perfil.index') }}" class="action-btn-red" style="background: transparent; border: 2px solid var(--primary-red); color: var(--primary-red); box-shadow: none; justify-content: center;">
                                Cancelar
                            </a>
                            <button type="submit" class="action-btn-red" style="width: 100%; border: none; cursor: pointer; justify-content: center;">
                                <i class="fas fa-shield-alt"></i> Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Card Informativa Adicional -->
                <div class="settings-card" style="margin-top: 1.5rem;">
                     <div class="card-header">
                        <div class="card-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981; box-shadow: inset 0 0 10px rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="card-title">
                            <h3>Recomendaciones de Seguridad</h3>
                            <p>Mantén tu cuenta protegida en todo momento</p>
                        </div>
                    </div>
                    
                    <ul style="list-style: none; padding: 0; color: var(--text-dark); display: grid; gap: 1rem;">
                        <li style="display: flex; gap: 0.8rem; align-items: start;">
                            <i class="fas fa-check" style="color: #10b981; margin-top: 4px;"></i>
                            <div>
                                <strong style="display: block; font-size: 0.95rem;">Usa una contraseña única</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">No reutilices contraseñas de otros sitios.</span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 0.8rem; align-items: start;">
                            <i class="fas fa-check" style="color: #10b981; margin-top: 4px;"></i>
                            <div>
                                <strong style="display: block; font-size: 0.95rem;">Activa la autenticación de dos factores (2FA)</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Añade una capa extra de seguridad a tu login.</span>
                            </div>
                        </li>
                        <li style="display: flex; gap: 0.8rem; align-items: start;">
                            <i class="fas fa-check" style="color: #10b981; margin-top: 4px;"></i>
                            <div>
                                <strong style="display: block; font-size: 0.95rem;">Cierra sesión en dispositivos compartidos</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Asegúrate de no dejar tu cuenta abierta en equipos públicos.</span>
                            </div>
                        </li>
                         <li style="display: flex; gap: 0.8rem; align-items: start;">
                            <i class="fas fa-bell" style="color: #10b981; margin-top: 4px;"></i>
                            <div>
                                <strong style="display: block; font-size: 0.95rem;">Alertas de Inicio de Sesión</strong>
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Recibe notificaciones ante accesos sospechosos.</span>
                            </div>
                        </li>
                        <li style="margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-dark);">Historial de Actividad</span>
                            <a href="#" class="action-btn-red" style="padding: 0.4rem 1rem; font-size: 0.8rem; width: auto; min-width: auto; border-radius: 8px;">Ver Todo <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endcomponent

@section('js')
    <script src="{{ asset('js/perfil/index.js') }}"></script>
    <script>
        // Toggle Password Visibility Script inline for simplicity or reuse existing logic
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection

@endcomponent
