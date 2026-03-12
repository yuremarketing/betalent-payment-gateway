<?php
namespace App\Services\Payment;
class PaymentService {
    public function process(int $amount, array $data): array {
        return [
            'id' => 'BT-' . uniqid(),
            'status' => 'PAID',
            'gateway' => 'Default',
            'amount' => $amount
        ];
    }
}
