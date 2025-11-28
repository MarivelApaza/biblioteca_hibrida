<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {

            // Solo agrega columnas si no existen (para evitar errores)
            if (!Schema::hasColumn('favoritos', 'dni_usuario')) {
                $table->string('dni_usuario')->after('id');
            }

            if (!Schema::hasColumn('favoritos', 'id_referencia')) {
                $table->unsignedBigInteger('id_referencia')->after('dni_usuario');
            }

            if (!Schema::hasColumn('favoritos', 'tipo_recurso')) {
                $table->enum('tipo_recurso', ['FISICO', 'VIRTUAL'])->after('id_referencia');
            }

            // Opcional si deseas relacionar con users.dni
            // $table->foreign('dni_usuario')->references('dni')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {

            if (Schema::hasColumn('favoritos', 'dni_usuario')) {
                $table->dropColumn('dni_usuario');
            }

            if (Schema::hasColumn('favoritos', 'id_referencia')) {
                $table->dropColumn('id_referencia');
            }

            if (Schema::hasColumn('favoritos', 'tipo_recurso')) {
                $table->dropColumn('tipo_recurso');
            }
        });
    }
};
