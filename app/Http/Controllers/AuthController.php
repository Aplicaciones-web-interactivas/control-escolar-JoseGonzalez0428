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
            return redirect()->route('login')
                             ->with('exito', 'Ya has iniciado sesión como ' . session('usuario_nombre') . '.');
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

    Session::put('usuario_id',     $usuario->id);
    Session::put('usuario_nombre', $usuario->nombre);
    Session::put('usuario_rol',    $usuario->rol);

    // Si es admin, obtener frase de Chuck Norris traducida
    if ($usuario->rol === 'admin') {
        try {
            // Obtener frase en inglés
            $response = file_get_contents('https://api.chucknorris.io/jokes/random');
            $joke     = json_decode($response, true);
            $frase    = $joke['value'];

            // Traducir con MyMemory API (gratis, sin key)
            $url         = 'https://api.mymemory.translated.net/get?q=' . urlencode($frase) . '&langpair=en|es';
            $traduccion  = file_get_contents($url);
            $resultado   = json_decode($traduccion, true);
            $fraseEs     = $resultado['responseData']['translatedText'] ?? $frase;

            Session::put('chuck_frase', $fraseEs);
        } catch (\Exception $e) {
            // Si falla la API, no pasa nada
            Session::put('chuck_frase', null);
        }
    }

    return redirect()->route('dashboard')
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