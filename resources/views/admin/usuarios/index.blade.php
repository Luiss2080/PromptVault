@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/paginacion.css') }}">
@endsection

@section('content')
<div class="usuarios-container">
    <!-- Control Panel Section -->
    <div class="control-panel">
        <div class="panel-header">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <div class="title-content">
                    <h2>Gestión de Usuarios</h2>
                    <p class="subtitle">Administra los accesos, roles y perfiles del sistema</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.usuarios.create') }}" class="btn-primary-action">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Usuario</span>
                </a>
            </div>
        </div>

        <div class="panel-content">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o correo..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-group">
                <div class="select-wrapper">
                    <i class="fas fa-user-tag"></i>
                    <select id="roleSelect">
                        <option value="">Todos los Roles</option>
                        <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="user" {{ request('rol') == 'user' ? 'selected' : '' }}>Usuario</option>
                        <option value="collaborator" {{ request('rol') == 'collaborator' ? 'selected' : '' }}>Colaborador</option>
                        <option value="guest" {{ request('rol') == 'guest' ? 'selected' : '' }}>Invitado</option>
                    </select>
                </div>

                <div class="select-wrapper">
                    <i class="fas fa-list-ol"></i>
                    <select id="entriesSelect">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por pág.</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por pág.</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por pág.</option>
                    </select>
                </div>
                
                <button class="btn-secondary-action">
                    <i class="fas fa-file-export"></i>
                    <span>Exportar</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tabla -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Prompts</th>
                        <th>Último Acceso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="avatar-circle">
                                        @if($usuario->foto_perfil)
                                            <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                                        @else
                                            {{ strtoupper(substr($usuario->name ?? '?', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="details">
                                        <span class="name">{{ $usuario->name ?? 'N/A' }}</span>
                                        <span class="role">{{ $usuario->email ?? 'Sin email' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                 <span class="badge role {{ $usuario->role?->nombre }}">
                                    @switch($usuario->role?->nombre)
                                        @case('admin')
                                            Administrador
                                            @break
                                        @case('user')
                                            Usuario
                                            @break
                                        @case('collaborator')
                                            Colaborador
                                            @break
                                        @case('guest')
                                            Invitado
                                            @break
                                        @default
                                            Sin rol
                                    @endswitch
                                 </span>
                            </td>
                            <td>
                                <span class="badge {{ $usuario->cuenta_activa ? 'active' : 'inactive' }}">
                                    {{ $usuario->cuenta_activa ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <span class="sub-text" style="font-weight: 500;">
                                    {{ $usuario->prompts_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                <span class="sub-text" style="font-weight: 500;">
                                    {{ $usuario->ultimo_acceso ? \Carbon\Carbon::parse($usuario->ultimo_acceso)->diffForHumans() : 'Nunca' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.usuarios.show', $usuario->id) }}" class="btn-icon view" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn-icon edit" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-icon delete" onclick="confirmDelete({{ $usuario->id }})" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $usuario->id }}" action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 3rem; color: var(--text-muted);">
                                <i class="fas fa-users" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                                No se encontraron usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="pagination-wrapper">
        {{ $usuarios->appends(request()->query())->links('pages.usuarios') }}
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swalTheme = {
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            background: '#1e293b',
            color: '#f1f5f9'
        };
    </script>
    <script src="{{ asset('JavaScript/usuarios/index.js') }}"></script>
@endsection