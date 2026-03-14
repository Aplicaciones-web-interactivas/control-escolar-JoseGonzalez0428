<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // GET /usuarios
    public function index()
    {
        $usuarios = Usuario::orderBy('nombre')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    // GET /usuarios/crear
    public function create()
    {
        return view('usuarios.crear');
    }

    // POST /usuarios
    public function store(Request $request)
    {
        $request->validate([
            'nombre'             => 'required|string|max:255',
            'clave_institucional'=> 'required|string|max:50|unique:usuarios',
            'contrasena'         => 'required|string|min:6',
            'rol'                => 'required|in:alumno,maestro,admin',
            'activo'             => 'boolean',
        ]);

        Usuario::create([
            'nombre'              => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'contrasena'          => Hash::make($request->contrasena),
            'rol'                 => $request->rol,
            'activo'              => $request->boolean('activo', true),
        ]);

        return redirect()->route('usuarios.index')
                         ->with('exito', 'Usuario creado correctamente.');
    }

    // GET /usuarios/{id}
    public function show(Usuario $usuario)
    {
        $usuario->load('horarios.materia');
        return view('usuarios.ver', compact('usuario'));
    }

    // GET /usuarios/{id}/editar
    public function edit(Usuario $usuario)
    {
        return view('usuarios.editar', compact('usuario'));
    }

    // PUT /usuarios/{id}
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre'             => 'required|string|max:255',
            'clave_institucional'=> 'required|string|max:50|unique:usuarios,clave_institucional,' . $usuario->id,
            'contrasena'         => 'nullable|string|min:6',
            'rol'                => 'required|in:alumno,maestro,admin',
            'activo'             => 'boolean',
        ]);

        $datos = [
            'nombre'              => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'rol'                 => $request->rol,
            'activo'              => $request->boolean('activo'),
        ];

        if ($request->filled('contrasena')) {
            $datos['contrasena'] = Hash::make($request->contrasena);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
                         ->with('exito', 'Usuario actualizado correctamente.');
    }

    // DELETE /usuarios/{id}
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')
                         ->with('exito', 'Usuario eliminado correctamente.');
    }
}