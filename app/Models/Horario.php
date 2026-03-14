<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'materia_id',
        'usuario_id',
        'hora_inicio',
        'hora_fin',
        'dias',
    ];

    protected $casts = [
        'dias' => 'array',
    ];

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    // Relación con Usuario (maestro)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}