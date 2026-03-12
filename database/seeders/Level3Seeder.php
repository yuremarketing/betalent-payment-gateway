<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class Level3Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Criando Usuários para cada Role
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@betalent.com',
                'password' => Hash::make('password123'),
                'role' => 'ADMIN',
            ],
            [
                'name' => 'Finance Manager',
                'email' => 'finance@betalent.com',
                'password' => Hash::make('password123'),
                'role' => 'FINANCE',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@betalent.com',
                'password' => Hash::make('password123'),
                'role' => 'USER',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

        // 2. Criando Produtos de Teste
        $products = [
            ['name' => 'Curso de Laravel Sênior', 'amount' => 15000], // R$ 150,00
            ['name' => 'Mentoria Docker', 'amount' => 25000],        // R$ 250,00
            ['name' => 'Ebook Patterns', 'amount' => 4990],         // R$ 49,90
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
