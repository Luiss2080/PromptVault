@extends('layouts.app')

@section('title', 'Buscador Global')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buscador/index.css') }}">
@endsection

@section('content')
<div class="buscador-container">
    <div class="search-header">
        <h2>Búsqueda Global</h2>
        <p class="search-subtitle">Encuentra prompts, categorías, etiquetas y más</p>
    </div>
    
    <!-- Formulario de búsqueda -->
    <div class="search-form-container">
        <form id="searchForm" class="search-form" method="GET" action="{{ route('buscador.index') }}">
            <div class="search-input-group">
                <input type="text" 
                       id="searchQuery" 
                       name="query" 
                       placeholder="¿Qué estás buscando?" 
                       class="search-input"
                       value="{{ $query ?? '' }}"
                       autofocus>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            
            <!-- Filtros de búsqueda -->
            <div class="search-filters">
                <div class="filter-group">
                    <label>Tipo de contenido:</label>
                    <div class="filter-options">
                        <label><input type="checkbox" name="tipos[]" value="prompts" checked> Prompts</label>
                        <label><input type="checkbox" name="tipos[]" value="categorias" checked> Categorías</label>
                        <label><input type="checkbox" name="tipos[]" value="etiquetas" checked> Etiquetas</label>
                        @if(auth()->user()->esAdmin())
                        <label><input type="checkbox" name="tipos[]" value="usuarios" checked> Usuarios</label>
                        @endif
                    </div>
                </div>
                
                <div class="filter-group">
                    <label for="orderBy">Ordenar por:</label>
                    <select name="orderBy" id="orderBy" class="form-control">
                        <option value="relevancia">Relevancia</option>
                        <option value="fecha">Fecha</option>
                        <option value="nombre">Nombre</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Resultados de búsqueda -->
    <div class="search-results-container">
        @if(isset($query) && $query)
        <div class="results-header">
            <h3>Resultados de búsqueda para: "{{ $query }}"</h3>
            <p class="results-count">{{ $total ?? 0 }} resultados encontrados</p>
        </div>
        
        <div class="results-content">
            @if(isset($resultados) && count($resultados) > 0)
                @foreach($resultados as $categoria => $items)
                <div class="result-category">
                    <h4>{{ ucfirst($categoria) }}</h4>
                    <div class="result-items">
                        @foreach($items as $item)
                        <div class="result-item">
                            <div class="result-icon">
                                <i class="fas fa-{{ $item['icono'] ?? 'file' }}"></i>
                            </div>
                            <div class="result-content">
                                <h5>{{ $item['titulo'] ?? 'Sin título' }}</h5>
                                <p>{{ $item['descripcion'] ?? 'Sin descripción' }}</p>
                                <small class="result-type">{{ $item['tipo'] ?? $categoria }}</small>
                            </div>
                            <div class="result-actions">
                                <a href="{{ $item['enlace'] ?? '#' }}" class="btn btn-sm btn-primary">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>No se encontraron resultados</h4>
                    <p>Intenta con otros términos de búsqueda o ajusta los filtros</p>
                </div>
            @endif
        </div>
        @endif
    </div>
    
    <!-- Búsquedas sugeridas -->
    <div class="suggested-searches">
        <h4>Búsquedas sugeridas</h4>
        <div class="suggestions-list">
            <button class="suggestion-btn" data-query="desarrollo">Desarrollo</button>
            <button class="suggestion-btn" data-query="marketing">Marketing</button>
            <button class="suggestion-btn" data-query="diseño">Diseño</button>
            <button class="suggestion-btn" data-query="programación">Programación</button>
            <button class="suggestion-btn" data-query="creatividad">Creatividad</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('JavaScript/buscador/index.js') }}"></script>
@endsection
                    <h4>No se encontraron resultados</h4>
                    <p>Intenta con otros términos de búsqueda o ajusta los filtros</p>
                </div>
            @endif
        </div>
        @endif
    </div>
    
    <!-- Búsquedas sugeridas -->
    <div class="suggested-searches">
        <h4>Búsquedas sugeridas</h4>
        <div class="suggestions-list">
            <button class="suggestion-btn" data-query="matemáticas">Matemáticas</button>
            <button class="suggestion-btn" data-query="estudiantes activos">Estudiantes activos</button>
            <button class="suggestion-btn" data-query="tareas pendientes">Tareas pendientes</button>
            <button class="suggestion-btn" data-query="exámenes próximos">Exámenes próximos</button>
            <button class="suggestion-btn" data-query="recursos educativos">Recursos educativos</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/shared/buscador/index.js') }}"></script>
@endsection