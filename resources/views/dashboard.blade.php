@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('contenido')

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label' => 'Total Usuarios',    'value' => $stats['usuarios'],       'icon' => 'bi-people-fill',       'color' => '#6c63ff'],
        ['label' => 'Alumnos',           'value' => $stats['alumnos'],        'icon' => 'bi-person-fill',       'color' => '#4ecca3'],
        ['label' => 'Maestros',          'value' => $stats['maestros'],       'icon' => 'bi-person-badge-fill', 'color' => '#f6c90e'],
        ['label' => 'Materias',          'value' => $stats['materias'],       'icon' => 'bi-book-fill',         'color' => '#ff6b6b'],
        ['label' => 'Grupos',            'value' => $stats['grupos'],         'icon' => 'bi-collection-fill',   'color' => '#4ecdc4'],
        ['label' => 'Inscripciones',     'value' => $stats['inscripciones'],  'icon' => 'bi-person-check-fill', 'color' => '#a78bfa'],
        ['label' => 'Calificaciones',    'value' => $stats['calificaciones'], 'icon' => 'bi-star-fill',         'color' => '#fb923c'],
        ['label' => 'Promedio General',  'value' => $stats['promedio'],       'icon' => 'bi-graph-up',          'color' => '#34d399'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="col-6 col-md-3">
        <div class="card h-100" style="border-radius:14px !important;">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div style="width:44px;height:44px;border-radius:12px;background:{{ $card['color'] }}22;
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi {{ $card['icon'] }}" style="font-size:20px;color:{{ $card['color'] }};"></i>
                </div>
                <div>
                    <div style="font-size:22px;font-weight:700;color:#e2e8f0;line-height:1.1;">
                        {{ $card['value'] }}
                    </div>
                    <div style="font-size:12px;color:#8892a4;">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Tablas recientes --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <span style="font-size:14px;font-weight:600;">Últimas Inscripciones</span>
                <a href="{{ route('inscripciones.index') }}" style="font-size:12px;color:#6c63ff;">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Grupo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimas_inscripciones as $i)
                        <tr>
                            <td data-label="Alumno">{{ $i->usuario?->nombre ?? '—' }}</td>
                            <td data-label="Grupo">{{ $i->grupo?->nombre ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center py-3" style="color:#8892a4;">Sin inscripciones</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <span style="font-size:14px;font-weight:600;">Últimas Calificaciones</span>
                <a href="{{ route('calificaciones.index') }}" style="font-size:12px;color:#6c63ff;">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Materia</th>
                            <th>Cal.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimas_calificaciones as $c)
                        <tr>
                            <td data-label="Alumno">{{ $c->usuario?->nombre ?? '—' }}</td>
                            <td data-label="Materia">{{ $c->grupo?->horario?->materia?->nombre ?? '—' }}</td>
                            <td data-label="Calificación">
                                <span style="font-weight:600;color:{{ $c->calificacion >= 6 ? '#4ecca3' : '#ff6b6b' }}">
                                    {{ number_format($c->calificacion, 1) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3" style="color:#8892a4;">Sin calificaciones</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection