@extends('layouts.app')
@section('titulo', 'Ver Calificación')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-star"></i> Detalle de Calificación</h5>
            </div>
            <div class="card-body">
                <p><strong>Alumno:</strong> {{ $calificacion->usuario?->nombre ?? '—' }}</p>
                <p><strong>Clave:</strong> <code>{{ $calificacion->usuario?->clave_institucional ?? '—' }}</code></p>
                <p><strong>Grupo:</strong> {{ $calificacion->grupo?->nombre ?? '—' }}</p>
                <p><strong>Materia:</strong> {{ $calificacion->grupo?->horario?->materia?->nombre ?? '—' }}</p>
                <p><strong>Maestro:</strong> {{ $calificacion->grupo?->horario?->usuario?->nombre ?? '—' }}</p>
                <p><strong>Calificación:</strong>
                    <span class="badge bg-{{ $calificacion->calificacion >= 6 ? 'success' : 'danger' }} fs-6">
                        {{ number_format($calificacion->calificacion, 1) }}
                    </span>
                </p>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('calificaciones.edit', $calificacion->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection