<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Agregar las columnas nuevas que "materiales" no tenía.
        Schema::table('materiales', function (Blueprint $table) {
            $table->foreignId('categoria_insumo_id')
                ->after('nombre')
                ->constrained('categorias_insumo')
                ->onDelete('restrict');

            $table->decimal('stock_actual', 10, 2)->default(0)->after('unidad_medida');

            $table->boolean('activo')->default(true)->after('proveedor_id');
        });

        // 2) Volver proveedor_id opcional (paso separado: primero se quita
        // la restricción existente, luego se modifica la columna, y por
        // último se vuelve a crear la restricción — así evitamos conflictos
        // con MySQL al tocar una columna que ya tiene una llave foránea).
        Schema::table('materiales', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
        });

        Schema::table('materiales', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedor_id')->nullable()->change();
        });

        Schema::table('materiales', function (Blueprint $table) {
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            $table->dropForeign(['categoria_insumo_id']);
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn(['categoria_insumo_id', 'stock_actual', 'activo']);
        });

        Schema::table('materiales', function (Blueprint $table) {
            $table->unsignedBigInteger('proveedor_id')->nullable(false)->change();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict');
        });
    }
};
