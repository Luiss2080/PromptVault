@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $userRole = $user && $user->role ? $user->role->nombre : 'guest';
    $componentName = 'components.' . $userRole;
@endphp

@component($componentName, ['title' => 'Editar Perfil'])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/edit.css') }}">
@endsection

@section('content')
    <!-- Header Tipo Panel de Control -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="title-content">
                    <h2>Editar Perfil</h2>
                    <p class="subtitle">Actualiza tu información personal y configuración</p>
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
            <div class="profile-sidebar" style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 2rem; height: fit-content;">
                
                <!-- Card 1: Avatar -->
                <div class="profile-card" style="width: 100%; position: relative; top: 0;">
                    <div class="profile-avatar-wrapper">
                        <img src="{{ $user->foto_perfil && file_exists(public_path($user->foto_perfil)) ? asset($user->foto_perfil) : asset('images/default-avatar.svg') }}" alt="Foto de Perfil" class="profile-avatar" id="avatarPreview">
                        
                        <button type="button" class="avatar-edit-btn" onclick="document.getElementById('avatarInput').click()" title="Cambiar Foto">
                            <i class="fas fa-camera"></i>
                        </button>
                        <form id="avatarForm" action="{{ route('perfil.avatar') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAndUpload(this)">
                        </form>
                    </div>

                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <span class="profile-role">
                        <i class="fas fa-user-shield"></i> {{ $user->rol ?? 'Administrador' }}
                    </span>
                    
                    <p style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem;">{{ $user->email }}</p>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ intval(\Carbon\Carbon::parse($user->created_at)->diffInDays()) }}</span>
                            <span class="stat-label">Días</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value" style="color: #10b981;">Active</span>
                            <span class="stat-label">Estado</span>
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem; width: 100%; text-align: left;">
                        <h4 style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 1rem; font-weight: 700;">Seguridad</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                            <a href="{{ route('perfil.security') }}" class="action-btn-red" style="justify-content: flex-start; padding-left: 1.5rem; display: flex; align-items: center; gap: 0.8rem; padding: 1rem; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <i class="fas fa-lock"></i> Cambiar Contraseña
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Nivel de Perfil y Detalles de Cuenta -->
                <div class="profile-card" style="width: 100%; position: relative; padding: 1.5rem; align-items: flex-start; text-align: left;">
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

            <!-- Derecha: Formulario -->
            <div class="profile-content">
                <div class="settings-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="card-title">
                            <h3>Información Personal</h3>
                            <p>Actualiza tu información personal y redes sociales</p>
                        </div>
                    </div>

                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <h4 style="color: var(--primary-red); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-address-card"></i> Datos Básicos
                        </h4>
                        
                        <div class="form-grid" style="margin-bottom: 2.5rem;">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Nombre</label>
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user-tag"></i> Apellido</label>
                                <input type="text" name="apellido" class="form-input" value="{{ $user->apellido ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-id-card"></i> Cédula de Identidad</label>
                                <input type="text" name="ci" class="form-input" value="{{ $user->ci ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-birthday-cake"></i> Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-input" value="{{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('Y-m-d') : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-venus-mars"></i> Género</label>
                                <select name="genero" class="form-input">
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino" {{ ($user->genero ?? '') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ ($user->genero ?? '') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ ($user->genero ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-briefcase"></i> Profesión</label>
                                <input type="text" name="profesion" class="form-input" value="{{ $user->profesion ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-graduation-cap"></i> Nivel de Estudios</label>
                                <input type="text" name="nivel_estudios" class="form-input" value="{{ $user->nivel_estudios ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                                <input type="tel" name="phone" class="form-input" placeholder="+591 ..." value="{{ $user->telefono ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                                <input type="text" name="address" class="form-input" placeholder="Av. Principal #123" value="{{ $user->direccion ?? '' }}">
                            </div>
                        </div>

                        <div style="border-top: 1px solid var(--border-color); margin: 2rem 0;"></div>

                        <h4 style="color: var(--primary-red); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-share-alt"></i> Redes Sociales
                        </h4>

                        <div class="form-grid" style="margin-bottom: 2rem;">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-globe"></i> Website</label>
                                <input type="text" name="website" class="form-input" placeholder="https://" value="{{ $user->website ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                                <input type="text" name="facebook" class="form-input" placeholder="Usuario" value="{{ $user->facebook ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fab fa-twitter"></i> Twitter / X</label>
                                <input type="text" name="twitter" class="form-input" placeholder="@usuario" value="{{ $user->twitter ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn</label>
                                <input type="text" name="linkedin" class="form-input" placeholder="Usuario" value="{{ $user->linkedin ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                                <input type="text" name="instagram" class="form-input" placeholder="Usuario" value="{{ $user->instagram ?? '' }}">
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label"><i class="fas fa-align-left"></i> Biografía / Sobre mí</label>
                                <textarea name="biografia" class="form-input" rows="3" placeholder="Cuéntanos un poco sobre ti...">{{ $user->biografia ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="actions-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                            <a href="{{ route('perfil.index') }}" class="action-btn-red" style="background: transparent; border: 2px solid var(--primary-red); color: var(--primary-red); box-shadow: none;">
                                Cancelar
                            </a>
                            <button type="submit" class="action-btn-red" style="width: 100%; border: none; cursor: pointer;">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function previewAndUpload(input) {
    const file = input.files[0];
    if (!file) return;

    // Validar tipo de archivo
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Solo se permiten imágenes (JPEG, PNG, GIF, WEBP)');
        return;
    }

    // Validar tamaño (2MB)
    if (file.size > 2048 * 1024) {
        alert('La imagen no puede superar los 2MB');
        return;
    }

    // Previsualizar imagen inmediatamente
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Subir vía AJAX
    const formData = new FormData();
    formData.append('avatar', file);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('{{ route("perfil.avatar") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Foto de perfil actualizada correctamente');
            // Mostrar mensaje de éxito (opcional)
            const successMsg = document.createElement('div');
            successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 1rem 1.5rem; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            successMsg.innerHTML = '<i class="fas fa-check-circle"></i> ' + (data.message || 'Foto actualizada');
            document.body.appendChild(successMsg);
            setTimeout(() => successMsg.remove(), 3000);
        } else {
            alert('Error al subir la imagen: ' + (data.message || 'Error desconocido'));
            // Revertir la previsualización si hay error
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión al subir imagen');
        location.reload();
    });
}
</script>
@endsection

@endcomponent