<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_mps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->date('periodo'); // Periodo del MPS (semana/mes)
            $table->decimal('stock_inicial', 10, 2)->default(0);
            $table->decimal('demanda', 10, 2)->default(0);
            $table->decimal('produccion_planificada', 10, 2)->default(0);
            $table->decimal('stock_final', 10, 2)->default(0);
            $table->enum('estado', ['borrador', 'confirmado', 'cerrado'])->default('borrador');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_mps');
    }
};
