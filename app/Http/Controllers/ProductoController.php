<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function getProductos()
    {
        return Producto::where('activo', true)
            ->with('categoria', 'productoVariante', 'productoImagen')
            ->get();
    }

    public function getProductoId($productoId)
    {
        return Producto::where('activo', true)
            ->where('id', $productoId)
            ->with('categoria', 'productoVariante', 'productoImagen', 'colores.productoVariante', 'colores.productoImagen')
            ->firstOrFail();
    }

    public function showDetalles($productoId)
    {
        return Inertia::render('Landing/DetallesProducto', [
            'producto' => Producto::where('activo', true)
                ->where('id', $productoId)
                ->with('categoria', 'productoVariante', 'productoImagen', 'colores.productoVariante', 'colores.productoImagen')
                ->firstOrFail(),
        ]);
    }
}