@extends('layouts.app')
@section('titulo', 'Usuarios')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Usuario
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Clave Institucional</th>
                    <th>Rol</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td><code>{{ $usuario->clave_institucional }}</code></td>
                    <td>
                        <span class="badge bg-{{ $usuario->rol === 'admin' ? 'danger' : ($usuario->rol === 'maestro' ? 'primary' : 'secondary') }}">
                            {{ ucfirst($usuario->rol) }}
                        </span>
                    </td>
                    <td>
                        @if($usuario->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $usuarios->links() }}</div>
@endsection