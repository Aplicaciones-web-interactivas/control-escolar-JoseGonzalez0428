<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    // GET /materias
    public function index()
    {
        $materias = Materia::orderBy('nombre')->paginate(15);
        return view('materias.index', compact('materias'));
    }

    // GET /materias/crear
    public function create()
    {
        return view('materias.crear');
    }

    // POST /materias
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave'  => 'required|string|max:20|unique:materias',
        ]);

        Materia::create($request->only('nombre', 'clave'));

        return redirect()->route('materias.index')
                         ->with('exito', 'Materia creada correctamente.');
    }

    // GET /materias/{id}
    public function show(Materia $materia)
    {
        $materia->load('horarios.usuario');
        return view('materias.ver', compact('materia'));
    }

    // GET /materias/{id}/editar
    public function edit(Materia $materia)
    {
        return view('materias.editar', compact('materia'));
    }

    // PUT /materias/{id}
    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave'  => 'required|string|max:20|unique:materias,clave,' . $materia->id,
        ]);

        $materia->update($request->only('nombre', 'clave'));

        return redirect()->route('materias.index')
                         ->with('exito', 'Materia actualizada correctamente.');
    }

    // DELETE /materias/{id}
    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('materias.index')
                         ->with('exito', 'Materia eliminada correctamente.');
    }
}