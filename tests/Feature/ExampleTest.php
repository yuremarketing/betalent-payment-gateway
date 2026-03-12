<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Teste para garantir que a rota de transações existe e está protegida.
     */
    public function test_transactions_route_is_protected(): void
    {
        // Tentamos acessar a rota que NÓS criamos (sem enviar token)
        $response = $this->getJson('/api/transactions');

        // Como estamos sem token, o Laravel Sanctum DEVE nos barrar com 401
        $response->assertStatus(401);
    }
}
