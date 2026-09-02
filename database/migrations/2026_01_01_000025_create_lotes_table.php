<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_lote')->unique(); // Ej: Y-300426-01, KB-MR-170426
            $table->foreignId('producto_id')->constrained('productos')->onDelete('restrict');
            $table->foreignId('orden_produccion_id')->constrained('ordenes_produccion')->onDelete('restrict');
            // Preinóculo es opcional (solo aplica a lotes de yogurt)
            $table->foreignId('preinoculo_id')->nullable()->constrained('preinoculo')->onDelete('set null');
            $table->date('fecha_produccion')->nullable();
            $table->date('fecha_envasado')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->decimal('volumen_base', 10, 2)->nullable(); // Litros base producidos
            $table->decimal('cantidad_producida', 10, 2)->nullable();
            $table->string('cultivo_utilizado')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado', ['en_proceso', 'vigente', 'vencido', 'retirado'])->default('en_proceso');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
