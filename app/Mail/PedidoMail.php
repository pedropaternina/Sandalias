<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Mail\Mailable;

abstract class PedidoMail extends Mailable
{
    public Pedido $pedido;
    public string $numero;

    public function __construct(Pedido $pedido)
    {
        // Se vuelve a leer de la base de datos para tener los datos finales (items, totales, dirección)
        $this->pedido = Pedido::with(['items.variante.producto', 'items.variante.color', 'direccion'])
            ->findOrFail($pedido->id);

        // Número corto para que el cliente lo mencione fácilmente (los ids son UUID largos)
        $this->numero = strtoupper(substr($pedido->id, 0, 8));
    }
}