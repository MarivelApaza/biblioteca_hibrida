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
        Schema::table('favoritos', function (Blueprint $table) {
            // Asegurarnos de que las columnas existan
            if (!Schema::hasColumn('favoritos', 'dni_usuario')) {
                $table->string('dni_usuario')->after('id');
            } else {
                $table->string('dni_usuario')->nullable(false)->change();
            }

            if (!Schema::hasColumn('favoritos', 'id_referencia')) {
                $table->unsignedBigInteger('id_referencia')->after('dni_usuario');
            } else {
                $table->unsignedBigInteger('id_referencia')->nullable(false)->change();
            }

            if (!Schema::hasColumn('favoritos', 'tipo_recurso')) {
                $table->enum('tipo_recurso', ['FISICO', 'VIRTUAL'])->after('id_referencia');
            } else {
                $table->enum('tipo_recurso', ['FISICO', 'VIRTUAL'])->nullable(false)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {
            // Opcional: revertir a nullable si quieres
            if (Schema::hasColumn('favoritos', 'dni_usuario')) {
                $table->string('dni_usuario')->nullable()->change();
            }
            if (Schema::hasColumn('favoritos', 'id_referencia')) {
                $table->unsignedBigInteger('id_referencia')->nullable()->change();
            }
            if (Schema::hasColumn('favoritos', 'tipo_recurso')) {
                $table->enum('tipo_recurso', ['FISICO', 'VIRTUAL'])->nullable()->change();
            }
        });
    }
};
