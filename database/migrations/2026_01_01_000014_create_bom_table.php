<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // BOM = Bill of Materials / Lista de materiales por producto
        Schema::create('bom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materiales')->onDelete('restrict');
            $table->decimal('cantidad_requerida', 10, 4);
            $table->string('unidad_medida')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom');
    }
};
