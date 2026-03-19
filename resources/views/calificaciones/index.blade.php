@extends('layouts.app')
@section('titulo', 'Calificaciones')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-star"></i> Calificaciones</h2>
    <a href="{{ route('calificaciones.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nueva Calificación
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
                    <th>Calificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calificaciones as $cal)
                <tr>
                    <td>{{ $cal->id }}</td>
                    <td>{{ $cal->usuario?->nombre ?? '—' }}</td>
                    <td>{{ $cal->grupo?->nombre ?? '—' }}</td>
                    <td>{{ $cal->grupo?->horario?->materia?->nombre ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $cal->calificacion >= 6 ? 'success' : 'danger' }} fs-6">
                            {{ number_format($cal->calificacion, 1) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('calificaciones.show', $cal->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('calificaciones.edit', $cal->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('calificaciones.destroy', $cal->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta calificación?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay calificaciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $calificaciones->links() }}</div>
@endsection