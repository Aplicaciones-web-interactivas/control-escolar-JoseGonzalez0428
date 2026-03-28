<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Materia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // GET /horarios
    public function index()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'maestro') {
            $horarios = Horario::with(['materia', 'usuario'])
                            ->where('usuario_id', $id)
                            ->orderBy('hora_inicio')->paginate(15);
        } else {
            $horarios = Horario::with(['materia', 'usuario'])
                            ->orderBy('hora_inicio')->paginate(15);
        }

        return view('horarios.index', compact('horarios'));
    }

    // GET /horarios/crear
    public function create()
    {
        $materias = Materia::orderBy('nombre')->get();
        $usuarios = Usuario::where('rol', 'maestro')->orderBy('nombre')->get();
        return view('horarios.crear', compact('materias', 'usuarios'));
    }

    // POST /horarios
    public function store(Request $request)
    {
        $request->validate([
            'materia_id'  => 'required|exists:materias,id',
            'usuario_id'  => 'required|exists:usuarios,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'dias'        => 'required|array|min:1',
            'dias.*'      => 'in:lunes,martes,miercoles,jueves,viernes,sabado',
        ]);

        // Maestro solo puede crear horarios donde él es el profesor
        if (session('usuario_rol') === 'maestro' && $request->usuario_id != session('usuario_id')) {
            abort(403, 'Solo puedes crear horarios donde tú eres el maestro.');
        }

        Horario::create($request->only(
            'materia_id', 'usuario_id', 'hora_inicio', 'hora_fin', 'dias'
        ));

        return redirect()->route('horarios.index')
                         ->with('exito', 'Horario creado correctamente.');
    }

    // GET /horarios/{id}
    public function show(Horario $horario)
    {
        $horario->load(['materia', 'usuario']);
        return view('horarios.ver', compact('horario'));
    }

    // GET /horarios/{id}/editar
    public function edit(Horario $horario)
    {
        $materias = Materia::orderBy('nombre')->get();
        $usuarios = Usuario::where('rol', 'maestro')->orderBy('nombre')->get();
        return view('horarios.editar', compact('horario', 'materias', 'usuarios'));
    }

    // PUT /horarios/{id}
    public function update(Request $request, Horario $horario)
    {

        // Maestro solo puede editar sus propios horarios
        if (session('usuario_rol') === 'maestro' && $horario->usuario_id != session('usuario_id')) {
            abort(403, 'No puedes editar horarios de otros maestros.');
        }

        $request->validate([
            'materia_id'  => 'required|exists:materias,id',
            'usuario_id'  => 'required|exists:usuarios,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin'    => 'required|date_format:H:i|after:hora_inicio',
            'dias'        => 'required|array|min:1',
            'dias.*'      => 'in:lunes,martes,miercoles,jueves,viernes,sabado',
        ]);

        if (session('usuario_rol') === 'maestro') {
            $request->merge(['usuario_id' => session('usuario_id')]);
        }

        $horario->update($request->only(
            'materia_id', 'usuario_id', 'hora_inicio', 'hora_fin', 'dias'
        ));

        return redirect()->route('horarios.index')
                         ->with('exito', 'Horario actualizado correctamente.');
    }

    // DELETE /horarios/{id}
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')
                         ->with('exito', 'Horario eliminado correctamente.');
    }
}