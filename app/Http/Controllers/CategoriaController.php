<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Services\CategoriaService;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class CategoriaController extends Controller
{
    public function __construct(private CategoriaService $categoriaService) {}

    public function index(): Response
    {
        return Inertia::render('Categorias/Index', [
            'categorias' => Categoria::all(),
             
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Categorias/Create', [
            'categorias' => Categoria::all() 
        ]);
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $categoria = $this->categoriaService->store($request->validated());

        return redirect()
        ->route('categorias.index')
        ->with('mensaje', "Categoria \"{$categoria->nombre_categoria}\" creada con exito");
    }
}
