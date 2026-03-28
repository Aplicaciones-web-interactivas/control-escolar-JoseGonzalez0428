<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Grupo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'alumno') {
            // Alumno solo ve sus propias inscripciones
            $inscripciones = Inscripcion::with(['grupo.horario.materia', 'usuario'])
                                        ->where('usuario_id', $id)
                                        ->orderBy('grupo_id')->paginate(15);
        } elseif ($rol === 'maestro') {
            // Maestro ve inscripciones de sus grupos
            $inscripciones = Inscripcion::with(['grupo.horario.materia', 'usuario'])
                                        ->whereHas('grupo.horario', function($q) use ($id) {
                                            $q->where('usuario_id', $id);
                                        })
                                        ->orderBy('grupo_id')->paginate(15);
        } else {
            $inscripciones = Inscripcion::with(['grupo.horario.materia', 'usuario'])
                                        ->orderBy('grupo_id')->paginate(15);
        }

        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'maestro') {
            $grupos = Grupo::with('horario.materia')
                        ->whereHas('horario', function($q) use ($id) {
                            $q->where('usuario_id', $id);
                        })
                        ->orderBy('nombre')
                        ->get();
        } elseif ($rol === 'alumno') {
            // Alumno ve todos los grupos disponibles
            $grupos = Grupo::with('horario.materia')->orderBy('nombre')->get();
        } else {
            $grupos = Grupo::with('horario.materia')->orderBy('nombre')->get();
        }

        // Alumno solo se puede inscribir a sí mismo
        if ($rol === 'alumno') {
            $alumnos = Usuario::where('id', $id)->get();
        } elseif ($rol === 'maestro') {
            // Maestro solo inscribe alumnos a sus grupos
            $alumnos = Usuario::where('rol', 'alumno')->orderBy('nombre')->get();
        } else {
            $alumnos = Usuario::where('rol', 'alumno')->orderBy('nombre')->get();
        }

        return view('inscripciones.crear', compact('grupos', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id'   => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        // Alumno solo puede inscribirse a sí mismo
        if ($rol === 'alumno' && $request->usuario_id != $id) {
            abort(403, 'Solo puedes inscribirte a ti mismo.');
        }

        // Maestro solo puede inscribir alumnos a sus grupos
        if ($rol === 'maestro') {
            $grupo = \App\Models\Grupo::findOrFail($request->grupo_id);
            if ($grupo->horario?->usuario_id != $id) {
                abort(403, 'Solo puedes inscribir alumnos a tus propios grupos.');
            }
        }

        // Verificar que no esté ya inscrito
        $existe = Inscripcion::where('grupo_id',   $request->grupo_id)
                             ->where('usuario_id', $request->usuario_id)
                             ->exists();

        if ($existe) {
            return back()->withErrors([
                'usuario_id' => 'Este alumno ya está inscrito en ese grupo.'
            ])->withInput();
        }

        // Crear la inscripción
        Inscripcion::create($request->only('grupo_id', 'usuario_id'));

        return redirect()->route('inscripciones.index')
                         ->with('exito', 'Inscripción realizada correctamente.');
    }

    public function show($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        
        $inscripcion->load([
            'usuario',
            'grupo.horario.materia',
            'grupo.horario.usuario',
        ]);
        
        return view('inscripciones.ver', compact('inscripcion'));
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->delete();
        return redirect()->route('inscripciones.index')
                        ->with('exito', 'Inscripción eliminada correctamente.');
    }
}