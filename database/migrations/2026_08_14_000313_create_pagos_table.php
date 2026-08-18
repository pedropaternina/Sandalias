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
        Schema::create('pagos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pedido_id');
            $table->string('gateway'); //wompi - addi 
            $table->string('metodo'); //nequi - pse - bancolombia
            $table->string('referencia_externa')->nullable()->unique(); // id transaccion gateway
            $table->string('estado'); // [pendiente, aprobado, rechazado, expirado]
            $table->decimal('monto',10,2);
            $table->json('raw_response')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
