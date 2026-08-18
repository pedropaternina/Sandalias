<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Table('pedido_items')]
class PedidoItem extends Model
{
    use HasUuids;

    protected $fillable = [
        'pedido_id', 'variante_id', 'cantidad' ,'precio_unitario'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2'
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function productoVariante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class);
    }
}
