@extends('layouts.app')
@section('titulo', 'Editar Calificación')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Calificación</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('calificaciones.update', $calificacion->id) }}" method="POST">
                    @csrf @method('PUT')
                    {{-- En editar solo se puede cambiar la calificación --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alumno</label>
                        <input type="text" class="form-control" value="{{ $calificacion->usuario?->nombre }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Grupo</label>
                        <input type="text" class="form-control" value="{{ $calificacion->grupo?->nombre }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Calificación <small class="text-muted">(0 - 10)</small></label>
                        <input type="number" name="calificacion" step="0.1" min="0" max="10"
                               class="form-control @error('calificacion') is-invalid @enderror"
                               value="{{ old('calificacion', $calificacion->calificacion) }}" required>
                        @error('calificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Actualizar
                        </button>
                        <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection