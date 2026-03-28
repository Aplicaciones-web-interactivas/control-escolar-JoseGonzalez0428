@extends('layouts.app')
@section('titulo', 'Ver Grupo')

@section('contenido')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-collection"></i> Detalle del Grupo</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $grupo->nombre }}</p>
                <p><strong>Materia:</strong> {{ $grupo->horario->materia->nombre ?? '—' }}</p>
                <p><strong>Maestro:</strong> {{ $grupo->horario->usuario->nombre ?? '—' }}</p>
                <p><strong>Días:</strong> {{ $grupo->horario ? implode(', ', $grupo->horario->dias) : '—' }}</p>
                <p><strong>Horario:</strong> {{ $grupo->horario ? $grupo->horario->hora_inicio . ' - ' . $grupo->horario->hora_fin : '—' }}</p>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('grupos.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-people"></i> Alumnos Inscritos</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Nombre</th><th>Clave Institucional</th></tr>
                    </thead>
                    <tbody>
                        @forelse($grupo->inscripciones as $inscripcion)
                        <tr>
                            <td data-label="ID">{{ $loop->iteration }}</td>
                            <td data-label="Nombre">{{ $inscripcion->usuario->nombre ?? '—' }}</td>
                            <td data-label="Clave Institucional"><code>{{ $inscripcion->usuario->clave_institucional ?? '—' }}</code></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin alumnos inscritos.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection