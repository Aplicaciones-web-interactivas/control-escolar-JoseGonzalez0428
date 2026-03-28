<div class="mb-3">
    <label class="form-label fw-semibold">Materia</label>
    <select name="materia_id" class="form-select @error('materia_id') is-invalid @enderror" required>
        <option value="">-- Selecciona una materia --</option>
        @foreach($materias as $materia)
            <option value="{{ $materia->id }}"
                {{ old('materia_id', $horario->materia_id ?? '') == $materia->id ? 'selected' : '' }}>
                {{ $materia->nombre }} ({{ $materia->clave }})
            </option>
        @endforeach
    </select>
    @error('materia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

@if(session('usuario_rol') === 'maestro')
    <input type="hidden" name="usuario_id" value="{{ session('usuario_id') }}">
@else
    <div class="mb-3">
        <label class="form-label fw-semibold">Maestro</label>
        <select name="usuario_id" class="form-select @error('usuario_id') is-invalid @enderror" required>
            <option value="">-- Selecciona un maestro --</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}"
                    {{ old('usuario_id', $horario->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>
        @error('usuario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
@endif

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Hora Inicio</label>
        <input type="time" name="hora_inicio"
               class="form-control @error('hora_inicio') is-invalid @enderror"
               value="{{ old('hora_inicio', $horario->hora_inicio ?? '') }}" required>
        @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Hora Fin</label>
        <input type="time" name="hora_fin"
               class="form-control @error('hora_fin') is-invalid @enderror"
               value="{{ old('hora_fin', $horario->hora_fin ?? '') }}" required>
        @error('hora_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Días</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach(['lunes','martes','miercoles','jueves','viernes','sabado'] as $dia)
        <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   name="dias[]" value="{{ $dia }}" id="dia_{{ $dia }}"
                   {{ in_array($dia, old('dias', $horario->dias ?? [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="dia_{{ $dia }}">
                {{ ucfirst($dia) }}
            </label>
        </div>
        @endforeach
    </div>
    @error('dias')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>