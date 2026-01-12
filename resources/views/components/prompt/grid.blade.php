{{-- Componente: Grid de Prompts --}}
@props(['prompts', 'emptyMessage' => 'No hay prompts disponibles', 'emptyIcon' => 'inbox'])

<div class="row">
    @forelse($prompts as $prompt)
        <div class="col-md-6 col-lg-4 mb-4">
            <x-prompt.card :prompt="$prompt" />
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-{{ $emptyIcon }} fa-3x mb-3 text-muted"></i>
                <h4>{{ $emptyMessage }}</h4>
                @auth
                    @if(request()->routeIs('prompts.index'))
                        <p class="mb-3">Crea tu primer prompt para comenzar</p>
                        <a href="{{ route('prompts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Prompt
                        </a>
                    @endif
                @else
                    <p>Inicia sesión para ver más contenido</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    @endforelse
</div>

@if($prompts->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            {{ $prompts->links() }}
        </div>
    </div>
@endif
