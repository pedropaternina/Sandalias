@php
    $cop = fn ($valor) => '$ ' . number_format((float) $valor, 0, ',', '.');
    $d = $pedido->direccion;
@endphp

<h2 style="font-size:16px;margin:28px 0 12px;">Tu pedido</h2>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
    @foreach ($pedido->items as $item)
        <tr>
            <td style="padding:10px 0;border-bottom:1px solid #eee3e3;">
                <strong>{{ $item->variante?->producto?->nombre }}</strong><br>
                <span style="color:#6b7280;font-size:13px;">
                    @if ($item->variante?->color?->nombre)
                        Color {{ $item->variante->color->nombre }} ·
                    @endif
                    Talla {{ $item->variante?->talla }} · Cantidad {{ $item->cantidad }}
                </span>
            </td>
            <td align="right" style="padding:10px 0;border-bottom:1px solid #eee3e3;white-space:nowrap;">
                {{ $cop($item->precio_unitario * $item->cantidad) }}
            </td>
        </tr>
    @endforeach
</table>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin-top:12px;">
    <tr>
        <td style="padding:4px 0;color:#6b7280;">Subtotal</td>
        <td align="right" style="padding:4px 0;">{{ $cop($pedido->subtotal) }}</td>
    </tr>
    @if ($pedido->descuento > 0)
        <tr>
            <td style="padding:4px 0;color:#6b7280;">Descuento</td>
            <td align="right" style="padding:4px 0;">- {{ $cop($pedido->descuento) }}</td>
        </tr>
    @endif
    <tr>
        <td style="padding:8px 0;font-size:16px;font-weight:bold;">Total</td>
        <td align="right" style="padding:8px 0;font-size:16px;font-weight:bold;">{{ $cop($pedido->total) }}</td>
    </tr>
</table>

@if ($d)
    <h2 style="font-size:16px;margin:28px 0 8px;">Dirección de entrega</h2>
    <p style="font-size:14px;line-height:1.6;margin:0;">
        {{ $pedido->nombre_contacto }} · {{ $pedido->telefono_contacto }}<br>
        {{ $d->direccion }}
        @if ($d->conjunto_o_edificio), {{ $d->conjunto_o_edificio }}@endif
        @if ($d->numero_casa_o_departamento), {{ $d->numero_casa_o_departamento }}@endif
        <br>
        {{ $d->barrio }}, {{ $d->ciudad }}, {{ $d->departamento }}, {{ $d->pais }}
        @if ($d->indicaciones_adicionales)
            <br><span style="color:#6b7280;">{{ $d->indicaciones_adicionales }}</span>
        @endif
    </p>
@endif