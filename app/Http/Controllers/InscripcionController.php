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
        $inscripciones = Inscripcion::with(['grupo.horario.materia', 'usuario'])
                                    ->orderBy('grupo_id')
                                    ->paginate(15);
        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create()
    {
        $grupos   = Grupo::with('horario.materia')->orderBy('nombre')->get();
        $alumnos  = Usuario::where('rol', 'alumno')->orderBy('nombre')->get();
        return view('inscripciones.crear', compact('grupos', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id'   => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

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