@extends('layouts.app')
@section('titulo', 'Grupos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-collection"></i> Grupos</h2>
    <a href="{{ route('grupos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Grupo
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Materia</th>
                    <th>Maestro</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                <tr>
                    <td>{{ $grupo->id }}</td>
                    <td>{{ $grupo->nombre }}</td>
                    <td>{{ $grupo->horario->materia->nombre ?? '—' }}</td>
                    <td>{{ $grupo->horario->usuario->nombre ?? '—' }}</td>
                    <td>
                        {{ implode(', ', $grupo->horario->dias) }}
                        {{ $grupo->horario->hora_inicio }} - {{ $grupo->horario->hora_fin }}
                    </td>
                    <td>
                        <a href="{{ route('grupos.show', $grupo) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('grupos.edit', $grupo) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este grupo?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay grupos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $grupos->links() }}</div>
@endsection