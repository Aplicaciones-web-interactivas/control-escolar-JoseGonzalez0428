<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Inscripcion;
use App\Models\Calificacion;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'usuarios'      => Usuario::count(),
            'alumnos'       => Usuario::where('rol', 'alumno')->count(),
            'maestros'      => Usuario::where('rol', 'maestro')->count(),
            'materias'      => Materia::count(),
            'grupos'        => Grupo::count(),
            'inscripciones' => Inscripcion::count(),
            'calificaciones'=> Calificacion::count(),
            'promedio'      => round(Calificacion::avg('calificacion') ?? 0, 1),
        ];

        $ultimas_calificaciones = Calificacion::with(['usuario', 'grupo.horario.materia'])
                                              ->latest()
                                              ->take(5)
                                              ->get();

        $ultimas_inscripciones = Inscripcion::with(['usuario', 'grupo'])
                                            ->latest()
                                            ->take(5)
                                            ->get();

        return view('dashboard', compact('stats', 'ultimas_calificaciones', 'ultimas_inscripciones'));
    }
}