@extends('emails.layout')

@section('titulo', 'Recibimos tu pedido')

@section('contenido')
    <h1 style="font-size:22px;margin:0 0 12px;">¡Gracias por tu compra, {{ $pedido->nombre_contacto }}!</h1>
    <p style="font-size:15px;line-height:1.6;margin:0 0 8px;">
        Recibimos tu pedido <strong>#{{ $numero }}</strong>. Te avisaremos por este mismo correo cada vez que cambie de estado.
    </p>
    <p style="font-size:14px;margin:0;">
        Estado actual: <strong>{{ ucfirst($pedido->estado) }}</strong>
    </p>

    @include('emails.detalle-pedido')
@endsection