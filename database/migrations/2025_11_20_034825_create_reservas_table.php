<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva'); // PK
            $table->string('dni_usuario'); // FK a usuarios
            $table->unsignedBigInteger('id_libro_fisico'); // FK a libros_fisicos
            $table->dateTime('fecha_reserva');
            $table->dateTime('fecha_limite_recojo');
            $table->enum('estado', ['ACTIVA', 'EXPIRADA', 'COMPLETADA'])->default('ACTIVA');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dni_usuario')->references('dni')->on('users')->onDelete('cascade');
            $table->foreign('id_libro_fisico')->references('id_libro_fisico')->on('libros_fisicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
