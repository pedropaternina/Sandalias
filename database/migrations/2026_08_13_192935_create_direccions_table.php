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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cliente_id');
            $table->string('pais');
            $table->string('departamento');
            $table->string('ciudad');
            $table->string('barrio');
            $table->string('direccion');
            $table->string('conjunto_o_edificio');
            $table->string('numero_casa_o_departamento');
            $table->string('indicaciones_adicionales');
            $table->string('codigo_postal');
            $table->string('telefono_contacto');
            $table->boolean('predeterminada');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
