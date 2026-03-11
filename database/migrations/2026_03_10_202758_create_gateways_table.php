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
