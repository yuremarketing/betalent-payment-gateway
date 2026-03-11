<?php

namespace App\Services\Payments\Providers;

use App\Services\Payments\GatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GatewayBDriver implements GatewayInterface
{
    /**
     * Implementação do Gateway B.
     * Eu projetei este driver para ser o nosso braço direito no Failover.
     * Ele segue exatamente o mesmo contrato do Gateway A, garantindo que
     * a troca entre eles seja totalmente transparente para o restante do sistema.
     */
    public function pay(int $amount, array $payload): array
    {
        try {
            // Aqui eu aponto para o segundo container (porta 3002).
            // Mantive o padrão de logs para que eu consiga monitorar qual
            // gateway está sendo mais acionado durante o dia a dia.
            $response = Http::post('http://betalent-gateway-b:3002/pay', [
                'amount' => $amount,
                'card_number' => $payload['card_number'] ?? '1111',
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'transaction_id' => $response->json('id'),
                    'message' => 'Pago via Gateway B (Redundância Ativa)'
                ];
            }

            return [
                'success' => false,
                'message' => 'Falha no processamento do Gateway B'
            ];

        } catch (\Exception $e) {
            // Se o Gateway B também cair, eu registro o erro crítico no log
            // para que a equipe de infraestrutura seja alertada imediatamente.
            Log::critical("Erro de conexão com o Gateway B de reserva: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gateway B indisponível'
            ];
        }
    }
}
