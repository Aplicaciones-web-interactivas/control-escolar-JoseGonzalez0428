@extends('layouts.app')
@section('titulo', 'Nueva Calificación')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-star-fill"></i> Nueva Calificación</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('calificaciones.store') }}" method="POST">
                    @csrf
                    @include('calificaciones._form')
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                        <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection