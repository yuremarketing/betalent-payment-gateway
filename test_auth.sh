#!/bin/bash

BLUE='\033[0;34m'
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${BLUE}=== INICIANDO TESTE DE AUTENTICAÇÃO (CARD 6) ===${NC}\n"

# 1. TESTE SEM TOKEN (DEVE FALHAR COM 401)
echo -e "${BLUE}1. Testando acesso sem Token (Esperado: 401 Unauthorized)...${NC}"
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" -H "Accept: application/json" http://localhost:8000/api/transactions)

if [ "$HTTP_CODE" -eq 401 ]; then
    echo -e "${GREEN}[OK] O porteiro barrou o acesso sem convite! (Status 401)${NC}"
else
    echo -e "${RED}[ERRO] O comportamento esperado era 401, mas recebemos: $HTTP_CODE${NC}"
fi

# 2. GERANDO TOKEN VIA TINKER
echo -e "\n${BLUE}2. Gerando Token temporário para teste...${NC}"
TOKEN=$(docker exec -it betalent-app php artisan tinker --execute="\$user = \App\Models\User::first() ?? \App\Models\User::factory()->create(); echo \$user->createToken('test-token')->plainTextToken;" | tr -d '\r')

if [ -z "$TOKEN" ]; then
    echo -e "${RED}[ERRO] Não foi possível gerar o token.${NC}"
    exit 1
fi

echo -e "Token gerado: ${BLUE}$TOKEN${NC}"

# 3. TESTE COM TOKEN (DEVE FUNCIONAR)
echo -e "\n${BLUE}3. Testando acesso COM Token (Esperado: 200 OK)...${NC}"
RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Accept: application/json" \
  http://localhost:8000/api/transactions)

if [ "$RESPONSE_CODE" -eq 200 ]; then
    echo -e "${GREEN}[SUCESSO] Autenticação Sanctum funcionando perfeitamente!${NC}"
else
    echo -e "${RED}[ERRO] O token foi recusado pela API. (Status $RESPONSE_CODE)${NC}"
fi

echo -e "\n${BLUE}=== FIM DO TESTE DE SEGURANÇA ===${NC}"
