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

        $catalogo = $productos->map(function ($producto) {
            return [
                'id'        => $producto->id,
                'codigo'    => 'ART-' . str_pad((string) $producto->id, 4, '0', STR_PAD_LEFT),
                'nombre'    => $producto->nombre,
                'tienda'    => optional($producto->artesano)->name ?? 'Taller Huánuco',
                'categoria' => $producto->categoria,
                'region'    => $producto->region ?? 'Huánuco',
                'precio'    => number_format((float) $producto->precio, 2),
                'stock'     => $producto->stock,
            ];
        });

        $carritoSesion = session('carrito', []);
        if (!empty($carritoSesion)) {
            $carrito = collect($carritoSesion)->map(function ($item) {
                $unitario = (float) ($item['precio'] ?? 0);
                $cantidad = (int) ($item['cantidad'] ?? 1);
                return [
                    'producto' => $item['nombre'] ?? 'Producto Artesanal',
                    'cantidad' => $cantidad,
                    'unitario' => number_format($unitario, 2),
                    'subtotal' => number_format($unitario * $cantidad, 2),
                ];
            });
        } else {
            $carrito = Pedido::obtenerPorComprador(Auth::id())->map(function ($pedido) {
                $cantidad = (int) ($pedido->cantidad ?? 1);
                $total = (float) ($pedido->total ?? 0);
                $unitario = $cantidad > 0 ? ($total / $cantidad) : $total;
                return [
                    'producto' => optional($pedido->producto)->nombre ?? 'Pedido #' . $pedido->id,
                    'cantidad' => $cantidad,
                    'unitario' => number_format($unitario, 2),
                    'subtotal' => number_format($total, 2),
                ];
            });
        }

        return view('comprador.catalogo-tabla', compact('catalogo', 'productos', 'categoria', 'carrito'));
    }

    public function agregarCarrito(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
            'redirect_to' => 'nullable|string|in:catalogo,checkout',
        ]);

        $producto = Producto::findOrFail($validated['producto_id']);

        if ($validated['cantidad'] > $producto->stock) {
            return back()
                ->withInput()
                ->withErrors(['cantidad' => "Solo hay {$producto->stock} unidades disponibles de {$producto->nombre}."]);
        }

        $carrito = session('carrito', []);
        $idKey = (string) $producto->id;

        if (isset($carrito[$idKey])) {
            $nuevaCantidad = min((int) $producto->stock, (int) $carrito[$idKey]['cantidad'] + (int) $validated['cantidad']);
            $carrito[$idKey]['cantidad'] = $nuevaCantidad;
            $carrito[$idKey]['precio'] = (float) $producto->precio;
        } else {
            $carrito[$idKey] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => (float) $producto->precio,
                'cantidad' => (int) $validated['cantidad'],
            ];
        }

        session(['carrito' => $carrito]);

        $rutaDestino = ($validated['redirect_to'] ?? null) === 'checkout'
            ? 'comprador.checkout'
            : 'comprador.catalogo';

        return redirect()
            ->route($rutaDestino)
            ->with('success', "Se agregó {$validated['cantidad']} ud(s). de {$producto->nombre} al carrito.");
    }

    public function actualizarCantidadCarrito(Request $request, string $productoId)
    {
        $request->validate([
            'accion' => 'required|in:aumentar,restar',
        ]);

        $carrito = session('carrito', []);

        if (!isset($carrito[$productoId])) {
            return back();
        }

        $producto = Producto::find($carrito[$productoId]['id'] ?? $productoId);
        $stockMax = $producto ? (int) $producto->stock : 999;
        $cantidadActual = (int) ($carrito[$productoId]['cantidad'] ?? 1);

        if ($request->input('accion') === 'aumentar') {
            if ($cantidadActual + 1 > $stockMax) {
                return back()->withErrors(['cantidad' => "Stock máximo alcanzado ({$stockMax} uds.)."]);
            }
            $carrito[$productoId]['cantidad'] = $cantidadActual + 1;
        } else {
            if ($cantidadActual - 1 <= 0) {
                unset($carrito[$productoId]);
            } else {
                $carrito[$productoId]['cantidad'] = $cantidadActual - 1;
            }
        }

        session(['carrito' => $carrito]);

        return back()->with('success', 'Cantidad del carrito actualizada.');
    }

    public function eliminarCarrito(string $productoId)
    {
        $carrito = session('carrito', []);

        if (isset($carrito[$productoId])) {
            unset($carrito[$productoId]);
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function limpiarCarrito()
    {
        session()->forget('carrito');

        return redirect()
            ->route('comprador.catalogo')
            ->with('success', 'Carrito vaciado.');
    }

    public function checkoutForm()
    {
        $productos = Producto::obtenerDisponibles();
        $misPedidos = Pedido::obtenerPorComprador(Auth::id());

        $carritoSesion = session('carrito', []);
        $carritoItems = collect($carritoSesion)->map(function ($item) {
            $cantidad = (int) ($item['cantidad'] ?? 1);
            $precio   = (float) ($item['precio'] ?? 0);

            return [
                'id'       => $item['id'],
                'nombre'   => $item['nombre'],
                'cantidad' => $cantidad,
                'precio'   => $precio,
                'subtotal' => $cantidad * $precio,
            ];
        })->values();

        $totalCarrito = $carritoItems->sum('subtotal');

        return view('comprador.checkout-form', compact(
            'productos',
            'misPedidos',
            'carritoItems',
            'totalCarrito'
        ));
    }

    public function procesarCheckout(Request $request)
    {
        $validated = $request->validate([
            'producto_id'     => 'required|exists:productos,id',
            'cantidad'        => 'required|integer|min:1',
            'direccion_envio' => 'required|string|min:5|max:255',
            'metodo_pago'     => 'required|string|in:Yape / Plin,Tarjeta,Transferencia',
            'calificacion'    => 'nullable|integer|min:1|max:5',
            'resena'          => 'nullable|string|max:500',
        ]);

        $producto = Producto::findOrFail($validated['producto_id']);

        if ($producto->stock < $validated['cantidad']) {
            return back()
                ->withInput()
                ->withErrors(['cantidad' => "Stock insuficiente. Solo quedan {$producto->stock} unidades disponibles."]);
        }

        $validated['user_id'] = Auth::id();
        $pedido = Pedido::registrarPedido($validated, $producto);
        session()->forget('carrito');

        return redirect()
            ->route('comprador.checkout')
            ->with('success', "Compra registrada con exito ({$validated['metodo_pago']})! Pedido #{$pedido->id} por S/ " . number_format($pedido->total, 2));
    }
}