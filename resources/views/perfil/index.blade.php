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

@component($componentName, ['title' => 'Mi Perfil', 'recentUsers' => $recentUsers ?? collect()])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/index.css') }}">
@endsection

@section('content')
    <!-- Header Tipo Panel de Control -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="title-content">
                    <h2>Mi Perfil</h2>
                    <p class="subtitle">Gestiona tu información personal y seguridad de cuenta</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('perfil.edit') }}" class="btn-primary-action">
                    <i class="fas fa-user-edit"></i>
                    <span>Editar Perfil</span>
                </a>
            </div>
        </div>

        <div class="panel-content">
            <!-- Barra de Estado (Simulando la barra de filtros/búsqueda) -->
            <div class="stats-group">
                <div class="stat-pill">
                    <i class="fas fa-id-card"></i>
                    <div class="info">
                        <span class="label">Rol</span>
                        <span class="value">{{ $user->role ? $user->role->nombre : 'Usuario' }}</span>
                    </div>
                </div>
                
                <div class="stat-pill">
                    <i class="fas fa-toggle-on"></i>
                    <div class="info">
                        <span class="label">Estado</span>
                        <span class="value {{ $user->cuenta_activa ? 'text-success' : 'text-danger' }}">{{ $user->cuenta_activa ? 'Activo' : 'Inactivo' }}</span>
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
                        <span class="value">{{ $user->ultimo_acceso ? $user->ultimo_acceso->diffForHumans() : 'Ahora' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="dashboard-section">
    <!-- Contenedor Principal Perfil (Header removido de aquí) -->
    <div class="profile-container">
        
        <!-- Izquierda: Tarjeta de Perfil -->
        <div class="profile-card">
            <div class="profile-avatar-wrapper">
                <img src="{{ $user->foto_perfil && file_exists(public_path($user->foto_perfil)) ? asset($user->foto_perfil) : asset('images/default-avatar.svg') }}" alt="Foto de Perfil" class="profile-avatar">
                <label for="avatarInput" class="avatar-edit-btn" title="Cambiar foto">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="avatarInput" hidden accept="image/*">
            </div>
            
            <h2 class="profile-name">{{ $user->name }}</h2>
            <span class="profile-role">{{ $user->role ? $user->role->nombre : 'Usuario' }}</span>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">{{ $user->email }}</p>

            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</span>
                    <span class="stat-label">Miembro Desde</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value text-success">{{ $user->cuenta_activa ? 'Activo' : 'Inactivo' }}</span>
                    <span class="stat-label">Estado</span>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.8rem; color: var(--text-muted);">
                Último acceso: {{ $user->ultimo_acceso ? $user->ultimo_acceso->diffForHumans() : 'Nunca' }}
            </div>
        </div>

        <!-- Derecha: Dashboard de Acciones y Resumen -->
        <div class="profile-content">
            
            <!-- Resumen de Datos -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="card-title">
                        <h3>Información Personal</h3>
                        <p>Resumen de tus datos registrados</p>
                    </div>
                </div>

                <div class="info-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Nombre Completo</label>
                        <span style="font-weight:600; font-size:1.1rem; color:var(--text-dark);">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Correo Electrónico</label>
                        <span style="font-weight:600; font-size:1.1rem; color:var(--text-dark);">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Rol del Sistema</label>
                        <span style="font-weight:600; font-size:1.1rem; color:var(--text-dark);">{{ $user->role ? ucfirst($user->role->nombre) : 'Usuario' }}</span>
                    </div>
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Estado de Cuenta</label>
                        <span class="{{ $user->cuenta_activa ? 'text-success' : 'text-danger' }}" style="font-weight:600; font-size:1.1rem;">{{ $user->cuenta_activa ? 'Activa' : 'Inactiva' }}</span>
                    </div>
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Registro en el Sistema</label>
                        <span style="font-weight:600; font-size:1.1rem; color:var(--text-dark);">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <label style="display:block; color:var(--text-muted); font-size:0.8rem; margin-bottom:0.2rem;">Email Verificado</label>
                        <span style="font-weight:600; font-size:1.1rem; color:var(--text-dark);">{{ $user->email_verified_at ? 'Sí (' . $user->email_verified_at->format('d/m/Y') . ')' : 'No verificado' }}</span>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción Compactos -->
            <div class="actions-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem;">
                <a href="{{ route('perfil.edit') }}" class="action-btn-red">
                    <i class="fas fa-user-edit"></i>
                    <span>Editar Perfil</span>
                </a>

                <a href="{{ route('perfil.security') }}" class="action-btn-red">
                    <i class="fas fa-shield-alt"></i>
                    <span>Seguridad</span>
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Actividad Reciente (Contenedor Separado) -->
<div class="dashboard-section" style="margin-top: 2rem;">
    <div class="settings-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="card-title">
                <h3>Actividad Reciente</h3>
                <p>Últimos movimientos en el sistema</p>
            </div>
        </div>

        <ul class="activity-list" style="list-style: none; padding: 0;">
            @forelse($logs as $log)
                <li style="display: flex; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid var(--border-color);">
                    <div style="min-width: 40px; height: 40px; background: var(--bg-body); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                        <i class="fas fa-dot-circle" style="color: var(--primary-red);"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 0.95rem; color: var(--text-dark); margin-bottom: 0.2rem;">{{ $log->accion }} - {{ $log->modulo }}</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">{{ $log->ip_address }} &bull; {{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </li>
            @empty
                <li style="text-align: center; color: var(--text-muted); padding: 1rem;">No hay actividad reciente.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('JavaScript/perfil/index.js') }}"></script>
@endsection

@endcomponent
