<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use App\Models\Pedido;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $artesano = User::updateOrCreate(
            ['email' => 'artesano@marketplace.pe'],
            [
                'name'     => 'Maestro Artesano Huanuco',
                'password' => Hash::make('artesano123'),
                'role'     => 'Artesano',
            ]
        );

        $comprador = User::updateOrCreate(
            ['email' => 'comprador@marketplace.pe'],
            [
                'name'     => 'Cliente Comprador',
                'password' => Hash::make('comprador123'),
                'role'     => 'comprador',
            ]
        );

        $prod1 = Producto::create([
            'nombre'      => 'Azucarera Artesanal Negritos de Huánuco con Sombrero',
            'categoria'   => 'Ceramica',
            'descripcion' => 'Azucarera moldeada y pintada a mano con iconografía tradicional.',
            'precio'      => 30.00,
            'stock'       => 20,
            'user_id'     => $artesano->id,
        ]);

        Producto::create([
            'nombre'      => 'Figura Artesanal Negritos de Huánuco',
            'categoria'   => 'Manualidad',
            'descripcion' => 'Figura Artesanal representativo a los Negritos de Huanuco',
            'precio'      => 40.00,
            'stock'       => 12,
            'user_id'     => $artesano->id,
        ]);

        Producto::create([
            'nombre'      => 'Billetera Artesanal Manos Cruzadas',
            'categoria'   => 'Manualidad',
            'descripcion' => 'Billetera artesanal de Huánuco está cuidadosamente elaborada en cuero de alta calidad.',
            'precio'      => 35.00,
            'stock'       => 10,
            'user_id'     => $artesano->id,
        ]);

        // Pedido 
        Pedido::create([
            'user_id'         => $comprador->id,
            'producto_id'     => $prod1->id,
            'cantidad'        => 2,
            'total'           => 60.00,
            'direccion_envio' => 'Jr. 11 de enero 200 , Amarilis',
            'metodo_pago'     => 'Yape',
            'estado'          => 'Pagado',
        ]);
    }
}