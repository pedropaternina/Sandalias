<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoDireccionController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
//Route::get('productos',[ProductoController::class, 'getProductos']  , function () {
//    return view('producto');
//});

Route::get('/', [LandingController::class, 'index'])->name('home');


// Productos rutas

Route::get('api/productos', [ProductoController::class, 'getProductos']);
Route::get('api/productos/{productoId}', [ProductoController::class, 'getProductoId']);
Route::get('producto/detalles/{productoId}', [ProductoController::class, 'showDetalles'])->name('show.detalles');

// Categorias rutas
Route::get('api/categorias', [CategoriaController::class, 'getCategorias']);

// Auth

Route::get('registro', [AuthController:: class, 'showRegistro'])->name('show.registro');
Route::get('login', [AuthController:: class, 'showLogin'])->name('show.login');


Route::post('registro', [AuthController:: class, 'registro'])->name('registro');
Route::post('login', [AuthController:: class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Auth Admin
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:5,1');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('productos', AdminProductoController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('categorias', AdminCategoriaController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);
        Route::get('pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
        Route::patch('pedidos/{pedido}/estado', [AdminPedidoController::class, 'cambiarEstado'])->name('pedidos.estado');
    });
});
// Pedidos

Route::get('pedido', [PedidoController::class, 'showPedido'])->name('show.pedido');
Route::post('pedido', [PedidoController::class, 'store'])->name('pedido.store');
Route::get('pedido/confirm/{pedidoId}', [PedidoController::class, 'pedidoConfirm'])->name('pedido.confirm');

// Pedido Dirección

Route::get('api/pedidoDireccion', [PedidoDireccionController::class, 'getPedidosDireccion']);
Route::get('api/pedidoDireccion/{pDireccion}', [PedidoDireccionController::class, 'getPedidoDireccionId']);
Route::put('api/pedidoDireccion', [PedidoDireccionController::class, 'store'])->name('pedidoDireccion.store');
Route::post('api/pedidoDireccion/{pDireccion}', [PedidoDireccionController::class, 'update'])->name('pedidoDireccion.update');
Route::delete('api/pedidoDireccion/{pDireccion}', [PedidoDireccionController::class, 'destroy'])->name('pedidoDireccion.destroy');