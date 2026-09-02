<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique(); // Ej: YN, YF, YG, YGF, KB
            $table->string('nombre'); // Ej: Yogurt Natural, Kombucha
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos');
    }
};
