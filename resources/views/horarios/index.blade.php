@extends('layouts.app')
@section('titulo', 'Horarios')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-clock"></i> Horarios</h2>
    <a href="{{ route('horarios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Horario
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Materia</th>
                    <th>Maestro</th>
                    <th>Días</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios as $horario)
                <tr>
                    <td data-label="ID">{{ $horario->id }}</td>
                    <td data-label="Materia">{{ $horario->materia->nombre ?? '—' }}</td>
                    <td data-label="Maestro">{{ $horario->usuario->nombre ?? '—' }}</td>
                    <td data-label="Días">{{ implode(', ', $horario->dias) }}</td>
                    <td data-label="Hora Inicio">{{ $horario->hora_inicio }}</td>
                    <td data-label="Hora Fin">{{ $horario->hora_fin }}</td>
                    <td data-label="Acciones">
                        <a href="{{ route('horarios.show', $horario) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('horarios.destroy', $horario) }}" method="POST"
                            class="d-inline" id="form-horario-{{ $horario->id }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmarAccion(
                                        'form-horario-{{ $horario->id }}',
                                        '¿Eliminar horario?',
                                        'Se eliminará este horario y los grupos asociados.'
                                    )">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay horarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $horarios->links() }}</div>
@endsection