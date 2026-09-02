<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Sabor;
use Illuminate\Database\Seeder;

class SaborSeeder extends Seeder
{
    public function run(): void
    {
        $yogures = Categoria::where('nombre', 'Yogures')->firstOrFail();
        $kombuchas = Categoria::where('nombre', 'Kombuchas')->firstOrFail();

        // Confirmados en YOGURT-REGISTRO2026.xlsx, hoja FR-RL-Y-001
        $saboresYogures = ['Arándanos', 'Maracuyá', 'Mango', 'Maracuyá-Mango', 'Fresa'];

        // Confirmados en KOMBUCHA-REGISTRO_2026.xlsx
        $saboresKombucha = ['Fresa', 'Coca Muña', 'Maracuyá', 'Arándanos', 'Piña Jengibre', 'Hierba Luisa'];

        foreach ($saboresYogures as $nombre) {
            Sabor::firstOrCreate(['nombre' => $nombre, 'categoria_id' => $yogures->id]);
        }

        foreach ($saboresKombucha as $nombre) {
            Sabor::firstOrCreate(['nombre' => $nombre, 'categoria_id' => $kombuchas->id]);
        }
    }
}
