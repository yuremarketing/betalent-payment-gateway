# 🏛️ Relatório de Governança e Gestão de Projeto (Padrão PMI/PMBOK)

Este documento detalha a aplicação de metodologias de gerenciamento de projetos do **Project Management Institute (PMI)** no desenvolvimento do desafio **BeTalent Payment Gateway**.

## 1. Termo de Abertura do Projeto (Iniciação)
**Objetivo:** Desenvolver uma API de pagamentos resiliente com arquitetura de microserviços, garantindo que falhas de terceiros (gateways) não interrompam a operação de negócio.
**Justificativa:** A alta disponibilidade é um requisito crítico para sistemas financeiros.

## 2. Gerenciamento de Riscos (Monitoramento e Controle)
Utilizei a técnica de identificação e resposta a riscos para garantir a continuidade do serviço.

| Risco Identificado | Impacto | Probabilidade | Estratégia de Resposta (PMI) | Ação Implementada |
| :--- | :--- | :--- | :--- | :--- |
| **Indisponibilidade do Gateway A** | Crítico | Média | **Mitigar** | Implementação de **Failover Silencioso** para o Gateway B. |
| **Transações Duplicadas** | Alto | Baixa | **Prevenir** | Uso de `idempotency_key` no banco de dados. |
| **Inconsistência de Dados** | Alto | Baixa | **Mitigar** | Uso de **Database Migrations** para versionamento de schema. |
| **Vazamento de Credenciais** | Crítico | Baixa | **Evitar** | Uso de variáveis de ambiente (`.env`) e GitTokens. |

## 3. Gerenciamento do Escopo e Qualidade (Planejamento)
O projeto foi executado seguindo padrões de engenharia de software para garantir a manutenibilidade:
* **WBS (Estrutura Analítica do Projeto):** Decomposição em camadas (Controller, Service, Driver).
* **Garantia da Qualidade (QA):** Uso de **Interfaces** (Contratos) para assegurar que novos gateways mantenham o padrão técnico sem quebrar o sistema.
* **Auditoria:** Implementação de **Logging** para rastreabilidade de falhas silenciosas, permitindo melhoria contínua dos processos.

## 4. Gerenciamento da Comunicação
A transparência com os stakeholders foi garantida através de:
* Documentação técnica no `README.md`.
* Relatórios de commits semânticos (Conventional Commits).
* Este relatório de governança para visibilidade de gestão.

---
**Responsável Técnico e Gestor:** Yure Mark Espíndola da Silva
**Data:** 10 de Março de 2026
