<?php

namespace App\Services\Payments;

/**
 * Interface GatewayInterface
 * Eu defini este contrato para que o sistema seja "agnóstico" ao gateway.
 * Se amanhã a BeTalent trocar de fornecedor, basta criar um novo Driver 
 * que respeite este método 'pay'.
 */
interface GatewayInterface
{
    /**
     * @param int $amount Valor em centavos
     * @param array $payload Dados da transação
     */
    public function pay(int $amount, array $payload): array;
}
