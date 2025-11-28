<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('dni')->primary(); // PK personalizada

            $table->string('password');

            // Datos del usuario
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('semestre')->nullable();
            $table->enum('turno', ['MAÑANA','NOCHE'])->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono')->nullable();

            // Roles
            $table->enum('rol', ['ALUMNO','ADMINISTRADOR'])->default('ALUMNO');

            // Estado
            $table->enum('estado', ['ACTIVO','SANCIONADO'])->default('ACTIVO');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
