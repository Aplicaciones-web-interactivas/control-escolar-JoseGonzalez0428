<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Horario;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'maestro') {
            $grupos = Grupo::with('horario.materia')
                        ->whereHas('horario', function($q) use ($id) {
                            $q->where('usuario_id', $id);
                        })
                        ->orderBy('nombre')->paginate(15);
        } else {
            $grupos = Grupo::with('horario.materia')->orderBy('nombre')->paginate(15);
        }

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $horarios = Horario::with('materia')->orderBy('id')->get();
        return view('grupos.crear', compact('horarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        // Maestro solo puede crear grupos de sus horarios
        if (session('usuario_rol') === 'maestro') {
            $horario = \App\Models\Horario::findOrFail($request->horario_id);
            if ($horario->usuario_id != session('usuario_id')) {
                abort(403, 'Solo puedes crear grupos en tus propios horarios.');
            }
        }

        Grupo::create($request->only('nombre', 'horario_id'));

        return redirect()->route('grupos.index')
                         ->with('exito', 'Grupo creado correctamente.');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load('horario.materia', 'horario.usuario', 'inscripciones.usuario');
        return view('grupos.ver', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $horarios = Horario::with('materia')->orderBy('id')->get();
        return view('grupos.editar', compact('grupo', 'horarios'));
    }

    public function update(Request $request, Grupo $grupo)
    {   
        // Maestro solo puede editar grupos de sus horarios
        if (session('usuario_rol') === 'maestro' && $grupo->horario?->usuario_id != session('usuario_id')) {
            abort(403, 'No puedes editar grupos de otros maestros.');
        }

        $request->validate([
            'nombre'     => 'required|string|max:100',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        // Maestro no puede asignar el grupo a un horario de otro maestro
        if (session('usuario_rol') === 'maestro') {
            $horario = \App\Models\Horario::findOrFail($request->horario_id);
            if ($horario->usuario_id != session('usuario_id')) {
                abort(403, 'No puedes asignar este grupo a un horario que no es tuyo.');
            }
        }
        
        $grupo->update($request->only('nombre', 'horario_id'));

        return redirect()->route('grupos.index')
                         ->with('exito', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        if (session('usuario_rol') === 'maestro' && $grupo->horario?->usuario_id != session('usuario_id')) {
            abort(403, 'No puedes eliminar grupos de otros maestros.');
        }

        $grupo->delete();
        return redirect()->route('grupos.index')
                         ->with('exito', 'Grupo eliminado correctamente.');
    }
}