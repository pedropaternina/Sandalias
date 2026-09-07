<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Table('pedido_direcciones')]
class PedidoDireccion extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'pais', 'departamento', 'ciudad', 'barrio', 
        'direccion', 'conjunto_o_edificio', 'numero_casa_o_departamento', 'indicaciones_adicionales',
        'codigo_postal',
    ];



}
