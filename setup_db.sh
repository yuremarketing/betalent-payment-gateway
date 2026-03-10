#!/bin/bash

# Cores para o terminal (Pra ficar "bonitinho" como você pediu)
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🚀 Iniciando a configuração da Camada de Dados...${NC}"

# 1. Localizando os arquivos (para não errar o timestamp)
GATEWAY_MIG=$(ls database/migrations/*create_gateways_table.php)
PRODUCT_MIG=$(ls database/migrations/*create_products_table.php)
TRANS_MIG=$(ls database/migrations/*create_transactions_table.php)

echo -e "${GREEN}📝 Escrevendo Migration de Gateways...${NC}"
cat << 'EOF' > $GATEWAY_MIG
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome (Gateway A/B)
            $table->string('api_url'); // URL do Mock
            $table->integer('priority')->default(1); // Para lógica de failover
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('gateways'); }
};
EOF

echo -e "${GREEN}📝 Escrevendo Migration de Produtos...${NC}"
cat << 'EOF' > $PRODUCT_MIG
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('price'); // Preço em centavos para precisão
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
EOF

echo -e "${GREEN}📝 Escrevendo Migration de Transações...${NC}"
cat << 'EOF' > $TRANS_MIG
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('gateway_id')->constrained();
            $table->bigInteger('amount');
            $table->string('status'); // pending, paid, failed
            $table->string('external_id')->nullable();
            $table->string('idempotency_key')->unique(); // Proteção contra duplicidade
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transactions'); }
};
EOF

echo -e "${BLUE}⚙️  Resetando o banco e rodando Migrations/Seeds no Docker...${NC}"
docker exec -it betalent-app php artisan migrate:fresh --seed

echo -e "${BLUE}✅ Processo finalizado! Card 3 pronto para revisão.${NC}"
