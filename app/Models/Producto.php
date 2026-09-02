<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    // ── Eager loading automático ──────────────────────────────────────────────
    // Garantiza que las relaciones siempre se carguen, independientemente del
    // controller que consulte el modelo. Previene N+1 queries silenciosas.
    protected $with = ['categoria', 'tipo', 'sabor'];

    protected $fillable = [
        'nombre',
        'categoria_id',
        'tipo_id',
        'sabor_id',
        'presentacion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Deriva la unidad de medida a partir de la categoría.
     * Permite usar $producto->unidad_medida aunque la columna ya no exista en la tabla productos.
     */
    protected function unidadMedida(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->categoria ? $this->categoria->unidad_medida : null,
        );
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class);
    }

    public function sabor(): BelongsTo
    {
        return $this->belongsTo(Sabor::class);
    }
}

