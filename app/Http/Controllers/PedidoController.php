<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PedidoService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Direccion;

class PedidoController extends Controller
{
    public function __construct(private PedidoService $pedidoService) {}

    public function showPedido()
    {
        $id = Auth::guard('cliente')->id();

        return Inertia::render('Pedido/Index', [
            'cliente' => $id ? Cliente::where('id', $id)->firstOrFail() : null,
            'direccion' => $id ? Direccion::where('cliente_id', $id)->get() : [],
        ]);
    }


    public function pedidoConfirm()
    {

    }

    public function store(StorePedidoRequest $request): RedirectResponse
    {
        $pedido = $this->pedidoService->store($request->validated());
        
        return redirect()
        ->route('pedido.confirm')
        ->with('mensaje', 'Pedido creado con exito');

    }
}