<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('categorias')]
class Categoria extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'nombre_categoria'
    ];

    
    public function producto(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}
