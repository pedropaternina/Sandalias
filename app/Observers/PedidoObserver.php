<?php

namespace App\Observers;

use App\Mail\PedidoCreadoMail;
use App\Mail\PedidoEstadoMail;
use App\Models\Pedido;
use Closure;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Mail;

/**
 * Envía los correos del pedido. Se ejecuta DESPUÉS de que termina la transacción,
 * así el pedido ya tiene sus items y sus totales cuando se arma el correo.
 */
class PedidoObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Pedido $pedido): void
    {
        $this->enviar($pedido, fn () => new PedidoCreadoMail($pedido));
    }

    public function updated(Pedido $pedido): void
    {
        if ($pedido->wasChanged('estado')) {
            $this->enviar($pedido, fn () => new PedidoEstadoMail($pedido));
        }
    }

    private function enviar(Pedido $pedido, Closure $crearCorreo): void
    {
        if (! $pedido->correo_contacto) {
            return;
        }

        // Todo (incluso armar el correo) va dentro del try: si algo falla, el pedido
        // no se ve afectado y el error queda registrado en storage/logs/laravel.log
        try {
            Mail::to($pedido->correo_contacto)->send($crearCorreo());
        } catch (\Throwable $e) {
            report($e);
        }
    }
}