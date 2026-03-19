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
                    <td>{{ $inscripcion->id }}</td>
                    <td>{{ $inscripcion->usuario->nombre ?? '—' }}</td>
                    <td>{{ $inscripcion->grupo->nombre ?? '—' }}</td>
                    <td>{{ $inscripcion->grupo->horario->materia->nombre ?? '—' }}</td>
                    <td>
                        <a href="{{ route('inscripciones.show', $inscripcion) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('inscripciones.destroy', $inscripcion) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta inscripción?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
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