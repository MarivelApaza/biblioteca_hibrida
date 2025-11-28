<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apuntes_personales', function (Blueprint $table) {
            $table->id('id_apunte'); // PK
            $table->string('dni_usuario'); // FK a usuarios
            $table->unsignedBigInteger('id_libro_virtual'); // FK a libros_virtuales
            $table->integer('pagina_pdf')->nullable();
            $table->text('texto_nota')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('dni_usuario')->references('dni')->on('users')->onDelete('cascade');
            $table->foreign('id_libro_virtual')->references('id_libro_virtual')->on('libros_virtuales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apuntes_personales');
    }
};
