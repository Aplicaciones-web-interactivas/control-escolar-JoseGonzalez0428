<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
        'horario_id',
    ];

    // Un grupo pertenece a un horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    // Un grupo tiene muchas inscripciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'grupo_id');
    }

    // Alumnos inscritos en este grupo (a través de inscripciones)
    public function alumnos()
    {
        return $this->belongsToMany(Usuario::class, 'inscripcions', 'grupo_id', 'usuario_id');
    }
}