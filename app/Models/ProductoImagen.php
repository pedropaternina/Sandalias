<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Table('producto_imagenes')]

class ProductoImagen extends Model
{
    use HasUuids;

    protected $fillable = [
        'producto_id', 'url', 'orden'
    ];

    public function producto() : BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
