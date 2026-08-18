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
        Schema::table('pedido_items', function (Blueprint $table) {
            
            $table->foreign('pedido_id')
                  ->references('id')
                  ->on('pedidos')
                  ->onDelete('cascade');
            
            $table->foreign('variante_id')
                  ->references('id')
                  ->on('producto_variantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_items', function (Blueprint $table) {
            $table->dropForeign('pedido_id');
            $table->dropForeign('variante_id');
        });
    }
};
