<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EntregaController;

// Rutas públicas
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth.sesion')->group(function () {

    // Dashboard — todos
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Usuarios — solo admin
    Route::middleware('rol:admin')->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('materias', MateriaController::class);
    });

    // Horarios — admin y maestro
    Route::middleware('rol:admin,maestro')->group(function () {
        Route::resource('horarios', HorarioController::class);
    });

    // Grupos — todos pueden ver, admin y maestro pueden modificar
    Route::get('/grupos',          [GrupoController::class, 'index'])->name('grupos.index');
    
    Route::middleware('rol:admin,maestro')->group(function () {
        Route::get('/grupos/crear',          [GrupoController::class, 'create'])->name('grupos.create');
        Route::post('/grupos',               [GrupoController::class, 'store'])->name('grupos.store');
        Route::get('/grupos/{id}/editar',    [GrupoController::class, 'edit'])->name('grupos.edit');
        Route::put('/grupos/{id}',           [GrupoController::class, 'update'])->name('grupos.update');
        Route::delete('/grupos/{id}',        [GrupoController::class, 'destroy'])->name('grupos.destroy');
    });
    Route::get('/grupos/{id}',     [GrupoController::class, 'show'])->name('grupos.show');

    // Inscripciones — todos acceden, lógica de permisos en el controlador
    Route::resource('inscripciones', InscripcionController::class)->only([
        'index', 'create', 'store', 'show', 'destroy'
    ]);

    // Calificaciones — lógica de permisos en el controlador
    Route::resource('calificaciones', CalificacionController::class);


    //EXAMEN
    // Tareas y entregas
    Route::get('/tareas',                            [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear',                      [TareaController::class, 'create'])->name('tareas.create');
    Route::post('/tareas',                           [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}',                       [TareaController::class, 'show'])->name('tareas.show');
    Route::delete('/tareas/{id}',                    [TareaController::class, 'destroy'])->name('tareas.destroy');
    Route::post('/tareas/{tarea_id}/entregas',       [EntregaController::class, 'store'])->name('entregas.store');
    Route::delete('/entregas/{id}',                  [EntregaController::class, 'destroy'])->name('entregas.destroy');
    Route::get('/entregas/{id}',                     [EntregaController::class, 'show'])->name('entregas.show');
    Route::post('/entregas/{id}/calificar', [EntregaController::class, 'calificar'])->name('entregas.calificar');
});