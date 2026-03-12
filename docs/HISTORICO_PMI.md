# 📑 Relatório de Gerenciamento de Projeto (Padrão PMI)
**Projeto:** Gateway de Pagamento BeTalent - Nível 3  
**Desenvolvedor:** Yure Mark  
**Data de Conclusão:** Março de 2026

## 1. Introdução
Este documento detalha o ciclo de vida do desenvolvimento do desafio BeTalent, focando na transição do Nível 2 para o Nível 3, documentando incidentes, decisões arquiteturais e lições aprendidas sob a ótica de gerenciamento de projetos.

## 2. Histórico de Incidentes e Gestão de Mudanças
Durante a execução, foram identificados e mitigados os seguintes riscos técnicos:

| ID | Incidente | Causa Raiz | Solução Aplicada |
| :--- | :--- | :--- | :--- |
| **INC-01** | Erro de Coluna amount | Divergência de esquema entre níveis do desafio. | Refatoração de Migrations e Reset do Banco. |
| **INC-02** | Erro de Role (Acesso) | Falta de atributo de privilégio no modelo User. | Implementação de coluna role e Seeder de Atores. |
| **INC-03** | Erro de Kernel (Closure) | Middleware anônimo impedindo cache de rotas. | Criação da Classe CheckAdminRole (Padrão RBAC). |
| **INC-04** | Dubious Ownership | Conflito de permissão Docker/Linux. | Ajuste de configuração de segurança do Git (safe.directory). |

## 3. Arquitetura e Casos de Uso
O projeto foi estruturado para garantir a separação de responsabilidades (SoC):

### Atores:
- **Cliente (User):** Autentica e realiza pagamentos de múltiplos itens. Valor calculado no backend para segurança.
- **Administrador (Admin):** Possui visão holística do sistema, acessando a listagem completa de transações.

### Componentes Chave:
- **Service Layer (PaymentService):** Centraliza a lógica de cálculo (evitando Fat Controllers).
- **Middleware (CheckAdminRole):** Garante que apenas usuários autorizados atinjam os endpoints de auditoria.
- **Pivot Table (transaction_products):** Suporta a relação N:N exigida no Nível 3.

## 4. Lições Aprendidas
- **Segurança em Primeiro Lugar:** Validamos que o cálculo de montante (amount) deve ser feito buscando preços no Banco de Dados, nunca confiando no JSON enviado pelo cliente.
- **Automação de Testes:** Scripts de teste (teste_api.sh) e Seeders robustos reduzem o tempo de QA e facilitam o onboarding de novos desenvolvedores.
- **Resiliência:** O processo de correção de erros de namespace e kernel reforçou a importância de seguir as convenções da PSR e do Framework Laravel.

---
*Este documento serve como prova de conceito para competências técnicas e de gestão de projetos.*
