<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria',
        'region',
        'descripcion',
        'precio',
        'stock',
        'user_id',
    ];

    public function artesano(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRegionEtiquetaAttribute(): string
    {
        return !empty($this->region) ? $this->region : 'Huánuco';
    }

    public static function obtenerTodos(): Collection
    {
        return self::orderBy('id', 'desc')->get();
    }

    public static function obtenerDisponibles(?string $categoria = null): Collection
    {
        $query = self::where('stock', '>', 0);

        if (!empty($categoria)) {
            $query->where('categoria', $categoria);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public static function registrarProducto(array $datos): self
    {
        $datos['region'] = !empty($datos['region']) ? $datos['region'] : 'Huánuco';

        return self::create($datos);
    }
}