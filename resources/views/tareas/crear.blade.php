@extends('layouts.app')
@section('titulo', 'Nueva Tarea')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h5 class="mb-0" style="font-size:15px;font-weight:600;">
                    <i class="bi bi-clipboard-plus me-2" style="color:#6c63ff;"></i>Nueva Tarea
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tareas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo"
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}"
                               placeholder="Ej: Tarea 1 - Introducción a Laravel"
                               required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="4"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  placeholder="Instrucciones detalladas de la tarea..."
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Grupo</label>
                            <select name="grupo_id" class="form-select @error('grupo_id') is-invalid @enderror" required>
                                <option value="">-- Selecciona un grupo --</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }} — {{ $grupo->horario?->materia?->nombre ?? '—' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grupo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha límite de entrega</label>
                            <input type="date" name="fecha_limite"
                                   class="form-control @error('fecha_limite') is-invalid @enderror"
                                   value="{{ old('fecha_limite') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required>
                            @error('fecha_limite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Crear Tarea
                        </button>
                        <a href="{{ route('tareas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection