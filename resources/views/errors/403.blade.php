@extends('layouts.app')
@section('titulo', 'Acceso denegado')

@section('contenido')
<div style="text-align:center;padding:60px 0;">
    <div style="font-size:4rem;">🔒</div>
    <h2 style="font-size:1.5rem;font-weight:700;margin-top:16px;color:#e2e8f0;">Acceso denegado</h2>
    <p style="color:#8892a4;margin-top:8px;">{{ $exception->getMessage() }}</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
        <i class="bi bi-house me-1"></i> Volver al inicio
    </a>
</div>
@endsection