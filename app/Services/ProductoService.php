<?php

namespace App\Services;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;


class ProductoService
{
    private function sincronizarVariantes(Producto $producto, array $variantesNuevas): void {
        $idsExistentes = $producto->productoVariante()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($variantesNuevas as $variante) {
            if(isset($variante['id'])){
                $productoVariante = $producto->productoVariante()->find($variante['id']);
                $productoVariante->update([
                    'talla'=> $variante['talla'],
                    'stock'=> $variante['stock'],
                ]);
                $idsRecibidos[] = $productoVariante->id;
            }else{
                $nueva = $producto->productoVariante()->create([
                    'talla' => $variante['talla'],
                    'stock' => $variante['stock'],
                    'sku' => "SAND-{$producto->id}-{$variante['talla']}",
                ]);
                $idsRecibidos[] = $nueva->id;
            }
        }

        $idsABorrar = array_diff($idsExistentes, $idsRecibidos);
        $producto->productoVariante()->whereIn('id', $idsABorrar)->delete();        
    }

    private function sincronizarImagenes(Producto $producto, array $imagenes): void {
        $idsExistentes = $producto->productoImagen()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($imagenes as $imagen) {
            if(isset($imagen['id'])){
                $productoImagen = $producto->productoImagen()->find($imagen['id']);
                $productoImagen->update([
                    'url' => $imagen['url'],
                ]);
                $idsRecibidos[] = $productoImagen['id'];
            }else{
                $nueva = $producto->productoImagen()->create([
                    'url' => $imagen['url'],
                ]);
                $idsRecibidos[] = $nueva->id;
            }
        }

        $idsABorrar = array_diff($idsExistentes, $idsRecibidos);
        $producto->productoImagen()->whereIn('id', $idsABorrar)->delete();
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

            foreach ($datos['producto_variantes'] as $variante) {
            $producto->productoVariante()->create([
                'talla' => $variante['talla'],
                'stock' => $variante['stock'],
                'sku' => "SAND-{$producto->id}-{$variante['talla']}",
            ]);   
            }

            foreach ($datos['producto_imagenes'] as $imagen){
                $producto->productoImagen()->create([
                    'url' => $imagen['url'],
                ]);
            }

            return $producto->load('productoVariante', 'categoria', 'productoImagen');
        });

        
    }
    
    public function update(Producto $producto,  array $datos):Producto{
        return DB::transaction(function () use ($producto, $datos) {
            $producto->update([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'],
                'precio' => $datos['precio'],
                'categoria_id' => $datos['categoria_id'],
                'activo' => $datos['activo'],
                'descuento_porcentaje' => $datos['descuento_porcentaje'] ?? 0,
            ]);

                
            $this->sincronizarVariantes($producto, $datos['producto_variantes']);
            $this->sincronizarImagenes($producto, $datos['producto_imagenes']);

            return $producto->load('productoVariante', 'categoria', 'productoImagen');
        });

    }

    public function destroy(Producto $producto): string
    {
        return DB::transaction(function () use($producto) {
            $tieneVentas = $producto->productoVariante()
                            ->where('pedidoItems')
                            ->exists();
            
            if($tieneVentas){
                $producto->update([
                    'activo' => false,
                ]);
                return 'inactivo';
            }

            $producto->delete();
            return 'Producto eliminado con exito';
            
        
        });

    }
}
