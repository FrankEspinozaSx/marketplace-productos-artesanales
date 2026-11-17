<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtesanoController;
use App\Http\Controllers\CompradorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:comprador'])->prefix('comprador')->name('comprador.')->group(function () {
    Route::get('/catalogo', [CompradorController::class, 'catalogo'])->name('catalogo');
    Route::get('/checkout', [CompradorController::class, 'checkoutForm'])->name('checkout');
    Route::post('/checkout', [CompradorController::class, 'procesarCheckout'])->name('checkout.store');
});

Route::middleware(['auth', 'role:artesano'])->prefix('artesano')->name('artesano.')->group(function () {
    Route::get('/productos', [ArtesanoController::class, 'indexProductos'])->name('productos');
    Route::get('/productos/crear', [ArtesanoController::class, 'createProducto'])->name('productos.create');
    Route::post('/productos', [ArtesanoController::class, 'storeProducto'])->name('productos.store');
    Route::delete('/productos/{producto}', [ArtesanoController::class, 'destroyProducto'])->name('productos.destroy');
    Route::get('/metricas', [ArtesanoController::class, 'metricas'])->name('metricas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';