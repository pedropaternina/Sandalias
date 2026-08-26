<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\ProductoService;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Http\RedirectResponse;

class ProductoController extends Controller
{
    
    public function __construct(private ProductoService $productoService) {}

    public function index(): Response
    {

        return Inertia::render('Productos/Index', [
            'productos' => Producto::with('categoria', 'productoVariante', 'productoImagen')->get(),
            'categorias' => Categoria::all(),            
        ]);
    }


    public function create(): Response
    {
        return Inertia::render('Productos/Create', [
            'categorias' => Categoria::all(),
        ]);
    }


    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $producto = $this->productoService->store($request->validated());
        
        return redirect()
        ->route('productos.index')
        ->with('mensaje', "Producto \"{$producto->nombre}\"creado con exito."); 
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto = $this->productoService->update($producto, $request->validated());
        return redirect()->route('productos.index')->with('mensaje', 'Producto actualizado con exito');
    }

    public function destroy(Producto $producto)
    {
        $resultado = $this->productoService->destroy($producto);
        $mensaje = $resultado == 'inactivo' 
                   ? 'No se pudo eliminar el producto ya que tiene pedidos activos' 
                   : 'Producto eliminado con exito';

        return redirect()->route('productos.index')->with('mensaje', $mensaje );
    }

}   