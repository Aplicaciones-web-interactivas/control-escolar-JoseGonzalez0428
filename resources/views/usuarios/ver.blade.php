@extends('layouts.app')
@section('titulo', 'Ver Usuario')

@section('contenido')
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Detalle de Usuario</h5>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                <p><strong>Clave Institucional:</strong> <code>{{ $usuario->clave_institucional }}</code></p>
                <p><strong>Rol:</strong>
                    <span class="badge bg-{{ $usuario->rol === 'admin' ? 'danger' : ($usuario->rol === 'maestro' ? 'primary' : 'secondary') }}">
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </p>
                <p><strong>Estado:</strong>
                    <span class="badge bg-{{ $usuario->activo ? 'success' : 'danger' }}">
                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </p>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock"></i> Horarios Asignados</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Materia</th><th>Días</th><th>Horario</th></tr>
                    </thead>
                    <tbody>
                        @forelse($usuario->horarios as $h)
                        <tr>
                            <td>{{ $h->materia->nombre ?? '—' }}</td>
                            <td>{{ implode(', ', $h->dias) }}</td>
                            <td>{{ $h->hora_inicio }} - {{ $h->hora_fin }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Sin horarios asignados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection