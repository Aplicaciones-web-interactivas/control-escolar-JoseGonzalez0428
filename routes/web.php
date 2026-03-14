<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;

Route::get('/', fn() => redirect()->route('usuarios.index'));

Route::resource('usuarios', UsuarioController::class)->parameters([
    'usuarios' => 'usuario',
])->names([
    'index'   => 'usuarios.index',
    'create'  => 'usuarios.create',
    'store'   => 'usuarios.store',
    'show'    => 'usuarios.show',
    'edit'    => 'usuarios.edit',
    'update'  => 'usuarios.update',
    'destroy' => 'usuarios.destroy',
]);

Route::resource('materias', MateriaController::class)->parameters([
    'materias' => 'materia',
]);

Route::resource('horarios', HorarioController::class)->parameters([
    'horarios' => 'horario',
]);