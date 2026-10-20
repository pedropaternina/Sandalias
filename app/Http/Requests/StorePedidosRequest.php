<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePedidosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "pais" => ["required", "string", "max:30"],
            "departamento" => ["required", "string", "max:30"],
            "ciudad" => ["required", "string", "max:30"],
            "barrio" => ["required", "string", "max:30"],
            "direccion" => ["required", "string", "max:50"],
            "conjunto_edificio" => ["nullable", "string", "max:30"],
            "numero_casa_o_apartamento" => ["nullable", "string", "max:30"],
            "indicaciones_adicionales" => ["nullable", "string", "max:255"],
            "codigo_postal" => ["required", "string", "max:30"],

            "nombre_contacto" => ["required", "string", "max:50"],
            "correo_contacto" => ["required", "email", "max:100"],
            "telefono_contacto" => ["required", "string", "max:30"],
            "estado" => ["required", "string", "max:20"],
            "descuento" => ["required", "numeric", "min:0"],
    
            "items"                   => ["required", "array", "min:1"],
            "items.*.variante_id"     => ["required", "uuid", "exists:producto_variantes,id"],
            "items.*.cantidad"        => ["required", "integer", "min:1"],
        ];
    }
}