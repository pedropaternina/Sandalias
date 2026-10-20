<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PedidoCreadoMail extends PedidoMail
{
    public function envelope(): Envelope
    {
        return new Envelope(subject: "Recibimos tu pedido #{$this->numero} · Torres Sandals");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pedido-creado');
    }
}