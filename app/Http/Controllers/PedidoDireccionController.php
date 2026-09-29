<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoDireccion ;

class PedidoDireccionController extends Controller
{
    public function __construct(private PedidoDireccionService $pedidoDireccionService){}

    public function getPedidosDireccion()
    {
        return PedidoDireccion::all();
    }

    public function getPedidoDireccionId($pedidoDireccionId)
    {
        return PedidoDireccion::where('id', $pedidoDireccionId);
    } 

    public function store(StorePedidoDireccionRequest $request)
    {
        $producto = $this->pedidoDireccionService->store($request->validated());
        
        return $producto;
    }

    public function update(UpdatePedidoDireccionRequest $request, PedidoDireccion $pedidoDireccion)
    {
        $pDireccion = $this->pedidoDireccionService->update($producto, $request->validated());
        return $pDireccion;
    }

    public function destroy(PedidoDireccion $producto)
    {
        $resultado = $this->pedidoDireccionService->destroy($producto);

        return $resultado;
    }
}
