<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Grupo;
use App\Models\Entrega;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    // Lista de tareas según el rol
    public function index()
    {
        $rol = session('usuario_rol');
        $id  = session('usuario_id');

        if ($rol === 'maestro') {
            // Maestro ve solo sus tareas
            $tareas = Tarea::with(['grupo', 'entregas'])
                           ->where('usuario_id', $id)
                           ->orderByDesc('created_at')
                           ->paginate(15);
        } else {
            // Alumno ve las tareas de los grupos en que está inscrito
            $tareas = Tarea::with(['grupo', 'maestro'])
                           ->whereHas('grupo.inscripciones', function($q) use ($id) {
                               $q->where('usuario_id', $id);
                           })
                           ->orderBy('fecha_limite')
                           ->paginate(15);
        }

        return view('tareas.index', compact('tareas'));
    }

    // Formulario nueva tarea (solo maestro)
    public function create()
    {
        $id = session('usuario_id');
        // Solo los grupos donde el maestro tiene horario asignado
        $grupos = Grupo::with('horario.materia')
                       ->whereHas('horario', function($q) use ($id) {
                           $q->where('usuario_id', $id);
                       })
                       ->get();

        return view('tareas.crear', compact('grupos'));
    }

    // Guardar nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha_limite' => 'required|date|after:today',
            'grupo_id'     => 'required|exists:grupos,id',
        ]);

        Tarea::create([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
            'grupo_id'     => $request->grupo_id,
            'usuario_id'   => session('usuario_id'),
        ]);

        return redirect()->route('tareas.index')
                         ->with('exito', 'Tarea creada correctamente.');
    }

    // Ver tarea y sus entregas (maestro) o detalle (alumno)
    public function show($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->load(['grupo', 'maestro', 'entregas.alumno']);

        $rol = session('usuario_rol');
        $usuario_id = session('usuario_id');

        // Ver si el alumno ya entregó
        $miEntrega = null;
        if ($rol === 'alumno') {
            $miEntrega = Entrega::where('tarea_id', $tarea->id)
                                ->where('usuario_id', $usuario_id)
                                ->first();
        }

        return view('tareas.ver', compact('tarea', 'miEntrega'));
    }

    // Eliminar tarea (solo maestro)
    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return redirect()->route('tareas.index')
                         ->with('exito', 'Tarea eliminada correctamente.');
    }
}