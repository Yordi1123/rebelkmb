<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pronosticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->date('periodo'); // Fecha del periodo pronosticado (mes/semana)
            $table->string('metodo')->nullable(); // promedio_movil, suavizacion_exponencial, etc.
            $table->decimal('alfa_suavizacion', 5, 4)->nullable(); // Parámetro α para suavización
            $table->decimal('demanda_pronosticada', 10, 2)->nullable();
            $table->decimal('demanda_real', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pronosticos');
    }
};
