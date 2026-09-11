<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaInsumo extends Model
{

    protected $table = 'categorias_insumo';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function insumos(): HasMany
    {
        return $this->hasMany(Insumo::class);
    }
}
