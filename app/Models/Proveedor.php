<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'ruc',
        'direccion',
        'contacto',
        'lead_time_dias',
    ];

    protected $casts = [
        'lead_time_dias' => 'integer',
    ];

    // ── Relaciones futuras ──────────────────────────────────────────────────
    // public function ordenesCompra(): HasMany
    // {
    //     return $this->hasMany(OrdenCompra::class);
    // }

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }
}
