@extends('components.usuario')

@section('title', $prompt->titulo . ' - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-file-alt text-primary"></i> {{ $prompt->titulo }}</h1>
                <p class="text-muted">Detalles y gestión del prompt</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('prompts.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                @can('update', $prompt)
                    <a href="{{ route('prompts.edit', $prompt) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Columna Principal: Contenido del Prompt --}}
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Contenido del Prompt</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="copyPrompt()">
                        <i class="fas fa-copy"></i> Copiar
                    </button>
                </div>
                <div class="card-body">
                    <div id="promptContent" class="p-3 bg-light rounded border mb-3" style="white-space: pre-wrap; font-family: 'Courier New', Courier, monospace;">{{ $prompt->contenido }}</div>
                    
                    @if($prompt->descripcion)
                        <h6>Descripción</h6>
                        <p class="text-muted">{{ $prompt->descripcion }}</p>
                    @endif
                </div>
            </div>

            {{-- Historial de Versiones Rápido --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Historial de Versiones</h5>
                    <a href="{{ route('prompts.historial', $prompt) }}" class="btn btn-sm btn-link text-primary">Ver Todo</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Versión</th>
                                    <th>Fecha</th>
                                    <th>Cambio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prompt->versiones->take(5) as $version)
                                    <tr>
                                        <td>v{{ $version->numero_version }}</td>
                                        <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ Str::limit($version->mensaje_cambio, 30) }}</td>
                                        <td>
                                            @if($version->numero_version != $prompt->version_actual)
                                                <form action="{{ route('prompts.restaurar', [$prompt, $version]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Restaurar esta versión">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-success">Actual</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Lateral: Info y Acciones --}}
        <div class="col-lg-4">
            {{-- Info Card --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Información</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Visibilidad:</span>
                            <span class="badge {{ $prompt->visibilidad == 'publico' ? 'bg-success' : ($prompt->visibilidad == 'enlace' ? 'bg-warning' : 'bg-secondary') }}">
                                {{ ucfirst($prompt->visibilidad) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Vistas:</span>
                            <span><i class="fas fa-eye"></i> {{ $prompt->conteo_vistas }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Versión Actual:</span>
                            <span>v{{ $prompt->version_actual }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Creado:</span>
                            <span>{{ $prompt->created_at->diffForHumans() }}</span>
                        </li>
                    </ul>

                    @if($prompt->etiquetas->count())
                        <div class="mt-3">
                            <h6 class="mb-2">Etiquetas:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($prompt->etiquetas as $etiqueta)
                                    <span class="badge" style="background-color: {{ $etiqueta->color_hex ?? '#6c757d' }};">
                                        {{ $etiqueta->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Compartir Card --}}
            @can('share', $prompt)
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Compartir Acceso</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('prompts.compartir', $prompt) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email del usuario</label>
                                <input type="email" name="email" id="email" class="form-control" required placeholder="ejemplo@correo.com">
                            </div>
                            <div class="mb-3">
                                <label for="nivel_acceso" class="form-label">Nivel de Acceso</label>
                                <select name="nivel_acceso" id="nivel_acceso" class="form-select">
                                    <option value="lectura">Solo Lectura</option>
                                    <option value="edicion">Edición</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Compartir</button>
                        </form>

                        @if($prompt->accesosCompartidos->count())
                            <h6>Usuarios con acceso:</h6>
                            <ul class="list-group list-group-flush">
                                @foreach($prompt->accesosCompartidos as $acceso)
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <div>
                                            <span class="d-block">{{ $acceso->user->name }}</span>
                                            <small class="text-muted">{{ $acceso->nivel_acceso }}</small>
                                        </div>
                                        <form action="{{ route('prompts.quitarAcceso', [$prompt, $acceso->user]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger" title="Quitar acceso">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function copyPrompt() {
        const text = document.getElementById('promptContent').innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('Prompt copiado al portapapeles');
        });
    }
</script>
@endsection
