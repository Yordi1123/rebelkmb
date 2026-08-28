<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej: Y, YF, YG, YGF, KB
            $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->string('tipo')->nullable(); // yogurt_natural, yogurt_frutado, kombucha, etc.
            $table->string('sabor')->nullable(); // Fresa, Maracuyá, Arándanos, Coca Muña...
            $table->string('presentacion')->nullable(); // 1L, 150ml, 150g
            $table->string('unidad_medida')->nullable(); // litros, gramos, unidades
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
