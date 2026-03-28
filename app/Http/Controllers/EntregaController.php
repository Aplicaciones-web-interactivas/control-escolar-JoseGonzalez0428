<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Tarea;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    // Subir entrega (alumno)
    public function store(Request $request, $tarea_id)
    {
        $tarea = Tarea::findOrFail($tarea_id);

        // Verificar que no haya entregado ya
        $yaEntrego = Entrega::where('tarea_id', $tarea_id)
                            ->where('usuario_id', session('usuario_id'))
                            ->exists();

        if ($yaEntrego) {
            return back()->withErrors(['archivo' => 'Ya entregaste esta tarea.']);
        }

        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:5120', // max 5MB
        ]);

        // Guardar el archivo en storage/app/public/entregas
        $ruta = $request->file('archivo')->store('entregas', 'public');

        Entrega::create([
            'tarea_id'   => $tarea_id,
            'usuario_id' => session('usuario_id'),
            'archivo_pdf'=> $ruta,
        ]);

        return redirect()->route('tareas.show', $tarea_id)
                         ->with('exito', 'Tarea entregada correctamente.');
    }

    // Ver/descargar PDF (maestro)
    public function show($id)
    {
        $entrega = Entrega::findOrFail($id);
        $ruta    = storage_path('app/public/' . $entrega->archivo_pdf);

        if (!file_exists($ruta)) {
            return back()->withErrors(['archivo' => 'Archivo no encontrado.']);
        }

        return response()->file($ruta, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    // Cancelar entrega (alumno)
    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);

        // Solo el alumno dueño puede cancelar su entrega
        if ($entrega->usuario_id != session('usuario_id')) {
            abort(403, 'No puedes cancelar la entrega de otro alumno.');
        }

        // Eliminar el archivo físico
        $ruta = storage_path('app/public/' . $entrega->archivo_pdf);
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        $entrega->delete();

        return redirect()->route('tareas.show', $entrega->tarea_id)
                        ->with('exito', 'Entrega cancelada. Ya puedes subir otro archivo.');
    }

    public function calificar(Request $request, $id)
    {
        // Solo maestros pueden calificar
        if (session('usuario_rol') !== 'maestro' && session('usuario_rol') !== 'admin') {
            abort(403, 'No tienes permiso para calificar entregas.');
        }

        $entrega = Entrega::findOrFail($id);

        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:10',
        ]);

        $entrega->update([
            'calificacion' => $request->calificacion,
            'revisada'     => true,
        ]);

        return redirect()->route('tareas.show', $entrega->tarea_id)
                        ->with('exito', 'Entrega calificada correctamente.');
    }
}