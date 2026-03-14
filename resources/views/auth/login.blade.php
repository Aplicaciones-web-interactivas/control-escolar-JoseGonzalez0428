<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Escolar — Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #1e3a5f; min-height: 100vh; display: flex; align-items: center; }
        .card { border: none; border-radius: 12px; }
        .brand { color: #1e3a5f; font-weight: bold; font-size: 1.4rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-mortarboard-fill fs-1 text-primary"></i>
                    <h4 class="brand mt-2">Control Escolar</h4>
                    <p class="text-muted small">Inicia sesión para continuar</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('exito'))
                    <div class="alert alert-success">{{ session('exito') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Clave Institucional</label>
                        <input type="text" name="clave_institucional"
                               class="form-control @error('clave_institucional') is-invalid @enderror"
                               value="{{ old('clave_institucional') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>