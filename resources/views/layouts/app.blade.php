<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Escolar - @yield('titulo', 'Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; }
        .sidebar { min-height: 100vh; background: #1e3a5f; }
        .sidebar a { color: #a8c0d6; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover, .sidebar a.active { background: #2a4f7c; color: #fff; }
        .sidebar .brand { color: #fff; font-size: 1.2rem; font-weight: bold; padding: 20px; border-bottom: 1px solid #2a4f7c; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <div class="col-md-2 p-0 sidebar">
            <div class="brand"><i class="bi bi-mortarboard-fill"></i> Control Escolar</div>
            <a href="{{ route('usuarios.index') }}" class="{{ request()->is('usuarios*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Usuarios
            </a>
            <a href="{{ route('materias.index') }}" class="{{ request()->is('materias*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Materias
            </a>
            <a href="{{ route('horarios.index') }}" class="{{ request()->is('horarios*') ? 'active' : '' }}">
                <i class="bi bi-clock"></i> Horarios
            </a>
            <a href="{{ route('grupos.index') }}" class="{{ request()->is('grupos*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i> Grupos
            </a>
            <a href="{{ route('inscripciones.index') }}" class="{{ request()->is('inscripciones*') ? 'active' : '' }}">
                <i class="bi bi-person-check"></i> Inscripciones
            </a>
            <a href="{{ route('calificaciones.index') }}" class="{{ request()->is('calificaciones*') ? 'active' : '' }}">
                <i class="bi bi-star"></i> Calificaciones
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" style="background:none; border:none; width:100%;"
                        class="text-start">
                    <a class="text-danger">
                        <i class="bi bi-box-arrow-left"></i> Cerrar sesión
                    </a>
                </button>
            </form>
        </div>

        {{-- Contenido --}}
        <div class="col-md-10 p-4">
            {{-- Mensajes flash --}}
            @if(session('exito'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('exito') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('contenido')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>