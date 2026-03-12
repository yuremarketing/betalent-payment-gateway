<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['id' => 1, 'name' => 'Curso de Laravel Pro', 'amount' => 15000],
            ['id' => 2, 'name' => 'Mentoria VIP', 'amount' => 50000],
            ['id' => 3, 'name' => 'Ebook de PHP Sênior', 'amount' => 4990],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['id' => $product['id']], $product);
        }
    }
}
