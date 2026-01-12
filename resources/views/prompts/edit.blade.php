@extends('components.usuario')

@section('title', 'Editar Prompt: ' . $prompt->titulo . ' - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-edit text-primary"></i> Editar Prompt</h1>
            <p class="text-muted">Actualiza las instrucciones y configuración</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('prompts.update', $prompt) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del Prompt <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $prompt->titulo) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción Corta</label>
                            <textarea name="descripcion" id="descripcion" rows="2" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $prompt->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contenido" class="form-label">Instrucciones (Prompt) <span class="text-danger">*</span></label>
                            <textarea name="contenido" id="contenido" rows="8" class="form-control @error('contenido') is-invalid @enderror" required>{{ old('contenido', $prompt->contenido) }}</textarea>
                            <small class="text-muted">Usa [CORCHETES] para indicar variables. Se creará una nueva versión automáticamente.</small>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mensaje_cambio" class="form-label">¿Qué cambiaste? (Opcional)</label>
                            <input type="text" name="mensaje_cambio" id="mensaje_cambio" class="form-control" placeholder="Ej: Mejoré la claridad de las instrucciones">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="visibilidad" class="form-label">Visibilidad</label>
                                <select name="visibilidad" id="visibilidad" class="form-select">
                                    <option value="privado" {{ old('visibilidad', $prompt->visibilidad) == 'privado' ? 'selected' : '' }}>Privado (Solo yo)</option>
                                    <option value="publico" {{ old('visibilidad', $prompt->visibilidad) == 'publico' ? 'selected' : '' }}>Público (Todo el sistema)</option>
                                    <option value="enlace" {{ old('visibilidad', $prompt->visibilidad) == 'enlace' ? 'selected' : '' }}>Por Enlace (Cualquiera con el link)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="etiquetas" class="form-label">Etiquetas</label>
                                <select name="etiquetas_ids[]" id="etiquetas" class="form-select" multiple style="height: 100px;">
                                    @foreach($etiquetas as $etiqueta)
                                        <option value="{{ $etiqueta->id }}" {{ in_array($etiqueta->id, old('etiquetas_ids', $prompt->etiquetas->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $etiqueta->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Eliminar Prompt
                            </button>
                            <div class="gap-2 d-flex">
                                <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-4">Guardar Cambios</button>
                            </div>
                        </div>
                    </form>

                    <form id="deleteForm" action="{{ route('prompts.destroy', $prompt) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este prompt? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
