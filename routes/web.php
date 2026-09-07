<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PedidoController;

Route::inertia('/', 'Welcome')->name('home');

//Route::get('productos',[ProductoController::class, 'getProductos']  , function () {
//    return view('producto');
//});

Route::get('/', [LandingController::class, 'index'])->name('home');


// Productos rutas
Route::get('productos',[ProductoController::class, 'index'])->name('productos.index');
Route::get('productos/crear', [ProductoController::class, 'create'])->name('productos.create');
Route::post('productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('productos/{producto}', [ProductoController::class, 'update'])->name('productos.update'); 
Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::get('api/productos', [ProductoController::class, 'getProductos']);
Route::get('api/productos/{productoId}', [ProductoController::class, 'getProductoId']);
Route::get('producto/detalles/{productoId}', [ProductoController::class, 'showDetalles'])->name('show.detalles');

// Categorias rutas
Route::get('categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('categorias/crear', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('api/categorias', [CategoriaController::class, 'getCategorias']);

// Auth

Route::get('registro', [AuthController:: class, 'showRegistro'])->name('show.registro');
Route::get('login', [AuthController:: class, 'showLogin'])->name('show.login');


Route::post('registro', [AuthController:: class, 'registro'])->name('registro');
Route::post('login', [AuthController:: class, 'login'])->name('login');


// Pedidos

Route::get('pedido', [PedidoController::class, 'showPedido'])->name('show.pedido');
Route::post('pedido', [PedidoController::class, 'store'])->name('store');
Route::get('pedido/confirm/{pedidoId}', [PedidoController::class, 'pedidoConfirm'])->name('pedido.confirm');