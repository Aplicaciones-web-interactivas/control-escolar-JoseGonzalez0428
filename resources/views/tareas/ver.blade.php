@extends('layouts.app')
@section('titulo', 'Ver Tarea')

@section('contenido')
<div class="row g-4">

    {{-- Detalle de la tarea --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header py-3 px-4">
                <h5 class="mb-0" style="font-size:15px;font-weight:600;">
                    <i class="bi bi-clipboard me-2" style="color:#6c63ff;"></i>Detalle de Tarea
                </h5>
            </div>
            <div class="card-body p-4">
                <h4 style="font-size:1.1rem;font-weight:600;color:#e2e8f0;margin-bottom:12px;">
                    {{ $tarea->titulo }}
                </h4>

                <p style="font-size:14px;color:#8892a4;line-height:1.7;margin-bottom:20px;">
                    {{ $tarea->descripcion }}
                </p>

                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#8892a4;">Grupo</span>
                        <span style="color:#e2e8f0;font-weight:500;">{{ $tarea->grupo?->nombre ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#8892a4;">Materia</span>
                        <span style="color:#e2e8f0;font-weight:500;">{{ $tarea->grupo?->horario?->materia?->nombre ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;">
                        <span style="color:#8892a4;">Maestro</span>
                        <span style="color:#e2e8f0;font-weight:500;">{{ $tarea->maestro?->nombre ?? '—' }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding-top:8px;border-top:1px solid #2a2d3e;">
                        <span style="color:#8892a4;">Fecha límite</span>
                        @php $vencida = $tarea->fecha_limite->isPast(); @endphp
                        <span style="color:{{ $vencida ? '#ff6b6b' : '#4ecca3' }};font-weight:600;">
                            {{ $tarea->fecha_limite->format('d/m/Y') }}
                            @if($vencida) <small>(Vencida)</small> @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer px-4 py-3">
                <a href="{{ route('tareas.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Panel derecho: entrega (alumno) o lista de entregas (maestro) --}}
    <div class="col-md-7">

        @if(session('usuario_rol') === 'alumno')
            {{-- Vista alumno --}}
            <div class="card">
                <div class="card-header py-3 px-4">
                    <h5 class="mb-0" style="font-size:15px;font-weight:600;">
                        <i class="bi bi-upload me-2" style="color:#4ecca3;"></i>Mi Entrega
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($miEntrega)
                        {{-- Ya entregó --}}
                        <div style="text-align:center;padding:20px 0;">
                            <div style="font-size:3rem;">✅</div>
                            <p style="color:#4ecca3;font-weight:600;margin-top:12px;">¡Tarea entregada!</p>
                            <p style="font-size:13px;color:#8892a4;">
                                Entregada el {{ \Carbon\Carbon::parse($miEntrega->fecha_entrega)->format('d/m/Y H:i') }}
                            </p>
                            <a href="{{ route('entregas.show', $miEntrega->id) }}"
                               class="btn btn-sm btn-outline-info mt-2" target="_blank">
                                <i class="bi bi-file-pdf me-1"></i> Ver mi PDF
                            </a>
                        </div>
                    @elseif($tarea->fecha_limite->isPast())
                        {{-- Venció --}}
                        <div style="text-align:center;padding:20px 0;">
                            <div style="font-size:3rem;">❌</div>
                            <p style="color:#ff6b6b;font-weight:600;margin-top:12px;">Fecha límite vencida</p>
                            <p style="font-size:13px;color:#8892a4;">Ya no es posible entregar esta tarea.</p>
                        </div>
                    @else
                        {{-- Puede entregar --}}
                        <p style="font-size:13px;color:#8892a4;margin-bottom:20px;">
                            Sube tu entrega en formato PDF. Máximo 5MB.
                        </p>
                        <form action="{{ route('entregas.store', $tarea->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Archivo PDF</label>
                                <input type="file" name="archivo"
                                       class="form-control @error('archivo') is-invalid @enderror"
                                       accept=".pdf" required>
                                @error('archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Entregar
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        @else
            {{-- Vista maestro: lista de entregas --}}
            <div class="card">
                <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-size:15px;font-weight:600;">
                        <i class="bi bi-people-fill me-2" style="color:#4ecca3;"></i>
                        Entregas recibidas
                        <span style="font-size:13px;color:#8892a4;font-weight:400;margin-left:8px;">
                            {{ $tarea->entregas->count() }} entrega(s)
                        </span>
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Fecha entrega</th>
                                <th>Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tarea->entregas as $entrega)
                            <tr>
                                <td data-label="Alumno">{{ $entrega->alumno?->nombre ?? '—' }}</td>
                                <td data-label="Fecha">
                                    <span style="font-size:13px;color:#8892a4;">
                                        {{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                                <td data-label="Archivo">
                                    <a href="{{ route('entregas.show', $entrega->id) }}"
                                       class="btn btn-sm btn-outline-info" target="_blank">
                                        <i class="bi bi-file-pdf me-1"></i> Ver PDF
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4" style="color:#8892a4;">
                                    Ningún alumno ha entregado aún.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection