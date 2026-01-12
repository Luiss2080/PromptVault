@extends('components.usuario')

@section('title', 'Mis Prompts - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-file-alt text-primary"></i> Mis Prompts</h1>
                <p class="text-muted">Gestiona y organiza tus prompts personales</p>
            </div>
            <a href="{{ route('prompts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Prompt
            </a>
        </div>
    </div>

    {{-- Filtros --}}
    <x-prompt.filters :etiquetas="$etiquetas" :showVisibility="true" />

    {{-- Grid de prompts --}}
    <x-prompt.grid 
        :prompts="$prompts" 
        emptyMessage="No tienes prompts todavía" 
        emptyIcon="inbox"
    />
</div>
@endsection
