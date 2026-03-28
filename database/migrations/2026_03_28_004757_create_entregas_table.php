<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarea_id')->constrained('tareas')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade'); // alumno
            $table->string('archivo_pdf'); // ruta del archivo
            $table->timestamp('fecha_entrega')->useCurrent();
            
            // ---> Los campos nuevos que te sugirió Claude:
            $table->decimal('calificacion', 5, 2)->nullable();
            $table->boolean('revisada')->default(false);

            // Un alumno solo puede entregar una vez por tarea
            $table->unique(['tarea_id', 'usuario_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
