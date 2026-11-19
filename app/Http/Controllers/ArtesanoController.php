<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtesanoController extends Controller
{
    private function listaCategorias(): array
    {
        return [
            'Ceramica',
            'Manualidad',
            'Textileria',
            'Joyería y Plata',
            'Tallado en Madera',
            'Gastronomía Artesanal',
        ];
    }

    private function listaRegiones(): array
    {
        return [
            'Huánuco',
            'Amarilis',
            'Pillco Marca',
            'Tingo María',
            'Ambo',
            'Dos de Mayo',
        ];
    }

    public function indexProductos()
    {
        $productos = Producto::obtenerTodos();
        return view('artesano.productos-tabla', compact('productos'));
    }

    public function createProducto()
    {
        $categorias = $this->listaCategorias();
        $regiones = $this->listaRegiones();

        return view('artesano.producto-form', compact('categorias', 'regiones'));
    }

    public function storeProducto(Request $request)
    {
        $nombre = $request->input('nombre_producto') ?? $request->input('nombre');
        $request->merge(['nombre' => $nombre]);

        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'categoria'   => 'required|string|max:80',
            'region'      => 'nullable|string|max:80',
            'descripcion' => 'nullable|string|max:500',
            'precio'      => 'required|numeric|min:1',
            'stock'       => 'required|integer|min:1',
        ]);

        $validated['region']  = $validated['region'] ?: 'Huánuco';
        $validated['user_id'] = Auth::id();

        Producto::registrarProducto($validated);

        return redirect()
            ->route('artesano.productos.index')
            ->with('success', 'Producto artesanal registrado correctamente en la base de datos.');
    }

    public function destroyProducto(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('artesano.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function metricas()
    {
        $pedidos = Pedido::obtenerTodosConDetalle();
        $totalVentas = $pedidos->sum('total');
        $totalPedidos = $pedidos->count();
        $totalProductos = Producto::count();

        $resumenMetricas = [
            'ventas_mes'         => 'S/ ' . number_format((float) $totalVentas, 2),
            'pedidos_pendientes' => $pedidos->where('estado', '!=', 'Entregado')->count(),
            'productos_activos'  => $totalProductos,
            'calificacion'       => '4.9 ★',
            'reputacion'         => '4.9 ★ (' . $totalPedidos . ' pedidos)',
        ];

        $pedidosRecibidos = $pedidos->map(function ($pedido) {
            $cantidad = $pedido->cantidad ?? 1;

            return [
                'codigo'   => 'PED-' . str_pad((string) $pedido->id, 4, '0', STR_PAD_LEFT),
                'cliente'  => optional($pedido->comprador)->name ?? optional($pedido->user)->name ?? 'Cliente',
                'producto' => optional($pedido->producto)->nombre ?? 'Artesanía Huánuco',
                'cantidad' => $cantidad,
                'cant'     => $cantidad,
                'total'    => 'S/ ' . number_format((float) ($pedido->total ?? 0), 2),
                'estado'   => $pedido->estado ?? 'Pagado',
            ];
        });

        return view('artesano.metricas', compact(
            'pedidos',
            'totalVentas',
            'totalPedidos',
            'totalProductos',
            'resumenMetricas',
            'pedidosRecibidos'
        ));
    }

    public function editProducto(Producto $producto)
    {
        $categorias = $this->listaCategorias();
        $regiones = $this->listaRegiones();

        return view('artesano.producto-edit', compact('producto', 'categorias', 'regiones'));
    }

    public function updateProducto(Request $request, Producto $producto)
    {
        $nombre = $request->input('nombre_producto') ?? $request->input('nombre');
        $request->merge(['nombre' => $nombre]);

        $validated = $request->validate([
            'nombre'      => 'required|string|max:150',
            'categoria'   => 'required|string|max:80',
            'region'      => 'nullable|string|max:80',
            'descripcion' => 'nullable|string|max:500',
            'precio'      => 'required|numeric|min:1',
            'stock'       => 'required|integer|min:0',
        ]);

        $producto->update([
            'nombre'      => $validated['nombre'],
            'categoria'   => $validated['categoria'],
            'region'      => $validated['region'] ?: ($producto->region ?: 'Huánuco'),
            'descripcion' => $validated['descripcion'] ?? $producto->descripcion,
            'precio'      => $validated['precio'],
            'stock'       => $validated['stock'],
        ]);

        return redirect()
            ->route('artesano.productos.index')
            ->with('success', 'Producto y stock actualizados correctamente.');
    }
}