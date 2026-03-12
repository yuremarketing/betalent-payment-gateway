<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Isso limpa o banco e prepara as migrations para o teste

    /**
     * Teste básico para verificar se a API está respondendo com dados.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // 1. Populamos o banco de teste com os produtos
        $this->seed(ProductSeeder::class);

        // 2. Agora a rota deve encontrar os produtos e retornar 200
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }
}
