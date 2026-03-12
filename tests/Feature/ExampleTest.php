<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste com diagnóstico para descobrir por que a rota dá 404.
     */
    public function test_api_products_endpoint_is_accessible(): void
    {
        // Garante que o banco tem dados
        $this->seed(ProductSeeder::class);

        // Tentamos acessar a rota de API
        $response = $this->getJson('/api/products');

        // Se der erro, o Laravel vai imprimir o dump da resposta no log do Actions
        if ($response->status() !== 200) {
            dump($response->getContent());
        }

        $response->assertStatus(200);
    }
}
