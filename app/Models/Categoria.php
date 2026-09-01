<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Categoria extends Model
{
    // ── Fuente única de verdad ────────────────────────────────────────────────
    const UNIDADES_MEDIDA = [
        'mililitros', 'litros', 'gramos', 'kilogramos', 'unidades',
    ];

    const PRESENTACIONES_POR_UNIDAD = [
        'mililitros' => ['150ml', '200ml', '250ml', '330ml', '500ml', '1L'],
        'litros'     => ['1L', '2L', '5L'],
        'gramos'     => ['100g', '220g', '250g', '500g'],
        'kilogramos' => ['1kg', '2kg', '5kg'],
        'unidades'   => ['1u', '6u', '12u', '24u'],
    ];

    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
    ];

    /**
     * Devuelve las presentaciones válidas para la unidad de medida de esta categoría.
     */
    protected function presentaciones(): Attribute
    {
        return Attribute::make(
            get: fn () => self::PRESENTACIONES_POR_UNIDAD[$this->unidad_medida] ?? [],
        );
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    public function tipos(): HasMany
    {
        return $this->hasMany(Tipo::class);
    }

    public function sabores(): HasMany
    {
        return $this->hasMany(Sabor::class);
    }
}

