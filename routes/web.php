<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtesanoController;
use App\Http\Controllers\CompradorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user && strtolower((string) $user->role) === 'artesano') {
        return redirect()->route('artesano.productos.index');
    }

    if ($user && strtolower((string) $user->role) === 'comprador') {
        return redirect()->route('comprador.catalogo');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:comprador'])->prefix('comprador')->name('comprador.')->group(function () {
    Route::get('/catalogo', [CompradorController::class, 'catalogo'])->name('catalogo');
    Route::get('/checkout', [CompradorController::class, 'checkoutForm'])->name('checkout');
    Route::post('/checkout', [CompradorController::class, 'procesarCheckout'])->name('checkout.store');
});

Route::middleware(['auth', 'role:artesano'])->prefix('artesano')->name('artesano.')->group(function () {
    Route::get('/productos', [ArtesanoController::class, 'indexProductos'])->name('productos.index');
    Route::get('/productos/crear', [ArtesanoController::class, 'createProducto'])->name('productos.create');
    Route::post('/productos', [ArtesanoController::class, 'storeProducto'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ArtesanoController::class, 'editProducto'])->name('productos.edit');
    Route::put('/productos/{producto}', [ArtesanoController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/productos/{producto}', [ArtesanoController::class, 'destroyProducto'])->name('productos.destroy');
    Route::get('/metricas', [ArtesanoController::class, 'metricas'])->name('metricas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:comprador'])->prefix('comprador')->name('comprador.')->group(function () {
    Route::get('/catalogo', [CompradorController::class, 'catalogo'])->name('catalogo');
    Route::post('/carrito/agregar', [CompradorController::class, 'agregarCarrito'])->name('carrito.agregar');
    Route::get('/checkout', [CompradorController::class, 'checkoutForm'])->name('checkout');
    Route::post('/checkout', [CompradorController::class, 'procesarCheckout'])->name('checkout.store');
});

Route::middleware(['auth', 'role:comprador'])->prefix('comprador')->name('comprador.')->group(function () {
    Route::get('/catalogo', [CompradorController::class, 'catalogo'])->name('catalogo');
    Route::post('/carrito/agregar', [CompradorController::class, 'agregarCarrito'])->name('carrito.agregar');
    Route::patch('/carrito/{productoId}/cantidad', [CompradorController::class, 'actualizarCantidadCarrito'])->name('carrito.cantidad');
    Route::delete('/carrito/{productoId}', [CompradorController::class, 'eliminarCarrito'])->name('carrito.eliminar');
    Route::get('/checkout', [CompradorController::class, 'checkoutForm'])->name('checkout');
    Route::post('/checkout', [CompradorController::class, 'procesarCheckout'])->name('checkout.store');
});
require __DIR__.'/auth.php';