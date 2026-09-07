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
        Schema::create('pedido_direcciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pais');
            $table->string('departamento');
            $table->string('ciudad');
            $table->string('barrio');
            $table->string('direccion');
            $table->string('conjunto_o_edificio')->nullable();
            $table->string('numero_casa_o_departamento')->nullable();
            $table->string('indicaciones_adicionales')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_direcciones');
    }
};
