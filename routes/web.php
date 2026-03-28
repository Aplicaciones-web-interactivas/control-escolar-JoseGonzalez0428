<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EntregaController;

// Rutas públicas (sin sesión)
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth.sesion')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('usuarios.index'));
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('horarios', HorarioController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('inscripciones', InscripcionController::class)->only([
    'index', 'create', 'store', 'show', 'destroy'
    ]);
    Route::resource('calificaciones', CalificacionController::class);

    //EXAMEN
    // Tareas
    Route::get('/tareas',             [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear',       [TareaController::class, 'create'])->name('tareas.create');
    Route::post('/tareas',            [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}',        [TareaController::class, 'show'])->name('tareas.show');
    Route::delete('/tareas/{id}',     [TareaController::class, 'destroy'])->name('tareas.destroy');

    // Entregas
    Route::post('/tareas/{tarea_id}/entregas',  [EntregaController::class, 'store'])->name('entregas.store');
    Route::get('/entregas/{id}',               [EntregaController::class, 'show'])->name('entregas.show');
});