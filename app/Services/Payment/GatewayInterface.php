<?php
namespace App\Services\Payment;
interface GatewayInterface {
    public function process(int $amount, array $data): array;
}
