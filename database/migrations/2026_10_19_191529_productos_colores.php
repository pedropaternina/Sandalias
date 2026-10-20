<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Colores: cada producto tiene uno o varios
        Schema::create('producto_colores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('nombre');                      // "Rosa palo"
            $table->string('codigo_hex', 7)->nullable();   // "#F1DEDE" para el circulito de color
            $table->unsignedSmallInteger('orden')->default(0);
            $table->timestamps();
        });

        // 2. Las tallas (variantes) ahora pertenecen a un color.
        //    Es nullable para no romper los datos que ya tienes; luego se llena con el script de migración.
        Schema::table('producto_variantes', function (Blueprint $table) {
            $table->foreignUuid('producto_color_id')
                ->nullable()
                ->after('producto_id')
                ->constrained('producto_colores')
                ->cascadeOnDelete();

            // Un color no puede repetir la misma talla
            $table->unique(['producto_color_id', 'talla']);
        });

        // 3. Las fotos también pertenecen a un color
        //    (revisa que tu tabla se llame 'producto_imagenes')
        Schema::table('producto_imagenes', function (Blueprint $table) {
            $table->foreignUuid('producto_color_id')
                ->nullable()
                ->constrained('producto_colores')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('producto_imagenes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('producto_color_id');
        });

        Schema::table('producto_variantes', function (Blueprint $table) {
            $table->dropUnique(['producto_color_id', 'talla']);
            $table->dropConstrainedForeignId('producto_color_id');
        });

        Schema::dropIfExists('producto_colores');
    }
};