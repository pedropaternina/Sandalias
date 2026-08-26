<?php

namespace App\Services;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class CategoriaService
{
    public function store(array $datos): Categoria
    {
       
        return DB::transaction(function () use ($datos) {
            $categoria = Categoria::create([
                'nombre_categoria' => $datos['nombre_categoria']
            ]);

            return $categoria;
        });

    
    }
}
