<?php

namespace App\Http\Requests;

class UpdateProductoRequest extends StoreProductoRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'activo' => ['required', 'boolean'],
        ]);
    }
}