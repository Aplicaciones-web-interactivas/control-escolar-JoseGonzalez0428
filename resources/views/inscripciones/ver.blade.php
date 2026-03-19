@extends('layouts.app')
@section('titulo', 'Ver Inscripción')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-person-check"></i> Detalle de Inscripción</h5>
            </div>
            <div class="card-body">
                <p><strong>Alumno:</strong> {{ $inscripcion->usuario?->nombre ?? '—' }}</p>
                <p><strong>Clave:</strong> <code>{{ $inscripcion->usuario?->clave_institucional ?? '—' }}</code></p>
                <p><strong>Grupo:</strong> {{ $inscripcion->grupo?->nombre ?? '—' }}</p>
                <p><strong>Materia:</strong> {{ $inscripcion->grupo?->horario?->materia?->nombre ?? '—' }}</p>
                <p><strong>Maestro:</strong> {{ $inscripcion->grupo?->horario?->usuario?->nombre ?? '—' }}</p>
                <p><strong>Horario:</strong>
                    @if($inscripcion->grupo?->horario)
                        {{ implode(', ', $inscripcion->grupo->horario->dias) }}
                        {{ $inscripcion->grupo->horario->hora_inicio }} -
                        {{ $inscripcion->grupo->horario->hora_fin }}
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection