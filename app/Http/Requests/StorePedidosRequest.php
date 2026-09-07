<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePedidosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "cliente_id" => ["uuid", "required", "exists:clientes,id"],
            "pedido_direccion_id" => ["uuid", "required", "exists:direcciones,id"],
            "nombre_contacto" => ["string", "required", "max:50"],
            "correo_contacto" => ["string", "required", "max:100"],
            "telefono_contecto" => ["string", "required",  "max:30"],
            "estado" => ["string", "required", "max:20"],
            "subtotal" => ["decimal:2,10", "required"],
            "descuento" => ["decimal:2,10", "required"],
            "total" => ["decimal:2,10", "required"],
        ];
    }
}
