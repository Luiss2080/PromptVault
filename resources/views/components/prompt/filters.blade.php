{{-- Componente: Filtros de Prompts --}}
@props(['etiquetas', 'showVisibility' => true])

<form action="{{ request()->url() }}" method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input 
                type="text" 
                name="buscar" 
                class="form-control" 
                placeholder="Buscar por título o contenido..." 
                value="{{ request('buscar') }}"
            >
        </div>
    </div>
    
    @if($showVisibility)
        <div class="col-md-2">
            <select name="visibilidad" class="form-select">
                <option value="">Todas las visibilidades</option>
                <option value="privado" {{ request('visibilidad') == 'privado' ? 'selected' : '' }}>
                    <i class="fas fa-lock"></i> Privado
                </option>
                <option value="publico" {{ request('visibilidad') == 'publico' ? 'selected' : '' }}>
                    <i class="fas fa-globe"></i> Público
                </option>
                <option value="enlace" {{ request('visibilidad') == 'enlace' ? 'selected' : '' }}>
                    <i class="fas fa-link"></i> Por enlace
                </option>
            </select>
        </div>
    @endif
    
    <div class="col-md-3">
        <select name="etiqueta" class="form-select">
            <option value="">Todas las etiquetas</option>
            @foreach($etiquetas as $etiqueta)
                <option value="{{ $etiqueta->nombre }}" {{ request('etiqueta') == $etiqueta->nombre ? 'selected' : '' }}>
                    {{ $etiqueta->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-2">
        <select name="orden" class="form-select">
            <option value="reciente" {{ request('orden', 'reciente') == 'reciente' ? 'selected' : '' }}>Más recientes</option>
            <option value="titulo" {{ request('orden') == 'titulo' ? 'selected' : '' }}>Por título</option>
            <option value="vistas" {{ request('orden') == 'vistas' ? 'selected' : '' }}>Más vistos</option>
            <option value="calificacion" {{ request('orden') == 'calificacion' ? 'selected' : '' }}>Mejor valorados</option>
        </select>
    </div>
    
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-filter"></i>
        </button>
    </div>
</form>
