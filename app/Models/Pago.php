<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('pagos')]
class Pago extends Model
{
    use HasUuids;

    protected $fillable = [
        'pedido_id', 'gateway', 'metodo', 'referencia_externa', 'estado', 'monto', 'raw_response'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'raw_response' => 'array'
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function scopePendiente($query){return $query->where('estado', 'pendiente');}
    public function scopeAprobado($query){return $query->where('estado', 'aprobado');}
    public function scopeRechazado($query){return $query->where('estado', 'rechazado');}
    public function scopeExpirado($query){return $query->where('estado', 'expirado');}
}
