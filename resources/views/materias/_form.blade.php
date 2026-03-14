<div class="mb-3">
    <label class="form-label fw-semibold">Nombre de la materia</label>
    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $materia->nombre ?? '') }}" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Clave</label>
    <input type="text" name="clave" class="form-control @error('clave') is-invalid @enderror"
           value="{{ old('clave', $materia->clave ?? '') }}" required>
    @error('clave')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>