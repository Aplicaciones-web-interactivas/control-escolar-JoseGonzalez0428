@extends('layouts.app')
@section('titulo', 'Grupos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-collection"></i> Grupos</h2>
    @if(in_array(session('usuario_rol'), ['admin', 'maestro']))
        <a href="{{ route('grupos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Grupo
        </a>
    @endif
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
                    @if(in_array(session('usuario_rol'), ['admin', 'maestro']))
                        <th>Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($grupos as $grupo)
                <tr>
                    <td data-label="ID">{{ $grupo->id }}</td>
                    <td data-label="Nombre">{{ $grupo->nombre }}</td>
                    <td data-label="Materia">{{ $grupo->horario->materia->nombre ?? '—' }}</td>
                    <td data-label="Maestro">{{ $grupo->horario->usuario->nombre ?? '—' }}</td>
                    <td data-label="Horario">
                        {{ implode(', ', $grupo->horario->dias) }}
                        {{ $grupo->horario->hora_inicio }} - {{ $grupo->horario->hora_fin }}
                    </td>
                    @if(in_array(session('usuario_rol'), ['admin', 'maestro']))
                        <td data-label="Acciones">
                            <a href="{{ route('grupos.show', $grupo->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST"
                                class="d-inline" id="form-grupo-{{ $grupo->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmarAccion(
                                            'form-grupo-{{ $grupo->id }}',
                                            '¿Eliminar grupo?',
                                            'Se eliminará el grupo {{ $grupo->nombre }} y todas sus inscripciones.'
                                        )">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    @endif
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