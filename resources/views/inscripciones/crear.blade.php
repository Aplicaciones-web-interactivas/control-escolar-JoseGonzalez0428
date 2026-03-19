@extends('layouts.app')
@section('titulo', 'Nueva Inscripción')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Nueva Inscripción</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('inscripciones.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alumno</label>
                        <select name="usuario_id" class="form-select @error('usuario_id') is-invalid @enderror" required>
                            <option value="">-- Selecciona un alumno --</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}" {{ old('usuario_id') == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->nombre }} — {{ $alumno->clave_institucional }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Grupo</label>
                        <select name="grupo_id" class="form-select @error('grupo_id') is-invalid @enderror" required>
                            <option value="">-- Selecciona un grupo --</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }} — {{ $grupo->horario->materia->nombre ?? '—' }}
                                </option>
                            @endforeach
                        </select>
                        @error('grupo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Inscribir
                        </button>
                        <a href="{{ route('inscripciones.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection