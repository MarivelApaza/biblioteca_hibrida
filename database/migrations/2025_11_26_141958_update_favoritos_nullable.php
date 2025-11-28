<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {
            // Permitir que dni_usuario sea nullable (temporal)
            $table->string('dni_usuario')->nullable()->change();
            
            // Asegurarse que id_referencia y tipo_recurso existan y sean no nulos
            $table->unsignedBigInteger('id_referencia')->nullable(false)->change();
            $table->enum('tipo_recurso', ['FISICO', 'VIRTUAL'])->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {
            $table->string('dni_usuario')->nullable(false)->change();
        });
    }
};
