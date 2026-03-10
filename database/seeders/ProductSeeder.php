<?php
namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    public function run(): void {
        Product::updateOrCreate(['name' => 'Curso de Laravel Pro'], ['price' => 9700]);
        Product::updateOrCreate(['name' => 'Assinatura Mensal BeTalent'], ['price' => 4990]);
        Product::updateOrCreate(['name' => 'Taxa de Adesao'], ['price' => 1500]);
    }
}
