<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\PedidoService;
use Inertia\Inertia;
use App\Models\Cliente;
use App\Models\Direccion;
use App\Http\Requests\StorePedidosRequest;

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

    public function pedidoConfirm(string $pedidoId)
    {
        return Inertia::render('Landing/Index');
    }

    public function store(StorePedidosRequest $request): RedirectResponse
    {
        $pedido = $this->pedidoService->store($request->validated());

        return redirect()
            ->route('pedido.confirm', ['pedidoId' => $pedido->id])
            ->with('mensaje', 'Pedido creado con exito');
    }
}