<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'clave_institucional',
        'contrasena',
        'rol',
        'activo',
    ];

    protected $hidden = [
        'contrasena',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Un maestro puede tener muchos horarios asignados
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'usuario_id');
    }
}