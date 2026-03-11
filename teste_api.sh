#!/bin/bash

BLUE='\033[0;34m'
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${BLUE}=== INICIANDO TESTE DE RESILIÊNCIA (FAILOVER) ===${NC}\n"

# 1. QUEBRANDO O GATEWAY A NO .ENV
echo -e "${BLUE}1. Simulando queda do Gateway A (Alterando .env)...${NC}"
sed -i 's/GATEWAY_A_URL=.*/GATEWAY_A_URL=http:\/\/site-que-nao-existe:3001\/pay/' .env

# 2. LIMPANDO O CACHE PARA O LARAVEL PERCEBER A QUEDA
echo -e "2. Limpando cache de configuração..."
docker exec -it betalent-app php artisan config:clear > /dev/null

# 3. DISPARANDO VENDA QUE DEVE CAIR NO GATEWAY B
echo -e "${BLUE}3. Disparando venda (O sistema deve pular para o B)...${NC}"
RESPONSE=$(curl -s --request POST \
  --url http://localhost:8000/api/payments \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data '{
    "product_id": 1,
    "amount": 999,
    "card_number": "9999 8888 7777 6666",
    "idempotency_key": "teste-failover-'$RANDOM'"
}')

echo -e "Resposta da API: $RESPONSE"

# 4. VALIDANDO SE O GATEWAY B FOI USADO
if echo "$RESPONSE" | grep -q "Gateway B"; then
    echo -e "\n${GREEN}[SUCESSO] O Failover funcionou! O Gateway B salvou a pátria.${NC}"
else
    echo -e "\n${RED}[ERRO] O sistema não migrou para o Gateway B.${NC}"
fi

# 5. RESTAURANDO O AMBIENTE
echo -e "\n${BLUE}5. Restaurando Gateway A para o estado normal...${NC}"
sed -i 's/GATEWAY_A_URL=.*/GATEWAY_A_URL=http:\/\/betalent-mocks:3001\/pay/' .env
docker exec -it betalent-app php artisan config:clear > /dev/null

echo -e "\n${BLUE}=== FIM DO TESTE DE FAILOVER ===${NC}"
