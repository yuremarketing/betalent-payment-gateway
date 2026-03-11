<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = 
    [
        'product_id', 
        'amount', 
        'gateway', 
        'gateway_transaction_id', 
        'idempotency_key', 
        'status'
    ];
}
