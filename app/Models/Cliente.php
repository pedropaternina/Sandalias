<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('clientes')]
class Cliente extends Model
{
    use HasUuids;

    protected $fillable = [
        'nombres', 'apellidos', 'correo', 'telefono', 'email_verificado'
    ];

    protected $hidden = [
        'password_hash'
    ];

    protected $casts = [
        'password_hash' => 'hashed',
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
