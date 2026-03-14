<div class="mb-3">
    <label class="form-label fw-semibold">Nombre del Grupo</label>
    <input type="text" name="nombre"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $grupo->nombre ?? '') }}" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Horario</label>
    <select name="horario_id" class="form-select @error('horario_id') is-invalid @enderror" required>
        <option value="">-- Selecciona un horario --</option>
        @foreach($horarios as $horario)
            <option value="{{ $horario->id }}"
                {{ old('horario_id', $grupo->horario_id ?? '') == $horario->id ? 'selected' : '' }}>
                {{ $horario->materia->nombre ?? '—' }} |
                {{ implode(', ', $horario->dias) }} |
                {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}
            </option>
        @endforeach
    </select>
    @error('horario_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>