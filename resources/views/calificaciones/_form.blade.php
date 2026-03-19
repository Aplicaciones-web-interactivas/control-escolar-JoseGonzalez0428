<div class="mb-3">
    <label class="form-label fw-semibold">Alumno</label>
    <select name="usuario_id" class="form-select @error('usuario_id') is-invalid @enderror" required>
        <option value="">-- Selecciona un alumno --</option>
        @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}"
                {{ old('usuario_id', $calificacion->usuario_id ?? '') == $alumno->id ? 'selected' : '' }}>
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
            <option value="{{ $grupo->id }}"
                {{ old('grupo_id', $calificacion->grupo_id ?? '') == $grupo->id ? 'selected' : '' }}>
                {{ $grupo->nombre }} — {{ $grupo->horario?->materia?->nombre ?? '—' }}
            </option>
        @endforeach
    </select>
    @error('grupo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Calificación <small class="text-muted">(0 - 10)</small></label>
    <input type="number" name="calificacion" step="0.1" min="0" max="10"
           class="form-control @error('calificacion') is-invalid @enderror"
           value="{{ old('calificacion', $calificacion->calificacion ?? '') }}" required>
    @error('calificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>