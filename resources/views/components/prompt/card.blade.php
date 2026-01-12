{{-- Componente: Tarjeta de Prompt --}}
@props(['prompt'])

<div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 1.5rem; transition: all 0.3s; height: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
        <h5 style="font-size: 1.1rem; font-weight: 700; margin: 0;">
            <a href="{{ route('prompts.show', $prompt) }}" style="color: #fff; text-decoration: none;">
                {{ $prompt->titulo }}
            </a>
        </h5>
        <span style="padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; 
                     background: {{ $prompt->visibilidad == 'publico' ? '#10b981' : ($prompt->visibilidad == 'enlace' ? '#f59e0b' : '#6c757d') }}; 
                     color: #fff;">
            <i class="fas fa-{{ $prompt->visibilidad == 'publico' ? 'globe' : ($prompt->visibilidad == 'enlace' ? 'link' : 'lock') }}"></i>
            {{ ucfirst($prompt->visibilidad) }}
        </span>
    </div>
    
    <p style="color: #9ca3af; font-size: 0.9rem; margin-bottom: 1rem; 
              display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
        {{ Str::limit($prompt->descripcion ?? $prompt->contenido, 120) }}
    </p>
    
    @if($prompt->etiquetas->count())
        <div style="margin-bottom: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
            @foreach($prompt->etiquetas->take(3) as $etiqueta)
                <span style="padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; 
                             background: {{ $etiqueta->color_hex ?? '#6c757d' }}; color: #fff;">
                    {{ $etiqueta->nombre }}
                </span>
            @endforeach
            @if($prompt->etiquetas->count() > 3)
                <span style="padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; background: #6c757d; color: #fff;">
                    +{{ $prompt->etiquetas->count() - 3 }}
                </span>
            @endif
        </div>
    @endif
    
    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: #6b7280;">
        <small>
            <i class="fas fa-eye"></i> {{ $prompt->conteo_vistas }}
            <i class="fas fa-code-branch" style="margin-left: 0.5rem;"></i> v{{ $prompt->version_actual }}
            @if($prompt->promedio_calificacion > 0)
                <i class="fas fa-star" style="margin-left: 0.5rem; color: #f59e0b;"></i> {{ number_format($prompt->promedio_calificacion, 1) }}
            @endif
        </small>
        
        @auth
            <div style="display: flex; gap: 0.25rem;">
                @can('update', $prompt)
                    <a href="{{ route('prompts.edit', $prompt) }}" 
                       style="padding: 0.25rem 0.5rem; border-radius: 6px; background: rgba(225, 29, 72, 0.2); 
                              color: #e11d48; text-decoration: none; font-size: 0.85rem;"
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                @endcan
                <a href="{{ route('prompts.show', $prompt) }}" 
                   style="padding: 0.25rem 0.5rem; border-radius: 6px; background: rgba(59, 130, 246, 0.2); 
                          color: #3b82f6; text-decoration: none; font-size: 0.85rem;"
                   title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        @endauth
    </div>
    
    @if($prompt->user)
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.05);">
            <small style="color: #6b7280; display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 24px; height: 24px; border-radius: 50%; background: #e11d48; 
                           display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700;">
                    {{ substr($prompt->user->name, 0, 1) }}
                </div>
                <span>{{ $prompt->user->name }}</span>
                <span style="margin-left: auto;">
                    <i class="fas fa-clock"></i> {{ $prompt->created_at->diffForHumans() }}
                </span>
            </small>
        </div>
    @endif
</div>
