@extends('layouts.app')
@section('titulo', 'Materias')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-book"></i> Materias</h2>
    <a href="{{ route('materias.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Nueva Materia
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr><th>#</th><th>Nombre</th><th>Clave</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                <tr>
                    <td>{{ $materia->id }}</td>
                    <td>{{ $materia->nombre }}</td>
                    <td><code>{{ $materia->clave }}</code></td>
                    <td>
                        <a href="{{ route('materias.show', $materia) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta materia?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No hay materias registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $materias->links() }}</div>
@endsection