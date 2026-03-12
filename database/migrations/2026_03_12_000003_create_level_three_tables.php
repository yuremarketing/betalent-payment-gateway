<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de Transações consolidada
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->string('status');
            $table->integer('amount');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('gateway');
            $table->string('card_last_numbers');
            $table->timestamps();
        });

        // Tabela Pivot para múltiplos produtos
        Schema::create('transaction_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_products');
        Schema::dropIfExists('transactions');
    }
};
