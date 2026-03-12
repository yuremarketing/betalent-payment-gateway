<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Teste básico para verificar se a API está respondendo.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Vamos testar um endpoint da API que sabemos que existe
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }
}
