<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompradorController extends Controller
{
    public function catalogo()
    {
        $catalogo = [
            ['codigo' => 'ART-01', 'nombre' => 'Manta Bordada a Mano', 'tienda' => 'Taller Arte Huanuco', 'categoria' => 'Textileria', 'region' => 'Huanuco', 'precio' => 'S/ 120.00', 'stock' => 8],
            ['codigo' => 'ART-02', 'nombre' => 'Torito de Pucara Policromado', 'tienda' => 'Alfareros del Sur', 'categoria' => 'Ceramica', 'region' => 'Puno', 'precio' => 'S/ 85.00', 'stock' => 10],
            ['codigo' => 'ART-03', 'nombre' => 'Retablo Costumbrista', 'tienda' => 'Manos Huamanguinas', 'categoria' => 'Tallado', 'region' => 'Ayacucho', 'precio' => 'S/ 150.00', 'stock' => 4],
        ];

        $carrito = [
            ['producto' => 'Manta Bordada a Mano', 'cantidad' => 1, 'unitario' => 'S/ 120.00', 'subtotal' => 'S/ 120.00'],
            ['producto' => 'Torito de Pucara Policromado', 'cantidad' => 1, 'unitario' => 'S/ 85.00', 'subtotal' => 'S/ 85.00'],
        ];

        return view('comprador.catalogo-tabla', compact('catalogo', 'carrito'));
    }

    public function checkoutForm()
    {
        return view('comprador.checkout-form');
    }

    public function procesarCheckout(Request $request)
    {
        $request->validate([
            'direccion_envio' => 'required|min:6',
            'numero_tarjeta' => 'required|digits:16',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|min:5',
        ]);

        return back()->with('exito', 'Datos de pago y valoracion validados correctamente (Hito 1 sin BD).');
    }
}
