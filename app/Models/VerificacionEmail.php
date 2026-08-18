<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('verificacion_emails')]

class VerificacionEmail extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'cliente_id', 'token', 'expira_en', 'usado'
    ];

    protected $casts = [
        'usado' => 'boolean',
        'expira_en' => 'datetime'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
