<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


#[Table('productos')]

class Producto extends Model
{
   use HasUuids;

   protected $fillable = [
         'nombre', 'descripcion', 'categoria_id', 'precio', 'descuento_porcentaje', 'activo'
   ];

   protected $casts = [
         'precio' => 'decimal:2',
         'activo' => 'boolean',
         'descuento_porcentaje' => 'integer',
   ];


   public function categoria(): BelongsTo
   {   
      return $this->belongsTo(Categoria::class); 
   }

   public function productoImagen(): HasMany
   {
      return $this->hasMany(ProductoImagen::class);
   }

   public function productoVariante(): HasMany
   {
      return $this->hasMany(ProductoVariante::class);
   }

   public function scopedActions()
   {
      return $query->where('activo', true);
   }

}
