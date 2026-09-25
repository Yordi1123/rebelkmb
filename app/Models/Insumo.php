<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insumo extends Model
{
    // La tabla real se llama "materiales" (existía desde el diseño original
    // de la base de datos). Usamos el nombre "Insumo" en el código porque
    // es como el equipo se refiere al concepto ahora, pero la tabla
    // fisica conserva su nombre historico para no romper referencias
    // ya existentes (como bom.material_id).
    protected $table = 'materiales';

    public const UNIDADES = ['litros', 'mililitros', 'kilogramos', 'gramos', 'unidades'];

    protected $fillable = [
        'codigo',
        'nombre',
        'categoria_insumo_id',
        'proveedor_id',
        'unidad_medida',
        'stock_actual',
        'stock_minimo',
        'stock_seguridad',
        'activo',
    ];

    protected $casts = [
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'stock_seguridad' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function categoriaInsumo(): BelongsTo
    {
        return $this->belongsTo(CategoriaInsumo::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * true si el stock actual ya llegó (o cayó por debajo) del mínimo definido.
     * Se calcula al vuelo, no se guarda — así siempre refleja el dato real.
     */
    public function getStockBajoAttribute(): bool
    {
        return (float) $this->stock_actual <= (float) $this->stock_minimo;
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'bom', 'material_id', 'producto_id')
                    ->withPivot('id', 'cantidad_requerida', 'unidad_medida', 'etapa')
                    ->withTimestamps();
    }
}
