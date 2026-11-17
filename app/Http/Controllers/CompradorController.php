<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompradorController extends Controller
{
    public function catalogo(Request $request)
    {
        $categoria = $request->query('categoria');
        $productos = Producto::obtenerDisponibles($categoria);

        return view('comprador.catalogo-tabla', compact('productos', 'categoria'));
    }

    public function checkoutForm()
    {
        $productos = Producto::obtenerDisponibles();
        $misPedidos = Pedido::obtenerPorComprador(Auth::id());

        return view('comprador.checkout-form', compact('productos', 'misPedidos'));
    }

    public function procesarCheckout(Request $request)
    {
        $validated = $request->validate([
            'producto_id'     => 'required|exists:productos,id',
            'cantidad'        => 'required|integer|min:1',
            'direccion_envio' => 'required|string|min:5|max:255',
            'metodo_pago'     => 'required|string|in:Tarjeta,Yape / Plin,Transferencia',
        ]);

        $producto = Producto::findOrFail($validated['producto_id']);

        if ($producto->stock < $validated['cantidad']) {
            return back()
                ->withInput()
                ->withErrors(['cantidad' => "Stock insuficiente. Solo quedan {$producto->stock} unidades disponibles."]);
        }

        $validated['user_id'] = Auth::id();
        $pedido = Pedido::registrarPedido($validated, $producto);

        return redirect()
            ->route('comprador.checkout')
            ->with('success', "Compra registrada con exito! Pedido #{$pedido->id} por S/ " . number_format($pedido->total, 2));
    }
}