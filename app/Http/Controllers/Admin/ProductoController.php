<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Services\ProductoService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductoController extends Controller
{
    public function __construct(private ProductoService $productoService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Productos/Index', [
            'productos' => Producto::with('categoria', 'productoVariante', 'productoImagen')
                ->latest()
                ->get(),
        ]);
    }

    public function edit(Producto $producto): Response
    {
        return Inertia::render('Admin/Productos/Edit', [
            'producto' => $producto->load(
                'colores.productoVariante',
                'colores.productoImagen',
                'productoVariante',
                'productoImagen'
            ),
            'categorias' => Categoria::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Productos/Create', [
            'categorias' => Categoria::all(),
        ]);
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $producto = $this->productoService->store($request->validated());

        return redirect()
            ->route('admin.productos.index')
            ->with('mensaje', "Producto \"{$producto->nombre}\" creado con exito.");
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $this->productoService->update($producto, $request->validated());

        return redirect()
            ->route('admin.productos.index')
            ->with('mensaje', 'Producto actualizado con exito');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $resultado = $this->productoService->destroy($producto);
        $mensaje = $resultado == 'inactivo'
            ? 'No se pudo eliminar el producto ya que tiene pedidos activos'
            : 'Producto eliminado con exito';

        return redirect()->route('admin.productos.index')->with('mensaje', $mensaje);
    }
}