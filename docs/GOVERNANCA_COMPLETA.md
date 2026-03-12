# ⚖️ Documento de Governança e Gestão de Riscos
**Projeto:** BeTalent Payment Gateway  
**Metodologia:** Waterfall/PMBOK Adaptado

## 1. Matriz RACI (Responsabilidades)
Define quem é Responsável, Prestador de Contas, Consultado e Informado.

| Entrega | Desenvolvedor (Yure) | Stakeholder (BeTalent) |
| :--- | :---: | :---: |
| Arquitetura do Banco | R/A | I |
| Implementação de Segurança | R/A | C |
| Regras de Negócio (Checkout) | R/A | I |
| Aprovação Final | R | A |

## 2. Registro de Riscos (Risk Register)
Mapeamento preventivo realizado durante o ciclo de vida.

| Risco | Probabilidade | Impacto | Plano de Mitigação |
| :--- | :---: | :---: | :--- |
| Injeção de valores falsos no Front | Alta | Crítico | Cálculo de `amount` realizado exclusivamente no Backend via Service Layer. |
| Exposição de dados de transação | Média | Alto | Implementação de Middleware RBAC e autenticação via Sanctum. |
| Incompatibilidade de Ambiente | Baixa | Médio | Conteinerização completa via Docker e Docker Compose. |

## 3. Critérios de Aceite (DoD - Definition of Done)
O projeto só é considerado concluído se:
1. Todas as rotas retornarem os status codes HTTP corretos (201, 200, 403).
2. O cálculo do checkout bater com a soma dos produtos no banco.
3. A documentação PMI refletir os desafios técnicos superados.

---
## 4. Estrutura Analítica do Projeto (EAP/WBS)
- **1.0 Setup de Ambiente**
  - 1.1 Configuração Docker
  - 1.2 Instalação Laravel
- **2.0 Núcleo de Pagamentos**
  - 2.1 Modelagem de Dados N:N
  - 2.2 Payment Service Layer
- **3.0 Segurança e Governança**
  - 3.1 Autenticação Sanctum
  - 3.2 Middleware de Roles
  - 3.3 Documentação PMI
