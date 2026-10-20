<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $inicio = now()->startOfMonth();

        $pedidosMes = fn () => Pedido::where('created_at', '>=', $inicio)
            ->where('estado', '!=', 'cancelado');

        return Inertia::render('Admin/Dashboard', [
            'ventasMes' => (float) $pedidosMes()->sum('total'),
            'pedidosMes' => $pedidosMes()->count(),
            // SUPUESTO: tabla "pedido_detalles" con columnas pedido_id y cantidad
            'productosVendidos' => (int) DB::table('pedido_items')
                ->join('pedidos', 'pedidos.id', '=', 'pedido_items.pedido_id')
                ->where('pedidos.created_at', '>=', $inicio)
                ->where('pedidos.estado', '!=', 'cancelado')
                ->sum('pedido_items.cantidad'),
            'porEstado' => Pedido::select('estado', DB::raw('count(*) as total'))
                ->groupBy('estado')
                ->pluck('total', 'estado'),
        ]);
    }
}