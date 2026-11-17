<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return ProductoResource::collection(Producto::obtenerTodos());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:150',
            'categoria' => 'required|string|max:80',
            'precio'    => 'required|numeric|min:0',
            'stock'     => 'required|integer|min:0',
        ]);

        $producto = Producto::registrarProducto($validated);
        return response()->json(new ProductoResource($producto), 201);
    }

    public function show(Producto $producto)
    {
        return new ProductoResource($producto);
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre'    => 'sometimes|required|string|max:150',
            'categoria' => 'sometimes|required|string|max:80',
            'precio'    => 'sometimes|required|numeric|min:0',
            'stock'     => 'sometimes|required|integer|min:0',
        ]);

        $producto->update($validated);
        return new ProductoResource($producto);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->noContent();
    }
}