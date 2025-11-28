<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('libros_fisicos', function (Blueprint $table) {
            $table->id('id_libro_fisico'); // PK
            $table->unsignedBigInteger('id_categoria'); // FK
            $table->string('titulo');
            $table->string('autor');
            $table->string('isbn')->nullable();
            $table->string('editorial')->nullable();
            $table->integer('año_edicion')->nullable();
            $table->enum('tipo_encuadernacion', ['TAPA_DURA', 'RUSTICA'])->default('RUSTICA');
            $table->enum('estado_promedio', ['NUEVO', 'BUENO', 'REGULAR'])->default('NUEVO');
            $table->integer('stock_total')->default(0);
            $table->integer('stock_disponible')->default(0);
            $table->string('ubicacion_pasillo')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->text('palabras_clave')->nullable();
            $table->timestamps();

            // Clave foránea
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros_fisicos');
    }
};
