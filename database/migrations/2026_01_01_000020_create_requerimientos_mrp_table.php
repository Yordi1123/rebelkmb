<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requerimientos_mrp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materiales')->onDelete('restrict');
            $table->foreignId('mps_id')->constrained('plan_mps')->onDelete('cascade');
            $table->decimal('necesidad_bruta', 10, 4)->default(0);
            $table->decimal('disponible', 10, 4)->default(0);
            $table->decimal('stock_seguridad', 10, 4)->default(0);
            $table->decimal('necesidad_neta', 10, 4)->default(0);
            $table->date('fecha_requerida')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requerimientos_mrp');
    }
};
