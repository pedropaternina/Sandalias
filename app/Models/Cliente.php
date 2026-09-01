<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;



#[Table('clientes')]
class Cliente extends Authenticatable
{
    use HasUuids;

    protected $fillable = [
        'nombres', 'apellidos', 'correo', 'telefono', 'password', 'email_verificado'
    ];

    protected $hidden = [
        'password', 'email_verificado',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verificado' => 'boolean',
    ];

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function verificacionesEmail(): HasMany
    {
        return $this->hasMany(VerificacionEmail::class);
    }
}
