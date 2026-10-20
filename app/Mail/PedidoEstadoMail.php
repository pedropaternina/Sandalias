<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Str;

class PedidoEstadoMail extends PedidoMail
{
    // [título del correo, mensaje]. Ajusta las claves a los estados que uses en tu proyecto.
    private const TEXTOS = [
        'pendiente' => ['Recibimos tu pedido', 'Estamos revisando tu pedido. Te avisaremos cuando avance.'],
        'pagado' => ['Confirmamos tu pago', '¡Gracias! Ya confirmamos tu pago y estamos preparando tus sandalias.'],
        'enviado' => ['Tu pedido va en camino', 'Despachamos tu pedido. Pronto llegará a la dirección que nos diste.'],
        'entregado' => ['Tu pedido fue entregado', 'Tu pedido ya llegó. ¡Esperamos que disfrutes tus sandalias!'],
        'cancelado' => ['Tu pedido fue cancelado', 'Cancelamos tu pedido. Si no lo solicitaste o tienes dudas, escríbenos.'],
    ];

    private function textos(): array
    {
        $estado = Str::lower($this->pedido->estado);

        return self::TEXTOS[$estado] ?? [
            'Actualización de tu pedido',
            "El estado de tu pedido ahora es: {$this->pedido->estado}.",
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->textos()[0] . " · Pedido #{$this->numero}");
    }

    public function content(): Content
    {
        [$titulo, $mensaje] = $this->textos();

        return new Content(
            view: 'emails.pedido-estado',
            with: ['titulo' => $titulo, 'mensaje' => $mensaje],
        );
    }
}