@extends('layouts.app')
@section('titulo', 'Tareas')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-size:1.4rem;font-weight:600;">
        <i class="bi bi-clipboard-fill me-2" style="color:#6c63ff;"></i>Tareas
    </h2>
    @if(session('usuario_rol') === 'maestro')
        <a href="{{ route('tareas.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Nueva Tarea
        </a>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Grupo</th>
                    @if(session('usuario_rol') === 'maestro')
                        <th>Entregas</th>
                    @else
                        <th>Estado</th>
                    @endif
                    <th>Fecha límite</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                <tr>
                    <td data-label="Título">{{ $tarea->titulo }}</td>
                    <td data-label="Grupo">{{ $tarea->grupo?->nombre ?? '—' }}</td>

                    @if(session('usuario_rol') === 'maestro')
                        <td data-label="Entregas">
                            <span style="color:#4ecca3;font-weight:600;">
                                {{ $tarea->entregas->count() }}
                            </span> entregadas
                        </td>
                    @else
                        @php
                            $entrego = $tarea->entregas
                                ->where('usuario_id', session('usuario_id'))
                                ->count() > 0;
                        @endphp
                        <td data-label="Estado">
                            @if($entrego)
                                <span class="badge" style="background:rgba(78,204,163,0.15);color:#4ecca3;border:1px solid rgba(78,204,163,0.3);">
                                    <i class="bi bi-check-circle-fill me-1"></i>Entregada
                                </span>
                            @else
                                <span class="badge" style="background:rgba(255,107,107,0.15);color:#ff6b6b;border:1px solid rgba(255,107,107,0.3);">
                                    <i class="bi bi-clock me-1"></i>Pendiente
                                </span>
                            @endif
                        </td>
                    @endif

                    <td data-label="Fecha límite">
                        @php $vencida = $tarea->fecha_limite->isPast(); @endphp
                        <span style="color:{{ $vencida ? '#ff6b6b' : '#8892a4' }};font-size:13px;">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $tarea->fecha_limite->format('d/m/Y') }}
                        </span>
                    </td>

                    <td data-label="Acciones">
                        <a href="{{ route('tareas.show', $tarea->id) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(session('usuario_rol') === 'maestro')
                            <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST"
                                class="d-inline" id="form-tarea-{{ $tarea->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmarAccion(
                                            'form-tarea-{{ $tarea->id }}',
                                            '¿Eliminar tarea?',
                                            'Se eliminará la tarea {{ $tarea->titulo }} y todas las entregas.'
                                        )">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color:#8892a4;">
                        @if(session('usuario_rol') === 'maestro')
                            No has creado tareas todavía.
                        @else
                            No tienes tareas asignadas.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $tareas->links() }}</div>
@endsection