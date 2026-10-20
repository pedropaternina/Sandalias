<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function getCategorias()
    {
        return Categoria::all();
    }
}