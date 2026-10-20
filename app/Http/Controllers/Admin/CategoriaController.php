<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoriaController extends Controller
{
    public function __construct(private CategoriaService $categoriaService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Categorias/Index', [
            'categorias' => Categoria::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Categorias/Create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $categoria = $this->categoriaService->store($request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('mensaje', "Categoria \"{$categoria->nombre_categoria}\" creada con exito");
    }

    public function edit(Categoria $categoria): Response
    {
        return Inertia::render('Admin/Categorias/Edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria = $this->categoriaService->update($categoria, $request->validated());

        return redirect()
            ->route('admin.categorias.index')
            ->with('mensaje', "Categoria \"{$categoria->nombre_categoria}\" actualizada con exito");
    }
}