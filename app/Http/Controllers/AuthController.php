<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // GET /login
    public function showLogin()
    {
        // Si ya hay sesión activa, redirigir al inicio
        if (Session::has('usuario_id')) {
            return redirect()->route('usuarios.index');
        }
        return view('auth.login');
    }

    // POST /login
    public function login(Request $request)
    {
        $request->validate([
            'clave_institucional' => 'required|string',
            'contrasena'          => 'required|string',
        ]);

        $usuario = Usuario::where('clave_institucional', $request->clave_institucional)
                          ->where('activo', true)
                          ->first();

        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return back()->withErrors([
                'clave_institucional' => 'Credenciales incorrectas o usuario inactivo.',
            ])->withInput();
        }

        // Guardar datos en sesión
        Session::put('usuario_id',  $usuario->id);
        Session::put('usuario_nombre', $usuario->nombre);
        Session::put('usuario_rol',    $usuario->rol);

        return redirect()->route('usuarios.index')
                         ->with('exito', '¡Bienvenido, ' . $usuario->nombre . '!');
    }

    // POST /logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')
                         ->with('exito', 'Sesión cerrada correctamente.');
    }
}