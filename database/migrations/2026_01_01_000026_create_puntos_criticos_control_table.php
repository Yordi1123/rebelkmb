<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Control de Puntos Críticos (HACCP) — monitoreo de temperatura/tiempo por proceso
        Schema::create('puntos_criticos_control', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_produccion_id')->constrained('ordenes_produccion')->onDelete('cascade');
            $table->string('proceso')->nullable(); // Recepción de leche, Filtración, Pasteurizado, etc.
            $table->string('equipo')->nullable(); // Olla 1, Barril FK-001, etc.
            $table->decimal('cantidad_litros', 10, 2)->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_final')->nullable();
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puntos_criticos_control');
    }
};
