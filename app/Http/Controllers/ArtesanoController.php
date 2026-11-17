<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtesanoController extends Controller
{
    public function indexProductos()
    {
        $productos = Producto::obtenerTodos();
        return view('artesano.productos-tabla', compact('productos'));
    }

    public function createProducto()
    {
        return view('artesano.producto-form');
    }

    public function storeProducto(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'categoria'   => 'required|string|max:80',
            'region'      => 'required|string|max:80',
            'descripcion' => 'nullable|string|max:500',
            'precio'      => 'required|numeric|min:1',
            'stock'       => 'required|integer|min:1',
        ]);

        $validated['user_id'] = Auth::id();
        Producto::registrarProducto($validated);

        return redirect()
            ->route('artesano.productos')
            ->with('success', 'Producto artesanal registrado correctamente en la base de datos.');
    }

    public function destroyProducto(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('artesano.productos')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function metricas()
    {
        $pedidos = Pedido::obtenerTodosConDetalle();
        $totalVentas = $pedidos->sum('total');
        $totalPedidos = $pedidos->count();
        $totalProductos = Producto::count();

        return view('artesano.metricas', compact('pedidos', 'totalVentas', 'totalPedidos', 'totalProductos'));
    }
}