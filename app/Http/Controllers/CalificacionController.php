<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index()
    {
        $calificaciones = Calificacion::with(['grupo.horario.materia', 'usuario'])
                                      ->orderBy('grupo_id')
                                      ->paginate(15);
        return view('calificaciones.index', compact('calificaciones'));
    }

    public function create()
    {
        $grupos  = Grupo::with('horario.materia')->orderBy('nombre')->get();
        $alumnos = Usuario::where('rol', 'alumno')->orderBy('nombre')->get();
        return view('calificaciones.crear', compact('grupos', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id'     => 'required|exists:grupos,id',
            'usuario_id'   => 'required|exists:usuarios,id',
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        // Verificar que el alumno esté inscrito en el grupo
        $inscrito = \App\Models\Inscripcion::where('grupo_id',   $request->grupo_id)
                                        ->where('usuario_id', $request->usuario_id)
                                        ->exists();

        if (!$inscrito) {
            return back()->withErrors([
                'usuario_id' => 'Este alumno no está inscrito en ese grupo.'
            ])->withInput();
        }

        // Verificar que no tenga ya una calificación en ese grupo
        $existe = Calificacion::where('grupo_id',   $request->grupo_id)
                            ->where('usuario_id', $request->usuario_id)
                            ->exists();

        if ($existe) {
            return back()->withErrors([
                'usuario_id' => 'Este alumno ya tiene calificación en ese grupo.'
            ])->withInput();
        }

        Calificacion::create($request->only('grupo_id', 'usuario_id', 'calificacion'));

        return redirect()->route('calificaciones.index')
                        ->with('exito', 'Calificación registrada correctamente.');
    }

    public function show($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->load(['usuario', 'grupo.horario.materia', 'grupo.horario.usuario']);
        return view('calificaciones.ver', compact('calificacion'));
    }

    public function edit($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $grupos  = Grupo::with('horario.materia')->orderBy('nombre')->get();
        $alumnos = Usuario::where('rol', 'alumno')->orderBy('nombre')->get();
        return view('calificaciones.editar', compact('calificacion', 'grupos', 'alumnos'));
    }

    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::findOrFail($id);

        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $calificacion->update(['calificacion' => $request->calificacion]);

        return redirect()->route('calificaciones.index')
                         ->with('exito', 'Calificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();
        return redirect()->route('calificaciones.index')
                         ->with('exito', 'Calificación eliminada correctamente.');
    }
}