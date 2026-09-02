<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_produccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('restrict');
            $table->date('fecha_planificada')->nullable();
            $table->date('fecha_real')->nullable();
            $table->decimal('cantidad_planificada', 10, 2)->default(0);
            $table->decimal('cantidad_real', 10, 2)->nullable();
            $table->enum('estado', ['planificada', 'en_proceso', 'finalizada', 'cancelada'])->default('planificada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_produccion');
    }
};
