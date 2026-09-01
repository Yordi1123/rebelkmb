<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tipos', function (Blueprint $table) {
            $table->boolean('requiere_sabor')->default(false)->after('categoria_id');
        });
    }

    public function down(): void
    {
        Schema::table('tipos', function (Blueprint $table) {
            $table->dropColumn('requiere_sabor');
        });
    }
};
