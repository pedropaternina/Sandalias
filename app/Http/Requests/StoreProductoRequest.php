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
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descuento_porcentaje' => ['nullable', 'integer', 'min:0', 'max:100'],
            'activo' => ['boolean'],
 
            'colores' => ['required', 'array', 'min:1'],
            'colores.*.id' => ['nullable', 'string'],
            'colores.*.nombre' => ['required', 'string', 'max:60'],
            'colores.*.codigo_hex' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
 
            'colores.*.producto_variantes' => ['required', 'array', 'min:1'],
            'colores.*.producto_variantes.*.id' => ['nullable', 'string'],
            'colores.*.producto_variantes.*.talla' => ['required', 'integer', 'min:1'],
            'colores.*.producto_variantes.*.stock' => ['required', 'integer', 'min:0'],
 
            'colores.*.producto_imagenes' => ['required', 'array', 'min:1'],
            'colores.*.producto_imagenes.*.id' => ['nullable', 'string'],
            'colores.*.producto_imagenes.*.url' => ['required', 'url'],

        ];
    }

        public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            foreach ($this->input('colores', []) as $i => $color) {
                $tallas = collect($color['producto_variantes'] ?? [])->pluck('talla');
                if ($tallas->duplicates()->isNotEmpty()) {
                    $validator->errors()->add("colores.$i.producto_variantes", 'Hay tallas repetidas en este color.');
                }
            }
        });
    }


    public function messages(): array
    {
        return [
            'producto_variantes.required' => 'Debes agregar al menos una talla con stock',
            'categoria_id.exists' => 'La categoria seleccionada no existe',
        ];
    }
}
