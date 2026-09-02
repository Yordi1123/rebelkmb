<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sabores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Fresa, Maracuyá, Arándanos
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->timestamps();

            // El mismo nombre de sabor puede existir en más de una categoría
            // (ej: "Fresa" en Yogures Y en Kombuchas), pero no repetido DENTRO
            // de la misma categoría.
            $table->unique(['nombre', 'categoria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sabores');
    }
};
