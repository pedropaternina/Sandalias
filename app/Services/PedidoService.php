<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoDireccion;
use App\Models\ProductoVariante;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    private const CAMPOS_DIRECCION = [
        'pais',
        'departamento',
        'ciudad',
        'barrio',
        'direccion',
        'conjunto_edificio',
        'numero_casa_o_apartamento',
        'indicaciones_adicionales',
        'codigo_postal',
    ];

    private const CAMPOS_PEDIDO = [
        'nombre_contacto',
        'correo_contacto',
        'telefono_contacto',
        'estado',
        'descuento',
    ];

    public function __construct(
        private PedidoDireccionService $pedidoDireccionService
    ) {}

    public function store(array $datos): Pedido
    {
        return DB::transaction(function () use ($datos) {

            // 1. Bloquear variantes y calcular items y subtotal
            [$filasItems, $subtotal] = $this->prepararItems($datos['items']);

            $descuento = $datos['descuento'] ?? 0;

            // 2. Crear dirección
            $direccion = $this->pedidoDireccionService->store(
                array_intersect_key($datos, array_flip(self::CAMPOS_DIRECCION))
            );

            // 3. Crear pedido con totales calculados en el servidor
            $pedido = Pedido::create([
                'cliente_id'          => $datos['cliente_id'] ?? null,
                'pedido_direccion_id' => $direccion->id,
                ...array_intersect_key($datos, array_flip(self::CAMPOS_PEDIDO)),
                'subtotal'            => $subtotal,
                'total'               => max($subtotal - $descuento, 0),
            ]);

            // 4. Guardar items
            $pedido->items()->createMany($filasItems);

            return $pedido;
        });
    }

    /**
     * Valida stock, lo descuenta y devuelve [filas de items, subtotal].
     */
    private function prepararItems(array $items): array
    {
        $variantes = ProductoVariante::with('producto')
            ->whereIn('id', collect($items)->pluck('variante_id'))
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        $filas = [];
        $subtotal = 0;

        foreach ($items as $item) {
            $variante = $variantes[$item['variante_id']];

            if ($variante->stock < $item['cantidad']) {
                throw ValidationException::withMessages([
                    'items' => "No hay stock suficiente para la talla {$variante->talla}.",
                ]);
            }

            $variante->decrement('stock', $item['cantidad']);

            $precio = $variante->producto->precio;
            $subtotal += $precio * $item['cantidad'];

            $filas[] = [
                'variante_id'     => $variante->id,
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $precio,
            ];
        }

        return [$filas, $subtotal];
    }

    public function update(Pedido $pedido, array $datos): Pedido
    {
        return DB::transaction(function () use ($pedido, $datos) {

            $datosDireccion = array_intersect_key($datos, array_flip(self::CAMPOS_DIRECCION));

            if (!empty($datosDireccion)) {
                $direccion = PedidoDireccion::findOrFail($pedido->pedido_direccion_id);
                $this->pedidoDireccionService->update($direccion, $datosDireccion);
            }

            $pedido->update(array_intersect_key($datos, array_flip(self::CAMPOS_PEDIDO)));

            return $pedido->refresh();
        });
    }

    public function destroy(Pedido $pedido): void
    {
        DB::transaction(function () use ($pedido) {

            $direccion = PedidoDireccion::findOrFail($pedido->pedido_direccion_id);

            $pedido->delete();

            $this->pedidoDireccionService->destroy($direccion);
        });
    }
}