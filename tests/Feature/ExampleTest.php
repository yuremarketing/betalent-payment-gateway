<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\Route;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste com verificação de lista de rotas.
     */
    public function test_api_products_endpoint_is_accessible(): void
    {
        $this->seed(ProductSeeder::class);

        // Tenta buscar a rota pelo nome (se você definiu ->name('products.index'))
        // Ou tenta as duas variações comuns
        $url = Route::has('products.index') ? route('products.index') : '/api/products';
        
        $response = $this->getJson($url);

        // Se der 404 de novo, vamos listar TODAS as rotas no log para você ver
        if ($response->status() === 404) {
            $routes = collect(Route::getRoutes())->map(function ($route) {
                return $route->uri();
            });
            dump("Rotas encontradas:", $routes->toArray());
        }

        $response->assertStatus(200);
    }
}
