<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'uuid', 'exists:categorias,id'],
            'descuento_porcentaje' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'producto_variantes' => ['required', 'array', 'min:1'],
            'producto_variantes.*.talla' => ['required', 'integer', 'min:20', 'max:50'],
            'producto_variantes.*.stock' => ['required', 'integer', 'min:0'],
            'producto_imagenes' => ['required', 'array', 'min:1'],
            'producto_imagenes.*.url' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'producto_variantes.required' => 'Debes agregar al menos una talla con stock',
            'categoria_id.exists' => 'La categoria seleccionada no existe',
        ];
    }
}
