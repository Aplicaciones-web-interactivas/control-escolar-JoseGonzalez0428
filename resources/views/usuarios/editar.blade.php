@extends('layouts.app')
@section('titulo', 'Editar Usuario')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Usuario: {{ $usuario->nombre }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                    @csrf @method('PUT')
                    @include('usuarios._form')
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Actualizar
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection