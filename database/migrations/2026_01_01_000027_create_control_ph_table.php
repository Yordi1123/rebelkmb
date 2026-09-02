<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Control de pH diario — crítico para kombucha (fermentación ácida)
        Schema::create('control_ph', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->decimal('ph', 4, 2); // Rango típico: 2.5 - 7.0
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('control_ph');
    }
};
