<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Sabor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrearSaborTest extends TestCase
{
    use RefreshDatabase;

    public function test_sabor_se_sanitiza_correctamente(): void
    {
        $admin = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Test Cat',
            'descripcion' => 'Desc',
            'unidad_medida' => 'unidades'
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/sabores', [
                'nombre' => '   fresa  ',
                'categoria_id' => $categoria->id
            ]);

        $response->assertSessionHasNoErrors();
        
        $this->assertDatabaseHas('sabores', [
            'nombre' => 'Fresa',
            'categoria_id' => $categoria->id
        ]);
    }
    
    public function test_no_permite_sabor_duplicado_en_misma_categoria(): void
    {
        $admin = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Test Cat',
            'descripcion' => 'Desc',
            'unidad_medida' => 'unidades'
        ]);

        Sabor::create([
            'nombre' => 'Fresa',
            'categoria_id' => $categoria->id
        ]);

        $response = $this->actingAs($admin)
            ->post('/admin/sabores', [
                'nombre' => 'Fresa',
                'categoria_id' => $categoria->id
            ]);

        $response->assertSessionHasErrors(['nombre']);
    }
}
