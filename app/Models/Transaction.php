<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = [
        'product_id', 
        'gateway_id', 
        'amount', 
        'gateway_transaction_id', 
        'idempotency_key', 
        'status'
    ];

    // Isso cria o link entre a transação e o gateway
    public function gateway() {
        return $this->belongsTo(Gateway::class);
    }

    // Link opcional com o produto, se quiser mostrar o nome do produto também
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
