<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoDireccion;
use Illuminate\Support\Facades\DB;

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
        'subtotal',
        'descuento',
        'total',
    ];

    public function __construct(
        private PedidoDireccionService $pedidoDireccionService
    ) {}

    public function store(array $datos): Pedido
    {
        return DB::transaction(function () use ($datos) {

            $direccion = $this->pedidoDireccionService->store(
                array_intersect_key($datos, array_flip(self::CAMPOS_DIRECCION))
            );

            return Pedido::create([
                'cliente_id'          => $datos['cliente_id'] ?? null,
                'pedido_direccion_id' => $direccion->id,
                ...array_intersect_key($datos, array_flip(self::CAMPOS_PEDIDO)),
            ]);
        });
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