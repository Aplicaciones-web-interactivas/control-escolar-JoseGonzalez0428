@extends('layouts.app')
@section('titulo', 'Inscripciones')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-person-check"></i> Inscripciones</h2>
    <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nueva Inscripción
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Alumno</th>
                    <th>Grupo</th>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                <tr>
                    <td data-label="ID">{{ $inscripcion->id }}</td>
                    <td data-label="Alumno">{{ $inscripcion->usuario->nombre ?? '—' }}</td>
                    <td data-label="Grupo">{{ $inscripcion->grupo->nombre ?? '—' }}</td>
                    <td data-label="Materia">{{ $inscripcion->grupo->horario->materia->nombre ?? '—' }}</td>
                    <td data-label="Acciones">
                        <a href="{{ route('inscripciones.show', $inscripcion) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('inscripciones.destroy', $inscripcion->id) }}" method="POST"
                            class="d-inline" id="form-inscripcion-{{ $inscripcion->id }}">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmarAccion(
                                        'form-inscripcion-{{ $inscripcion->id }}',
                                        '¿Eliminar inscripción?',
                                        'Se dará de baja a {{ $inscripcion->usuario?->nombre }} del grupo {{ $inscripcion->grupo?->nombre }}.'
                                    )">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No hay inscripciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $inscripciones->links() }}</div>
@endsection