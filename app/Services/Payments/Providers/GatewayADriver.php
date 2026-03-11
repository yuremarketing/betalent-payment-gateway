<?php

namespace App\Services\Payments\Providers;

use App\Services\Payments\GatewayInterface;
use Illuminate\Support\Facades\Http;

class GatewayADriver implements GatewayInterface {
    
    public function pay(int $amount, array $payload): array {
        try {
            // Agora eu busco a URL diretamente do arquivo .env.
            // Isso evita erros de digitação e facilita a manutenção.
            $url = env('GATEWAY_A_URL');

            $response = Http::timeout(5)->post($url, [
                'amount' => (int) $amount,
                'card_number' => $payload['card_number'] ?? '0000',
            ]);
            
            if ($response->successful()) {
                return [
                    'success' => true, 
                    'transaction_id' => (string) ($response->json('id') ?? uniqid())
                ];
            }
            
            return ['success' => false];

        } catch (\Exception $e) { 
            // Se houver falha de rede, eu retorno falso para o Service 
            // acionar o próximo Gateway da lista (Failover).
            return ['success' => false]; 
        }
    }
}