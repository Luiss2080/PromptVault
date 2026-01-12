@extends('components.usuario')

@section('title', 'Compartidos Conmigo - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-share-alt text-primary"></i> Compartidos Conmigo</h1>
            <p class="text-muted">Prompts a los que otros usuarios te han dado acceso</p>
        </div>
    </div>

    {{-- Filtros (Opcional si usas el mismo de index) --}}
    <div class="row mb-4">
        <div class="col-12">
            <x-prompt.filters :etiquetas="collect()" :showVisibility="false" />
        </div>
    </div>

    {{-- Grid de prompts --}}
    <x-prompt.grid 
        :prompts="$prompts" 
        emptyMessage="No te han compartido ningún prompt todavía" 
        emptyIcon="share-alt"
    />
</div>
@endsection
