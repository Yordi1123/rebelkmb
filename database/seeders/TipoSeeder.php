<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $yogures  = Categoria::where('nombre', 'Yogures')->firstOrFail();
        $kombuchas = Categoria::where('nombre', 'Kombuchas')->firstOrFail();

        $tipos = [
            // ── Yogures ──────────────────────────────────────────────────────
            [
                'codigo'         => 'YN',
                'nombre'         => 'Yogurt Natural',
                'categoria_id'   => $yogures->id,
                'requiere_sabor' => false,
            ],
            [
                'codigo'         => 'YF',
                'nombre'         => 'Yogurt Frutado',
                'categoria_id'   => $yogures->id,
                'requiere_sabor' => true,
            ],
            [
                'codigo'         => 'YG',
                'nombre'         => 'Yogurt Griego',
                'categoria_id'   => $yogures->id,
                'requiere_sabor' => false,
            ],
            [
                'codigo'         => 'YGF',
                'nombre'         => 'Yogurt Griego Frutado',
                'categoria_id'   => $yogures->id,
                'requiere_sabor' => true,
            ],
            // ── Kombuchas ─────────────────────────────────────────────────────
            [
                'codigo'         => 'KB',
                'nombre'         => 'Kombucha',
                'categoria_id'   => $kombuchas->id,
                'requiere_sabor' => true,
            ],
        ];

        foreach ($tipos as $tipo) {
            Tipo::firstOrCreate(
                ['codigo' => $tipo['codigo']],
                $tipo
            );
        }
    }
}
