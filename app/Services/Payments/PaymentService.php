<?php

namespace App\Services\Payments;

use App\Models\Gateway;
use App\Services\Payments\Providers\GatewayADriver;
use App\Services\Payments\Providers\GatewayBDriver;
use Exception;

class PaymentService
{
    public function processPayment(array $data)
    {
        $gateways = Gateway::where('is_active', true)->orderBy('priority', 'asc')->get();

        foreach ($gateways as $gateway) {
            try {
                $driver = $this->getDriver($gateway->name);
                $result = $driver->pay($data['amount'], $data);

                if ($result['success']) {
                    return [
                        'status' => 'paid',
                        'gateway' => $gateway->name,
                        'transaction_id' => $result['transaction_id']
                    ];
                }
            } catch (Exception $e) {
                continue;
            }
        }

        throw new Exception('Todos os gateways de pagamento falharam.');
    }

    private function getDriver(string $name)
    {
        return match ($name) {
            'Gateway A' => new GatewayADriver(),
            'Gateway B' => new GatewayBDriver(),
            default => throw new Exception("Driver para {$name} não encontrado."),
        };
    }
}
