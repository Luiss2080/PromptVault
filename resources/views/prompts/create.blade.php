@extends('components.usuario')

@section('title', 'Crear Nuevo Prompt - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-plus-circle text-primary"></i> Crear Nuevo Prompt</h1>
            <p class="text-muted">Define las instrucciones para tu IA</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('prompts.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del Prompt <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required placeholder="Ej: Generador de ideas de marketing">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción Corta</label>
                            <textarea name="descripcion" id="descripcion" rows="2" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Explica brevemente para qué sirve este prompt">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contenido" class="form-label">Instrucciones (Prompt) <span class="text-danger">*</span></label>
                            <textarea name="contenido" id="contenido" rows="8" class="form-control @error('contenido') is-invalid @enderror" required placeholder="Escribe aquí las instrucciones detalladas para la IA...">{{ old('contenido') }}</textarea>
                            <small class="text-muted">Usa [CORCHETES] para indicar variables que el usuario debe completar.</small>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="visibilidad" class="form-label">Visibilidad</label>
                                <select name="visibilidad" id="visibilidad" class="form-select @error('visibilidad') is-invalid @enderror">
                                    <option value="privado" {{ old('visibilidad') == 'privado' ? 'selected' : '' }}>Privado (Solo yo)</option>
                                    <option value="publico" {{ old('visibilidad') == 'publico' ? 'selected' : '' }}>Público (Todo el sistema)</option>
                                    <option value="enlace" {{ old('visibilidad') == 'enlace' ? 'selected' : '' }}>Por Enlace (Cualquiera con el link)</option>
                                </select>
                                @error('visibilidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="etiquetas" class="form-label">Etiquetas</label>
                                <select name="etiquetas_ids[]" id="etiquetas" class="form-select" multiple style="height: 100px;">
                                    @foreach($etiquetas as $etiqueta)
                                        <option value="{{ $etiqueta->id }}" {{ is_array(old('etiquetas_ids')) && in_array($etiqueta->id, old('etiquetas_ids')) ? 'selected' : '' }}>
                                            {{ $etiqueta->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionado Ctrl (Cmd en Mac) para seleccionar varias.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('prompts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">Guardar Prompt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
