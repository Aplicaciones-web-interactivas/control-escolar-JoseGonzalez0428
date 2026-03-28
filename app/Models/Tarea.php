<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_limite',
        'grupo_id',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
    ];

    // Tarea pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id', 'id');
    }

    // Tarea fue creada por un maestro
    public function maestro()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    // Tarea tiene muchas entregas
    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'tarea_id', 'id');
    }
}