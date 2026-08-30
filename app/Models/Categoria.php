<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

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
