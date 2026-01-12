{{-- Componente: Filtros de Prompts --}}
@props(['etiquetas', 'showVisibility' => true])

<form action="{{ request()->url() }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 0.75rem; margin-bottom: 2rem;">
    <div>
        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar por título o contenido..." 
            value="{{ request('buscar') }}"
            style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); 
                   background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 0.95rem;"
        >
    </div>
    
    @if($showVisibility)
        <div>
            <select name="visibilidad" 
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); 
                           background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 0.95rem;">
                <option value="">Todas las visibilidades</option>
                <option value="privado" {{ request('visibilidad') == 'privado' ? 'selected' : '' }}>Privado</option>
                <option value="publico" {{ request('visibilidad') == 'publico' ? 'selected' : '' }}>Público</option>
                <option value="enlace" {{ request('visibilidad') == 'enlace' ? 'selected' : '' }}>Por enlace</option>
            </select>
        </div>
    @endif
    
    <div>
        <select name="etiqueta" 
                style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); 
                       background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 0.95rem;">
            <option value="">Todas las etiquetas</option>
            @foreach($etiquetas as $etiqueta)
                <option value="{{ $etiqueta->nombre }}" {{ request('etiqueta') == $etiqueta->nombre ? 'selected' : '' }}>
                    {{ $etiqueta->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div>
        <select name="orden" 
                style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); 
                       background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 0.95rem;">
            <option value="reciente" {{ request('orden', 'reciente') == 'reciente' ? 'selected' : '' }}>Más recientes</option>
            <option value="titulo" {{ request('orden') == 'titulo' ? 'selected' : '' }}>Por título</option>
            <option value="vistas" {{ request('orden') == 'vistas' ? 'selected' : '' }}>Más vistos</option>
            <option value="calificacion" {{ request('orden') == 'calificacion' ? 'selected' : '' }}>Mejor valorados</option>
        </select>
    </div>
    
    <div>
        <button type="submit" 
                style="padding: 0.75rem 1.5rem; border-radius: 8px; background: #e11d48; color: #fff; 
                       border: none; cursor: pointer; font-weight: 600; font-size: 0.95rem; white-space: nowrap;">
            <i class="fas fa-filter"></i> Filtrar
        </button>
    </div>
</form>
