<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Preinóculo: cultivo preparado antes de la producción (aplica a yogurt)
        Schema::create('preinoculo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable(); // FR-PI: código de formato preinóculo
            $table->date('fecha_preparacion')->nullable();
            $table->date('fecha_congelacion')->nullable();
            $table->date('fecha_uso')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preinoculo');
    }
};
