{{-- Componente: Tarjeta de Prompt --}}
@props(['prompt'])

<div class="card h-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <h5 class="card-title">
                <a href="{{ route('prompts.show', $prompt) }}" class="text-decoration-none">
                    {{ $prompt->titulo }}
                </a>
            </h5>
            <span class="badge bg-{{ $prompt->visibilidad == 'publico' ? 'success' : ($prompt->visibilidad == 'enlace' ? 'warning' : 'secondary') }}">
                <i class="fas fa-{{ $prompt->visibilidad == 'publico' ? 'globe' : ($prompt->visibilidad == 'enlace' ? 'link' : 'lock') }}"></i>
                {{ ucfirst($prompt->visibilidad) }}
            </span>
        </div>
        
        <p class="card-text text-muted small mb-3">
            {{ Str::limit($prompt->descripcion ?? $prompt->contenido, 120) }}
        </p>
        
        @if($prompt->etiquetas->count())
            <div class="mb-3">
                @foreach($prompt->etiquetas->take(3) as $etiqueta)
                    <span class="badge me-1" style="background-color: {{ $etiqueta->color_hex ?? '#6c757d' }}">
                        {{ $etiqueta->nombre }}
                    </span>
                @endforeach
                @if($prompt->etiquetas->count() > 3)
                    <span class="badge bg-secondary">+{{ $prompt->etiquetas->count() - 3 }}</span>
                @endif
            </div>
        @endif
        
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-eye"></i> {{ $prompt->conteo_vistas }}
                <i class="fas fa-code-branch ms-2"></i> v{{ $prompt->version_actual }}
                @if($prompt->promedio_calificacion > 0)
                    <i class="fas fa-star ms-2 text-warning"></i> {{ number_format($prompt->promedio_calificacion, 1) }}
                @endif
            </small>
            
            @auth
                <div class="btn-group btn-group-sm">
                    @can('update', $prompt)
                        <a href="{{ route('prompts.edit', $prompt) }}" class="btn btn-outline-primary" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endcan
                    <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-outline-info" title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            @endauth
        </div>
    </div>
    
    @if($prompt->user)
        <div class="card-footer bg-transparent">
            <small class="text-muted">
                <i class="fas fa-user"></i> {{ $prompt->user->name }}
                <span class="ms-2">
                    <i class="fas fa-clock"></i> {{ $prompt->created_at->diffForHumans() }}
                </span>
            </small>
        </div>
    @endif
</div>
