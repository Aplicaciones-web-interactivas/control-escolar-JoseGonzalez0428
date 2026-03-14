<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'clave',
    ];

    // Una materia puede tener muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'materia_id');
    }
}