<?php

namespace App\Services\Payment\Providers;

use App\Services\Payment\GatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayBDriver implements GatewayInterface
{
    public function pay(int $amount, array $payload): array
    {
        try {
            // AGORA SIM: Eu chamo a URL que está no cofre (.env)
            // Se no .env estiver 'http://betalent-mocks:3002/pay', ele vai achar o caminho!
            $url = env('GATEWAY_B_URL');

            $response = Http::timeout(5)->post($url, [
                'amount' => $amount,
                'card_number' => $payload['card_number'] ?? '1111',
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'transaction_id' => (string) ($response->json('id') ?? uniqid()),
                ];
            }

            return ['success' => false];

        } catch (\Exception $e) {
            // Se o B também falhar, eu aviso no log que a redundância caiu.
            Log::critical("Erro no Gateway B de reserva: " . $e->getMessage());
            return ['success' => false];
        }
    }
}