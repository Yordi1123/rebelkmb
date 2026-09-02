<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CrearCategoriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_crear_categoria(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->post('/admin/categorias', [
                'nombre' => 'Nueva Categoria Test',
                'descripcion' => 'Descripción de prueba',
                'unidad_medida' => 'gramos'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        
        $this->assertDatabaseHas('categorias', [
            'nombre' => 'Nueva Categoria Test',
            'unidad_medida' => 'gramos'
        ]);
    }
}
