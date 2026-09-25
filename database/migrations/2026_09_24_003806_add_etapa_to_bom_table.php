<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bom', function (Blueprint $table) {
            $table->string('etapa', 100)->nullable()->after('unidad_medida');
            // Asegurar que no se pueda agregar el mismo insumo dos veces en la misma receta
            $table->unique(['producto_id', 'material_id'], 'bom_producto_material_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bom', function (Blueprint $table) {
            $table->dropUnique('bom_producto_material_unique');
            $table->dropColumn('etapa');
        });
    }
};
