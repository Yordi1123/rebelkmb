<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kardex de producto terminado: entradas por producción aprobada, salidas por despacho
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('restrict');
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('restrict');
            $table->enum('tipo_movimiento', ['entrada', 'salida']);
            $table->decimal('cantidad', 10, 2);
            $table->date('fecha');
            $table->decimal('stock_resultante', 10, 2)->default(0);
            $table->string('referencia')->nullable(); // Referencia a pedido, despacho, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
