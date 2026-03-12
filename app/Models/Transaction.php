<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'status',
        'amount',
        'client_name',
        'client_email',
        'gateway',
        'card_last_numbers'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'transaction_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
