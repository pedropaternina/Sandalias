<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


#[Table('admin_usuarios')]
class AdminUsuario extends Model
{
    use HasUuids;

    protected $fillable = [
        'nombre', 'correo', 'password', 'rol'
    ];



}
