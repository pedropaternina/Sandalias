<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Table('admin_usuarios')]
class AdminUsuario extends Authenticatable
{
    use HasUuids;

    protected $fillable = [
        'nombre', 'correo', 'password', 'rol'
    ];



}
