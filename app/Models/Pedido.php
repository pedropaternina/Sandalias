<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('pedidos')]
class Pedido extends Model
{
    use HasUuids;

    protected $fillable = [
        'cliente_id', 'direccion_id', 'estado', 'subtotal', 'descuento', 'total' 
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function pedidoItems(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }


    public function scopePendiente($query){return $query->where('estado', 'pendiente');}

    public function scopePagado($query){return $query->where('estado', 'pagado');}
    
    public function scopePreparando($query){return $query->where('estado', 'preparando');}

    public function scopeEnviado($query){return $query->where('estado', 'enviado');}

    public function scopeEntregado($query){return $query->where('estado', 'entregado');}

    public function scopeCancelado($query){return $query->where('estado', 'cancelado');}

    public function scopePagoFallido($query){return $query->where('estado', 'pago_fallido');}
}
