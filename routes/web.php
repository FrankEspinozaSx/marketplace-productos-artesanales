<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtesanoController;
use App\Http\Controllers\CompradorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    if (auth()->user()->rol === 'artesano') {
        return redirect()->route('artesano.metricas');
    }
    return redirect()->route('comprador.catalogo');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'rol:artesano'])->prefix('artesano')->name('artesano.')->group(function () {
    Route::get('/metricas', [ArtesanoController::class, 'metricas'])->name('metricas');
    Route::get('/productos', [ArtesanoController::class, 'indexProductos'])->name('productos.index');
    Route::get('/productos/crear', [ArtesanoController::class, 'createProducto'])->name('productos.create');
    Route::post('/productos/guardar', [ArtesanoController::class, 'storeProducto'])->name('productos.store');
});

Route::middleware(['auth', 'rol:comprador'])->prefix('comprador')->name('comprador.')->group(function () {
    Route::get('/catalogo', [CompradorController::class, 'catalogo'])->name('catalogo');
    Route::get('/checkout-valoracion', [CompradorController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout-valoracion', [CompradorController::class, 'procesarCheckout'])->name('checkout.store');
});

require __DIR__.'/auth.php';
