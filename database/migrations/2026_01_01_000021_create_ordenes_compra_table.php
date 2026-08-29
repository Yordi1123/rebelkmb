<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('restrict');
            $table->foreignId('material_id')->constrained('materiales')->onDelete('restrict');
            $table->decimal('cantidad', 10, 4);
            $table->date('fecha_emision')->nullable();
            $table->integer('lead_time_dias')->default(0);
            $table->enum('estado', ['pendiente', 'confirmada', 'recibida', 'cancelada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
