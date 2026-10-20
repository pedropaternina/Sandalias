@extends('emails.layout')

@section('titulo', $titulo)

@section('contenido')
    <h1 style="font-size:22px;margin:0 0 12px;">{{ $titulo }}</h1>
    <p style="font-size:15px;line-height:1.6;margin:0 0 8px;">
        Hola {{ $pedido->nombre_contacto }}, {{ $mensaje }}
    </p>
    <p style="font-size:14px;margin:0;">
        Pedido <strong>#{{ $numero }}</strong> · Estado: <strong>{{ ucfirst($pedido->estado) }}</strong>
    </p>

    @include('emails.detalle-pedido')
@endsection