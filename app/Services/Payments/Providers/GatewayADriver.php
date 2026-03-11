<?php
namespace App\Services\Payments\Providers;
use App\Services\Payments\GatewayInterface;
use Illuminate\Support\Facades\Http;

class GatewayADriver implements GatewayInterface {
    public function pay(int $amount, array $payload): array {
        try {
            $response = Http::timeout(5)->post('http://betalent-mocks:3001/pay', [
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
            return ['success' => false]; 
        }
    }
}
