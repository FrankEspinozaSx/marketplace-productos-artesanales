<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtesanoController extends Controller
{
    public function metricas()
    {
        $resumenMetricas = [
            'ventas_mes' => 'S/ 2,480.00',
            'pedidos_pendientes' => 4,
            'productos_activos' => 12,
            'calificacion' => '4.9 / 5.0'
        ];

        $pedidosRecibidos = [
            ['codigo' => 'PED-101', 'cliente' => 'Carlos Ruiz', 'producto' => 'Manta Bordada Huanuco', 'cantidad' => 1, 'total' => 'S/ 120.00', 'estado' => 'En Preparacion'],
            ['codigo' => 'PED-102', 'cliente' => 'Lucia Torres', 'producto' => 'Vasija Ceremonial Arcilla', 'cantidad' => 2, 'total' => 'S/ 170.00', 'estado' => 'Enviado'],
            ['codigo' => 'PED-103', 'cliente' => 'Pedro Diaz', 'producto' => 'Mascara Negritos Tallada', 'cantidad' => 1, 'total' => 'S/ 150.00', 'estado' => 'Entregado'],
        ];

        return view('artesano.metricas', compact('resumenMetricas', 'pedidosRecibidos'));
    }

    public function indexProductos()
    {
        $productos = [
            ['id' => 1, 'nombre' => 'Manta Bordada Tradicional', 'categoria' => 'Textileria', 'region' => 'Huanuco', 'precio' => 'S/ 120.00', 'stock' => 8],
            ['id' => 2, 'nombre' => 'Vasija de Arcilla Roja', 'categoria' => 'Ceramica', 'region' => 'Huanuco', 'precio' => 'S/ 85.00', 'stock' => 5],
            ['id' => 3, 'nombre' => 'Retablo Ayacuchano Clasico', 'categoria' => 'Tallado', 'region' => 'Ayacucho', 'precio' => 'S/ 140.00', 'stock' => 3],
        ];

        return view('artesano.productos-tabla', compact('productos'));
    }

    public function createProducto()
    {
        $categorias = ['Textileria', 'Ceramica', 'Tallado en Madera', 'Joyeria Artesanal'];
        $regiones = ['Huanuco', 'Cusco', 'Ayacucho', 'Puno', 'Junin'];

        return view('artesano.producto-form', compact('categorias', 'regiones'));
    }

    public function storeProducto(Request $request)
    {
        $request->validate([
            'nombre_tienda' => 'required|min:3',
            'nombre_producto' => 'required|min:4',
            'categoria' => 'required',
            'region' => 'required',
            'precio' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'descripcion' => 'required|min:10',
        ]);

        return back()->with('exito', 'Formulario validado correctamente (Hito 1 sin insercion en BD).');
    }
}
