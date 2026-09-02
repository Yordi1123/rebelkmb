<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despachos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('restrict');
            $table->foreignId('producto_terminado_id')->constrained('producto_terminado')->onDelete('restrict');
            $table->date('fecha_despacho')->nullable();
            $table->decimal('cantidad', 10, 2);
            $table->enum('estado', ['pendiente', 'despachado', 'entregado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despachos');
    }
};
