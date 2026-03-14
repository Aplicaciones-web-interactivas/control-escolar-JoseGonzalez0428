{{-- Partial compartido por crear y editar --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Nombre completo</label>
    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Clave Institucional</label>
    <input type="text" name="clave_institucional" class="form-control @error('clave_institucional') is-invalid @enderror"
           value="{{ old('clave_institucional', $usuario->clave_institucional ?? '') }}" required>
    @error('clave_institucional')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">
        Contraseña {{ isset($usuario) ? '(dejar vacío para no cambiar)' : '' }}
    </label>
    <input type="password" name="contrasena"
           class="form-control @error('contrasena') is-invalid @enderror"
           {{ isset($usuario) ? '' : 'required' }}>
    @error('contrasena')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Rol</label>
    <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>
        @foreach(['alumno', 'maestro', 'admin'] as $rol)
            <option value="{{ $rol }}" {{ old('rol', $usuario->rol ?? 'alumno') === $rol ? 'selected' : '' }}>
                {{ ucfirst($rol) }}
            </option>
        @endforeach
    </select>
    @error('rol')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3 form-check form-switch">
    <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1"
           {{ old('activo', $usuario->activo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="activo">Usuario activo</label>
</div>