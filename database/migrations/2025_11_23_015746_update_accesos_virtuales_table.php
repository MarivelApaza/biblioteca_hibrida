<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('accesos_virtuales', function (Blueprint $table) {
        $table->enum('estado', ['ACTIVO', 'CADUCADO'])->default('ACTIVO')->change();
        // agrega aquí cualquier cambio adicional
    });
}

public function down()
{
    Schema::table('accesos_virtuales', function (Blueprint $table) {
        // revertir cambios
    });
}

};
