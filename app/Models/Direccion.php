<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('direcciones')]
class Direccion extends Model
{
    use HasUuids;

    protected $fillable = [
        'cliente_id', 'pais', 'departamento', 'ciudad', 'barrio', 
        'direccion', 'conjunto_edificio', 'numero_casa_o_apartamento', 'indicaciones_adicionales',
        'codigo_postal', 'telefono_contacto', 'predeterminada'
    ];

    protected $casts = [
        'predeterminada' => 'boolean'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);   
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
