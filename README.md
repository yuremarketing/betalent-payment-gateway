# 🐙 BeTalent - Gateway de Pagamento (Nível 3)

[![PMI Standards](https://img.shields.io/badge/PMI-Governance-blue)](./docs/GOVERNANCA_COMPLETA.md)
[![LLM Ready](https://img.shields.io/badge/LLM-Ready-green)](./docs/LLM_CONTEXT.yaml)
[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20)](https://laravel.com)

Projeto focado em segurança financeira, arquitetura escalável e governança PMBOK.

## 🤖 Uso com LLMs (IA)
Este repositório é otimizado para ser lido por IAs. Forneça o arquivo abaixo para contexto imediato:
👉 [**LLM Context Esqueleto (YAML)**](./docs/LLM_CONTEXT.yaml)

## 📊 Governança e Gestão (PMI)
Acesse a documentação completa de gerenciamento:
* [📘 Governança e Riscos](./docs/GOVERNANCA_COMPLETA.md)
* [📜 Histórico de Lições Aprendidas](./docs/HISTORICO_PMI.md)

## 🚀 Como Executar
1. \`docker-compose up -d\`
2. \`docker exec -it betalent-app php artisan migrate:fresh --seed\`
3. \`docker exec -it betalent-app composer dump-autoload\`

---
*Projeto desenvolvido por Yure Mark - Março de 2026*
