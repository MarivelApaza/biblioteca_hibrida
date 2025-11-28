<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('libros_virtuales', function (Blueprint $table) {
    $table->id('id_libro_virtual');
    $table->foreignId('id_categoria')->constrained('categorias','id_categoria')->cascadeOnDelete();
    $table->string('titulo');
    $table->string('autor')->nullable();
    $table->text('resumen_sinopsis')->nullable();
    $table->string('url_archivo')->nullable(); // ruta interna storage
    $table->string('peso_archivo')->nullable();
    $table->string('imagen_portada')->nullable();
    $table->text('palabras_clave')->nullable();
    $table->timestamps();

            // Clave foránea
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros_virtuales');
    }
};
