<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Tarea;
use App\Models\Entrega;

class DashboardController extends Controller
{
    public function index()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'alumno') {
            $stats = [
                'inscripciones'  => Inscripcion::where('usuario_id', $id)->count(),
                'calificaciones' => Calificacion::where('usuario_id', $id)->count(),
                'promedio'       => round(Calificacion::where('usuario_id', $id)->avg('calificacion') ?? 0, 1),
                'tareas_total'   => Tarea::whereHas('grupo.inscripciones', function($q) use ($id) {
                                        $q->where('usuario_id', $id);
                                    })->count(),
                'tareas_entregadas' => Entrega::where('usuario_id', $id)->count(),
            ];

            $ultimas_calificaciones = Calificacion::with(['grupo.horario.materia'])
                                                            ->where('usuario_id', $id)
                                                            ->latest()->take(5)->get();

            $ultimas_inscripciones = Inscripcion::with(['grupo.horario.materia'])
                                                            ->where('usuario_id', $id)
                                                            ->latest()->take(5)->get();

        } elseif ($rol === 'maestro') {
            $misGruposIds = Grupo::whereHas('horario', function($q) use ($id) {
                                $q->where('usuario_id', $id);
                            })->pluck('id');

            $stats = [
                'grupos'         => $misGruposIds->count(),
                'inscripciones'  => Inscripcion::whereIn('grupo_id', $misGruposIds)->count(),
                'calificaciones' => Calificacion::whereIn('grupo_id', $misGruposIds)->count(),
                'tareas'         => Tarea::where('usuario_id', $id)->count(),
                'promedio'       => round (Calificacion::whereIn('grupo_id', $misGruposIds)->avg('calificacion') ?? 0, 1),
            ];

            $ultimas_calificaciones = Calificacion::with(['grupo.horario.materia', 'usuario'])
                                                            ->whereIn('grupo_id', $misGruposIds)
                                                            ->latest()->take(5)->get();

            $ultimas_inscripciones = Inscripcion::with(['grupo', 'usuario'])
                                                            ->whereIn('grupo_id', $misGruposIds)
                                                            ->latest()->take(5)->get();
        } else {
            // Admin ve todo
            $stats = [
                'usuarios'       => Usuario::count(),
                'alumnos'        => Usuario::where('rol', 'alumno')->count(),
                'maestros'       => Usuario::where('rol', 'maestro')->count(),
                'materias'       => Materia::count(),
                'grupos'         => Grupo::count(),
                'inscripciones'  => Inscripcion::count(),
                'calificaciones' => Calificacion::count(),
                'promedio'       => round (Calificacion::avg('calificacion') ?? 0, 1),
            ];

            $ultimas_calificaciones = Calificacion::with(['usuario', 'grupo.horario.materia'])
                                                            ->latest()->take(5)->get();

            $ultimas_inscripciones = Inscripcion::with(['usuario', 'grupo'])
                                                            ->latest()->take(5)->get();
        }

        return view('dashboard', compact('stats', 'ultimas_calificaciones', 'ultimas_inscripciones', 'rol'));
    }
}