<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'tarea_id',
        'usuario_id',
        'archivo_pdf',
        'fecha_entrega',
        'calificacion',
        'revisada',
    ];

    protected $casts = [
        'revisada' => 'boolean',
    ];
    // Entrega pertenece a una tarea
    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id', 'id');
    }

    // Entrega fue hecha por un alumno
    public function alumno()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }
}