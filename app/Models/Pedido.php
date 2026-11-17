<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'cantidad',
        'total',
        'direccion_envio',
        'metodo_pago',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function registrarPedido(array $datos, Producto $producto): self
    {
        $pedido = self::create([
            'user_id'         => $datos['user_id'],
            'producto_id'     => $producto->id,
            'cantidad'        => $datos['cantidad'],
            'total'           => $producto->precio * $datos['cantidad'],
            'direccion_envio' => $datos['direccion_envio'],
            'metodo_pago'     => $datos['metodo_pago'],
            'estado'          => 'Pagado',
        ]);

        $producto->decrement('stock', $datos['cantidad']);

        return $pedido;
    }

    public static function obtenerPorComprador(int $userId): Collection
    {
        return self::with('producto')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
    }


    public static function obtenerTodosConDetalle(): Collection
    {
        return self::with(['producto', 'comprador'])
            ->orderBy('id', 'desc')
            ->get();
    }
}