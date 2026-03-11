# 🐙 BeTalent - Payment Gateway API

Este projeto é uma API robusta de processamento de pagamentos desenvolvida em Laravel 11, focada em alta disponibilidade e resiliência.

## 🚀 Diferenciais Técnicos (Card 5)

### 1. Sistema de Failover (Resiliência)
A API utiliza o padrão **Strategy** para gerenciar múltiplos gateways. Caso o provedor principal falhe, o sistema realiza um **failover automático** para o próximo disponível.

### 2. Idempotência e Integridade
- **Proteção contra Duplicidade:** Uso de `idempotency_key` para evitar cobranças duplicadas.
- **Banco de Dados Profissional:** Relacionamentos normalizados com chaves estrangeiras (`gateway_id`, `product_id`).

### 3. Performance
- **Eager Loading:** Uso de `with()` nas consultas para evitar o problema N+1 e otimizar a performance.

## 🧪 Como Testar

### Testes de Regras de Negócio
\`\`\`bash
chmod +x teste_api.sh
./teste_api.sh
\`\`\`

### Simulação de Failover
\`\`\`bash
chmod +x test_failover.sh
./test_failover.sh
\`\`\`
