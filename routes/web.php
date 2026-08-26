<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

Route::inertia('/', 'Welcome')->name('home');

//Route::get('productos',[ProductoController::class, 'getProductos']  , function () {
//    return view('producto');
//});

// Productos rutas
Route::get('productos',[ProductoController::class, 'index'])->name('productos.index');
Route::get('productos/crear', [ProductoController::class, 'create'])->name('productos.create');
Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('productos/{producto}', [ProductoController::class, 'update'])->name('productos.update'); 
Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

// Categorias rutas
Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('categorias/crear', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');