<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripcions';

    protected $fillable = [
        'grupo_id',
        'usuario_id',
    ];

    // Pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id', 'id');
    }

    // Pertenece a un usuario (alumno)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }
}