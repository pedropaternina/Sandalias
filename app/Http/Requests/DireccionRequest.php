<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DireccionRequest extends FormRequest
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
            "pais" => ["required", "string", "max:30"],
            "departamento" => ["required", "string", "max:30"],
            "ciudad" => ["required", "string", "max:30"],
            "barrio" => ["required", "string", "max:30"],
            "direccion" => ["required", "string", "max:50"],
            "conjunto_edificio" => ["nullable", "string", "max:30"],
            "numero_casa_o_apartamente" => ["nullable", "string", "max:30"],
            "indicaciones_adicionales" => ["nullable", "string", "max:255"],
            "codigo_postal" => ["required", "string", "max:30"],
            "telefono_contacto" => ["required", "string", "max:20"],
            "predeterminada" => ["boolean"],
        ];
    }
}
