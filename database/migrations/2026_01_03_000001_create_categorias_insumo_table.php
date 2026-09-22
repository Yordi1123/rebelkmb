<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla SEPARADA de "categorias" (esa es para productos: Yogures/Kombuchas).
        // Los insumos necesitan su propia clasificación porque un mismo insumo
        // (ej: Agua) se usa en ambas líneas de producto, no pertenece a una sola.
        Schema::create('categorias_insumo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Materia Prima Líquida, Envases y Empaques
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_insumo');
    }
};
