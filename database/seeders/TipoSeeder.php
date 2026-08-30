<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $yogures = Categoria::where('nombre', 'Yogures')->firstOrFail();
        $kombuchas = Categoria::where('nombre', 'Kombuchas')->firstOrFail();

        $tipos = [
            ['codigo' => 'YN', 'nombre' => 'Yogurt Natural', 'categoria_id' => $yogures->id],
            ['codigo' => 'YF', 'nombre' => 'Yogurt Frutado', 'categoria_id' => $yogures->id],
            ['codigo' => 'YG', 'nombre' => 'Yogurt Griego', 'categoria_id' => $yogures->id],
            ['codigo' => 'YGF', 'nombre' => 'Yogurt Griego Frutado', 'categoria_id' => $yogures->id],
            ['codigo' => 'KB', 'nombre' => 'Kombucha', 'categoria_id' => $kombuchas->id],
        ];

        foreach ($tipos as $tipo) {
            Tipo::firstOrCreate(['codigo' => $tipo['codigo']], $tipo);
        }
    }
}
