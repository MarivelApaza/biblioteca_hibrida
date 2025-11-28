<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prestamos_fisicos', function (Blueprint $table) {
            $table->id('id_prestamo'); // PK
            $table->string('dni_usuario'); // FK a usuarios
            $table->unsignedBigInteger('id_libro_fisico'); // FK a libros_fisicos
            $table->dateTime('fecha_salida');
            $table->date('fecha_devolucion_programada');
            $table->dateTime('fecha_devolucion_real')->nullable();
            $table->enum('estado', ['PENDIENTE', 'DEVUELTO', 'MORA'])->default('PENDIENTE');
            $table->text('observaciones_devolucion')->nullable(); // para rastreo de daños
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dni_usuario')->references('dni')->on('users')->onDelete('cascade');
            $table->foreign('id_libro_fisico')->references('id_libro_fisico')->on('libros_fisicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos_fisicos');
    }
};
