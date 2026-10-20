<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\ProductoColor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductoService
{
    private function sincronizarColores(Producto $producto, array $colores): void
    {
        $idsExistentes = $producto->colores()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($colores as $orden => $datosColor) {
            $atributos = [
                'nombre' => $datosColor['nombre'],
                'codigo_hex' => $datosColor['codigo_hex'] ?? null,
                'orden' => $orden,
            ];

            if (isset($datosColor['id'])) {
                $color = $producto->colores()->findOrFail($datosColor['id']);
                $color->update($atributos);
            } else {
                $color = $producto->colores()->create($atributos);
            }
            $idsRecibidos[] = $color->id;

            $this->sincronizarVariantes($producto, $color, $datosColor['producto_variantes']);
            $this->sincronizarImagenes($producto, $color, $datosColor['producto_imagenes']);
        }

        $idsABorrar = array_diff($idsExistentes, $idsRecibidos);
        $producto->colores()->whereIn('id', $idsABorrar)->delete();

        // Tallas y fotos antiguas que no quedaron en ningún color (el admin las quitó)
        $producto->productoVariante()->whereNull('producto_color_id')->delete();
        $producto->productoImagen()->whereNull('producto_color_id')->delete();
    }

    private function sincronizarVariantes(Producto $producto, ProductoColor $color, array $variantes): void
    {
        // Primero se borran las tallas que ya no vienen, para no chocar con la regla de talla única por color
        $idsRecibidos = collect($variantes)->pluck('id')->filter()->all();
        $color->productoVariante()->whereNotIn('id', $idsRecibidos)->delete();

        foreach ($variantes as $variante) {
            if (isset($variante['id'])) {
                // Se busca en el producto (no solo en el color) para poder adoptar tallas antiguas sin color
                $producto->productoVariante()->findOrFail($variante['id'])->update([
                    'producto_color_id' => $color->id,
                    'talla' => $variante['talla'],
                    'stock' => $variante['stock'],
                ]);
            } else {
                $producto->productoVariante()->create([
                    'producto_color_id' => $color->id,
                    'talla' => $variante['talla'],
                    'stock' => $variante['stock'],
                    'sku' => "SAND-{$producto->id}-" . Str::slug($color->nombre) . "-{$variante['talla']}",
                ]);
            }
        }
    }

    private function sincronizarImagenes(Producto $producto, ProductoColor $color, array $imagenes): void
    {
        $idsRecibidos = collect($imagenes)->pluck('id')->filter()->all();
        $color->productoImagen()->whereNotIn('id', $idsRecibidos)->delete();

        foreach ($imagenes as $imagen) {
            if (isset($imagen['id'])) {
                $producto->productoImagen()->findOrFail($imagen['id'])->update([
                    'producto_color_id' => $color->id,
                    'url' => $imagen['url'],
                ]);
            } else {
                $producto->productoImagen()->create([
                    'producto_color_id' => $color->id,
                    'url' => $imagen['url'],
                ]);
            }
        }
    }

    public function store(array $datos): Producto
    {
        return DB::transaction(function () use ($datos) {
            $producto = Producto::create([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'precio' => $datos['precio'],
                'categoria_id' => $datos['categoria_id'],
                'activo' => true,
                'descuento_porcentaje' => $datos['descuento_porcentaje'] ?? 0,
            ]);

            $this->sincronizarColores($producto, $datos['colores']);

            return $producto->load('categoria', 'colores.productoVariante', 'colores.productoImagen');
        });
    }

    public function update(Producto $producto, array $datos): Producto
    {
        return DB::transaction(function () use ($producto, $datos) {
            $producto->update([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'precio' => $datos['precio'],
                'categoria_id' => $datos['categoria_id'],
                'activo' => $datos['activo'],
                'descuento_porcentaje' => $datos['descuento_porcentaje'] ?? 0,
            ]);

            $this->sincronizarColores($producto, $datos['colores']);

            return $producto->load('categoria', 'colores.productoVariante', 'colores.productoImagen');
        });
    }

    public function destroy(Producto $producto): string
    {
        return DB::transaction(function () use ($producto) {
            $tieneVentas = $producto->productoVariante()
                ->has('pedidoItems')
                ->exists();

            if ($tieneVentas) {
                $producto->update(['activo' => false]);
                return 'inactivo';
            }

            $producto->delete();
            return 'Producto eliminado con exito';
        });
    }
}