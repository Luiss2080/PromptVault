{{-- Componente: Grid de Prompts --}}
@props(['prompts', 'emptyMessage' => 'No hay prompts disponibles', 'emptyIcon' => 'inbox'])

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
    @forelse($prompts as $prompt)
        <x-prompt.card :prompt="$prompt" />
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem;">
            <i class="fas fa-{{ $emptyIcon }}" style="font-size: 4rem; color: #6b7280; opacity: 0.5; margin-bottom: 1rem;"></i>
            <h4 style="color: #9ca3af; margin-bottom: 0.5rem;">{{ $emptyMessage }}</h4>
            @auth
                @if(request()->routeIs('prompts.index'))
                    <p style="color: #6b7280; margin-bottom: 1.5rem;">Crea tu primer prompt para comenzar</p>
                    <a href="{{ route('prompts.create') }}" 
                       style="display: inline-block; padding: 0.75rem 1.5rem; border-radius: 8px; 
                              background: #e11d48; color: #fff; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-plus"></i> Crear Prompt
                    </a>
                @endif
            @else
                <p style="color: #6b7280;">Inicia sesión para ver más contenido</p>
                <a href="{{ route('login') }}" 
                   style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; border-radius: 8px; 
                          background: #e11d48; color: #fff; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            @endauth
        </div>
    @endforelse
</div>

@if($prompts->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 0.5rem;">
        {{-- Pagination usando estilos inline --}}
        @if ($prompts->onFirstPage())
            <span style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(255, 255, 255, 0.05); color: #6b7280;">Anterior</span>
        @else
            <a href="{{ $prompts->previousPageUrl() }}" 
               style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(255, 255, 255, 0.1); color: #fff; text-decoration: none;">
                Anterior
            </a>
        @endif
        
        <span style="padding: 0.5rem 1rem; border-radius: 8px; background: #e11d48; color: #fff;">
            Página {{ $prompts->currentPage() }} de {{ $prompts->lastPage() }}
        </span>
        
        @if ($prompts->hasMorePages())
            <a href="{{ $prompts->nextPageUrl() }}" 
               style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(255, 255, 255, 0.1); color: #fff; text-decoration: none;">
                Siguiente
            </a>
        @else
            <span style="padding: 0.5rem 1rem; border-radius: 8px; background: rgba(255, 255, 255, 0.05); color: #6b7280;">Siguiente</span>
        @endif
    </div>
@endif
