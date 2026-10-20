<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductoColor extends Model
{
    use HasUuids;

    protected $table = 'producto_colores';

    protected $fillable = ['producto_id', 'nombre', 'codigo_hex', 'orden'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function productoVariante()
    {
        return $this->hasMany(ProductoVariante::class);
    }

    public function productoImagen()
    {
        return $this->hasMany(ProductoImagen::class);
    }
}