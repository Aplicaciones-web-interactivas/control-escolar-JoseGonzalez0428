@extends('layouts.app')
@section('titulo', 'Ver Horario')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-clock"></i> Detalle de Horario</h5>
            </div>
            <div class="card-body">
                <p><strong>Materia:</strong> {{ $horario->materia->nombre ?? '—' }}</p>
                <p><strong>Clave:</strong> <code>{{ $horario->materia->clave ?? '—' }}</code></p>
                <p><strong>Maestro:</strong> {{ $horario->usuario->nombre ?? '—' }}</p>
                <p><strong>Días:</strong> {{ implode(', ', $horario->dias) }}</p>
                <p><strong>Hora inicio:</strong> {{ $horario->hora_inicio }}</p>
                <p><strong>Hora fin:</strong> {{ $horario->hora_fin }}</p>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('horarios.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection