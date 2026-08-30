<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'tipo', 'sabor']);

            $table->foreignId('tipo_id')
                ->after('categoria_id')
                ->constrained('tipos')
                ->onDelete('restrict');

            $table->foreignId('sabor_id')
                ->nullable() // Yogurt Natural y Yogurt Griego no llevan sabor
                ->after('tipo_id')
                ->constrained('sabores')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['tipo_id']);
            $table->dropForeign(['sabor_id']);
            $table->dropColumn(['tipo_id', 'sabor_id']);

            $table->string('codigo')->unique()->after('id');
            $table->string('tipo')->nullable();
            $table->string('sabor')->nullable();
        });
    }
};
