<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['clave_institucional' => 'admin001'],
            [
                'nombre'              => 'Administrador',
                'clave_institucional' => 'admin001',
                'contrasena'          => Hash::make('1'),
                'rol'                 => 'admin',
                'activo'              => true,
            ]
        );
    }
}