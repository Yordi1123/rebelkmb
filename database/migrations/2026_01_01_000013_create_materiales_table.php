<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('unidad_medida')->nullable();
            $table->decimal('stock_minimo', 10, 2)->default(0);
            $table->decimal('stock_seguridad', 10, 2)->default(0);
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
