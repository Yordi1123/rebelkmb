<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kardex de materias primas: entradas por compra, salidas por consumo en producción
        Schema::create('kardex_materiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materiales')->onDelete('restrict');
            $table->enum('tipo_movimiento', ['entrada', 'salida']); // entrada=compra, salida=consumo
            $table->decimal('cantidad', 10, 4);
            $table->date('fecha');
            $table->decimal('stock_resultante', 10, 4)->default(0);
            // Opcional: referencia al origen del movimiento
            $table->foreignId('orden_compra_id')->nullable()->constrained('ordenes_compra')->onDelete('set null');
            $table->foreignId('orden_produccion_id')->nullable()->constrained('ordenes_produccion')->onDelete('set null');
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kardex_materiales');
    }
};
