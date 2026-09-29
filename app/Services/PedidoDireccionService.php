<?php

namespace App\Services;

use App\Models\PedidoDireccion;
use Illuminate\Support\Facades\DB;

class PedidoDireccionService
{
    public function store(array $datos): PedidoDireccion
    {
        return DB::transaction(function () use ($datos) {
            return PedidoDireccion::create($this->mapear($datos));
        });
    }

    public function update(PedidoDireccion $pedidoDireccion, array $datos): PedidoDireccion
    {
        return DB::transaction(function () use ($pedidoDireccion, $datos) {
            $pedidoDireccion->update($this->mapear($datos));

            return $pedidoDireccion;
        });
    }

    public function destroy(PedidoDireccion $pedidoDireccion): string
    {
        return DB::transaction(function () use ($pedidoDireccion) {
            $pedidoDireccion->delete();

            return 'Pedido direccion eliminado con exito';
        });
    }

    private function mapear(array $datos): array
    {
        return [
            'pais'                       => $datos['pais'],
            'departamento'               => $datos['departamento'],
            'ciudad'                     => $datos['ciudad'],
            'direccion'                  => $datos['direccion'],
            'barrio'                     => $datos['barrio'],
            'conjunto_o_edificio'        => $datos['conjunto_edificio'] ?? null,
            'numero_casa_o_departamento' => $datos['numero_casa_o_apartamento'] ?? null,
            'indicaciones_adicionales'   => $datos['indicaciones_adicionales'] ?? null,
            'codigo_postal'              => $datos['codigo_postal'],
        ];
    }
}