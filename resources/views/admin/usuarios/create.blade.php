@extends('layouts.admin')

@section('title', 'Nuevo Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/edit.css') }}">
@endsection

@section('content')
<div class="create-usuario-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="title-content">
                <h2>Nuevo Usuario</h2>
                <p class="subtitle">Registre un nuevo usuario en el sistema</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data" id="createUsuarioForm">
        @csrf
        
        <div class="form-content">
            <!-- Left Column: Avatar & Help -->
            <div class="left-column">
                <!-- Avatar Card -->
                <div class="form-card profile-card">
                    <div class="photo-preview-container">
                         <!-- Placeholder or Default Image -->
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <img src="" alt="Vista previa" class="photo-preview" style="display: none;">
                    </div>
                    
                    <div class="photo-upload-btn-wrapper">
                        <button type="button" class="btn-upload-photo">
                            <i class="fas fa-camera"></i>
                            Subir Foto
                        </button>
                        <input type="file" name="foto_perfil" id="avatar" class="file-input" accept="image/*">
                    </div>
                    <p class="photo-help-text">JPG, PNG o GIF. Máx 2MB</p>
                </div>

                <!-- Help/Status Cards -->
                <div class="help-section-container">
                    <div class="help-cards-list">
                        <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="help-text">
                                <h4>Rol de Usuario</h4>
                                <p>Define los permisos y acceso al sistema.</p>
                            </div>
                        </div>
                        <div class="help-card-item">
                            <div class="help-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="help-text">
                                <h4>Seguridad</h4>
                                <p>Asigne una contraseña segura al usuario.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Sections -->
            <div class="right-column">
                
                <!-- Card 1: User Info -->
                <div class="form-card">
                    <div class="card-header">
                        <h3>
                            <i class="fas fa-user"></i>
                            Información Personal
                        </h3>
                        <p>Datos básicos del usuario</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-4">
                            <label for="name">Nombre Completo <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name" class="form-input" placeholder="Ej: Juan Pérez" required value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2: Account Info -->
                <div class="form-card">
                    <div class="card-header">
                        <h3>
                            <i class="fas fa-user-shield"></i>
                            Datos de Cuenta
                        </h3>
                        <p>Credenciales y Acceso</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label for="email">Correo Electrónico <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" class="form-input" placeholder="usuario@ejemplo.com" required>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="password">Contraseña <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" class="form-input" placeholder="********" required>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="role_id">Rol en el Sistema <span>*</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user-tag"></i>
                                <select id="role_id" name="role_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un rol...</option>
                                    @foreach($roles ?? [] as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group span-2">
                            <label for="cuenta_activa">Estado de Cuenta</label>
                            <div class="input-wrapper">
                                <i class="fas fa-toggle-on"></i>
                                <select id="cuenta_activa" name="cuenta_activa" class="form-select">
                                    <option value="1" selected>Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="form-status-badge">
                            <i class="fas fa-user-clock"></i>
                            <span>Nuevo Registro</span>
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn-cancel">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i>
                                <span>Guardar Usuario</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('JavaScript/usuarios/create.js') }}"></script>
@endsection