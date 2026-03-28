<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Escolar — @yield('titulo', 'Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    
</head>
<body>

{{-- Sidebar --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🎓</div>
        <span>Control Escolar</span>
    </div>

    <div class="sidebar-nav">
        <div class="nav-section-title">Principal</div>
            <a href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        @if(session('usuario_rol') === 'admin')
            <a href="{{ route('usuarios.index') }}"
            class="sidebar-link {{ request()->is('usuarios*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Usuarios
            </a>
            <a href="{{ route('materias.index') }}"
            class="sidebar-link {{ request()->is('materias*') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> Materias
            </a>
        @endif

        @if(in_array(session('usuario_rol'), ['admin', 'maestro']))
            <a href="{{ route('horarios.index') }}"
            class="sidebar-link {{ request()->is('horarios*') ? 'active' : '' }}">
                <i class="bi bi-clock-fill"></i> Horarios
            </a>
        @endif

        <div class="nav-section-title">Académico</div>
        <a href="{{ route('grupos.index') }}"
        class="sidebar-link {{ request()->is('grupos*') ? 'active' : '' }}">
            <i class="bi bi-collection-fill"></i> Grupos
        </a>
        <a href="{{ route('inscripciones.index') }}"
        class="sidebar-link {{ request()->is('inscripciones*') ? 'active' : '' }}">
            <i class="bi bi-person-check-fill"></i> Inscripciones
        </a>
        <a href="{{ route('calificaciones.index') }}"
        class="sidebar-link {{ request()->is('calificaciones*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Calificaciones
        </a>

        <div class="nav-section-title">Tareas</div>
        <a href="{{ route('tareas.index') }}"
        class="sidebar-link {{ request()->is('tareas*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-fill"></i> Tareas
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-pill">
            <div class="user-avatar">
                {{ strtoupper(substr(session('usuario_nombre', 'U'), 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ session('usuario_nombre', 'Usuario') }}</div>
                <div class="user-role">{{ ucfirst(session('usuario_rol', '')) }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--ce-muted);font-size:16px;"
                        title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

{{-- Topbar --}}
<header id="topbar">
    <button id="toggle-sidebar" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">@yield('titulo', 'Panel')</span>
</header>

{{-- Contenido principal --}}
<main id="main-content">

    @if(session('chuck_frase'))
        <div class="alert d-flex align-items-center gap-3 mb-4"
             style="background:rgba(108,99,255,0.1);border:1px solid rgba(108,99,255,0.3);color:var(--ce-text);border-radius:12px;">
            <span style="font-size:1.8rem;">🥋</span>
            <div><strong style="color:var(--ce-accent);">Chuck Norris dice:</strong><br>
                <em>{{ session('chuck_frase') }}</em></div>
        </div>
        {{ Session::forget('chuck_frase') }}
    @endif

    @if(session('exito'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('exito') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('contenido')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const topbar  = document.getElementById('topbar');
    const main    = document.getElementById('main-content');
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        sidebar.classList.toggle('open');
        overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
    } else {
        sidebar.classList.toggle('collapsed');
        topbar.classList.toggle('expanded');
        main.classList.toggle('expanded');
    }
}

// Cerrar sidebar al cambiar a móvil
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        document.getElementById('sidebar-overlay').style.display = 'none';
        document.getElementById('sidebar').classList.remove('open');
    }
});
</script>

{{-- Modal de confirmación global --}}
<div id="modal-confirm" style="display:none;position:fixed;inset:0;z-index:9999;
     background:rgba(0,0,0,0.6);align-items:center;justify-content:center;">
    <div style="background:#1a1d27;border:1px solid #2a2d3e;border-radius:16px;
                padding:32px;max-width:400px;width:90%;text-align:center;">
        <div id="modal-icon" style="font-size:3rem;margin-bottom:16px;">🗑️</div>
        <h5 id="modal-title" style="color:#e2e8f0;font-weight:600;margin-bottom:8px;"></h5>
        <p id="modal-message" style="color:#8892a4;font-size:14px;margin-bottom:24px;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="cerrarModal()"
                    style="padding:10px 24px;border-radius:10px;border:1px solid #2a2d3e;
                           background:transparent;color:#8892a4;cursor:pointer;font-size:14px;">
                Cancelar
            </button>
            <button id="modal-btn-confirm"
                    style="padding:10px 24px;border-radius:10px;border:none;
                           background:#ef4444;color:#fff;cursor:pointer;font-size:14px;font-weight:600;">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
let _formPendiente = null;

function confirmarAccion(formId, titulo, mensaje, icono = '🗑️', colorBtn = '#ef4444') {
    _formPendiente = document.getElementById(formId);
    document.getElementById('modal-icon').textContent    = icono;
    document.getElementById('modal-title').textContent   = titulo;
    document.getElementById('modal-message').textContent = mensaje;
    document.getElementById('modal-btn-confirm').style.background = colorBtn;
    const modal = document.getElementById('modal-confirm');
    modal.style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal-confirm').style.display = 'none';
    _formPendiente = null;
}

document.getElementById('modal-btn-confirm').addEventListener('click', function() {
    if (_formPendiente) _formPendiente.submit();
    cerrarModal();
});

// Cerrar al hacer click fuera
document.getElementById('modal-confirm').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>

</body>
</html>