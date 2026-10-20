<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PedidoController extends Controller
{
    private const ESTADOS = ['pendiente', 'confirmado', 'enviado', 'entregado', 'cancelado'];

    public function index(Request $request): Response
    {
        $pedidos = Pedido::query()
            ->when($request->estado, fn ($q, $e) => $q->where('estado', $e))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Admin/Pedidos/Index', [
            'pedidos' => $pedidos,
            'estados' => self::ESTADOS,
            'filtro' => $request->estado,
        ]);
    }

    public function cambiarEstado(Request $request, Pedido $pedido): RedirectResponse
    {
        $data = $request->validate([
            'estado' => ['required', Rule::in(self::ESTADOS)],
        ]);

        $pedido->update($data); // "estado" debe estar en $fillable de Pedido

        return back()->with('mensaje', 'Estado actualizado');
    }
}