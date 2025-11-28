<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accesos_virtuales', function (Blueprint $table) {
            $table->id('id_acceso'); // PK
            $table->string('dni_usuario'); // FK a usuarios
            $table->unsignedBigInteger('id_libro_virtual'); // FK a libros_virtuales
            $table->string('token_seguridad')->unique();
            $table->dateTime('fecha_generacion');
            $table->dateTime('fecha_caducidad');
            $table->enum('estado', ['ACTIVO', 'CADUCADO'])->default('ACTIVO');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dni_usuario')->references('dni')->on('users')->onDelete('cascade');
            $table->foreign('id_libro_virtual')->references('id_libro_virtual')->on('libros_virtuales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accesos_virtuales');
    }
};
