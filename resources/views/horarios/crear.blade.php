@extends('layouts.app')
@section('titulo', 'Nuevo Horario')

@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-clock-fill"></i> Nuevo Horario</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('horarios.store') }}" method="POST">
                    @csrf
                    @include('horarios._form')
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection