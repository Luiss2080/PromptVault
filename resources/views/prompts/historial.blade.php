@extends('components.usuario')

@section('title', 'Historial: ' . $prompt->titulo . ' - PromptVault')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-history text-primary"></i> Historial de Versiones</h1>
                <p class="text-muted">Prompt: <strong>{{ $prompt->titulo }}</strong></p>
            </div>
            <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Prompt
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Versión</th>
                                    <th>Fecha</th>
                                    <th>Mensaje de Cambio</th>
                                    <th>Contenido</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($versiones as $version)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold">v{{ $version->numero_version }}</span>
                                            @if($version->numero_version == $prompt->version_actual)
                                                <span class="badge bg-success ms-2">Actual</span>
                                            @endif
                                        </td>
                                        <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $version->mensaje_cambio ?: 'Sin descripción' }}</td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($version->contenido, 60) }}</small>
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($version->numero_version != $prompt->version_actual)
                                                <form action="{{ route('prompts.restaurar', [$prompt, $version]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('¿Deseas restaurar esta versión como la actual?')">
                                                        <i class="fas fa-undo"></i> Restaurar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($versiones->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $versiones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
