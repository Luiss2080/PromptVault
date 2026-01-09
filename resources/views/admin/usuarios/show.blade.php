@extends('layouts.admin')

@section('title', 'Detalle de Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/index.css') }}">
    <style>
        .user-role-title {
            color: white;
            margin-top: 1rem;
        }
        .user-email-text {
            color: var(--text-muted, #94a3b8);
        }
        .estado-activo {
            color: #4ade80 !important;
        }
        .estado-inactivo {
            color: #f87171 !important;
        }
    </style>
@endsection

@section('content')
<div class="show-usuario-container">
    <!-- Header -->
    <div class="panel-header">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-user"></i>
            </div>
            <div class="title-content">
                <h2>Detalles del Usuario</h2>
                <p class="subtitle">{{ $usuario->name }}</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="btn-secondary-action">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="form-content">
        <!-- Left Column: Avatar & Status -->
        <div class="left-column">
            <div class="form-card profile-card">
                 <div class="photo-preview-container">
                    @if($usuario->foto_perfil)
                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de perfil" class="photo-preview">
                    @else
                        <div class="photo-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <h3 class="user-role-title">{{ ucfirst($usuario->role?->nombre ?? 'Sin rol') }}</h3>
                <span class="user-email-text">{{ $usuario->email }}</span>

                <!-- Quick Stats -->
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Estado</span>
                        <span class="info-value estado-{{ $usuario->cuenta_activa ? 'activo' : 'inactivo' }}">
                            {{ $usuario->cuenta_activa ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Prompts Creados</span>
                        <span class="info-value">
                            {{ $usuario->prompts_count ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Data -->
        <div class="right-column">
            
            <!-- Card 1: Personal Info -->
            <div class="form-card">
                <div class="card-header">
                    <h3>
                        <i class="fas fa-user"></i>
                        Información Personal
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group span-4">
                        <label>Nombre Completo</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-input" value="{{ $usuario->name }}" readonly>
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
                </div>

                <div class="form-grid">
                    <div class="form-group span-2">
                        <label>Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-input" value="{{ $usuario->email }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Rol</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tag"></i>
                            <input type="text" class="form-input" value="{{ ucfirst($usuario->role?->nombre ?? 'Sin rol') }}" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group span-2">
                        <label>Último Acceso</label>
                        <div class="input-wrapper">
                            <i class="fas fa-clock"></i>
                            <input type="text" class="form-input" value="{{ $usuario->ultimo_acceso ? $usuario->ultimo_acceso->format('d/m/Y H:i') : 'Nunca' }}" readonly>
                        </div>
                    </div>

                    <div class="form-group span-2">
                        <label>Fecha de Registro</label>
                        <div class="input-wrapper">
                            <i class="fas fa-calendar-plus"></i>
                            <input type="text" class="form-input" value="{{ $usuario->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn-edit-action">
                        <i class="fas fa-edit"></i>
                        <span>Editar Usuario</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('JavaScript/usuarios/show.js') }}"></script>
@endsection