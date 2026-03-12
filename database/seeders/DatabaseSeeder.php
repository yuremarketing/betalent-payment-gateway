<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cria os Produtos (Passo que já ajustamos)
        $this->call(ProductSeeder::class);

        // 2. Ator: USUÁRIO COMUM (Pode pagar, mas não pode listar)
        User::updateOrCreate(
            ['email' => 'user@betalent.com'],
            [
                'name' => 'Yure Comum',
                'password' => Hash::make('password123'),
                'role' => 'user'
            ]
        );

        // 3. Ator: ADMINISTRADOR (Pode pagar e PODE LISTAR TUDO)
        User::updateOrCreate(
            ['email' => 'admin@betalent.com'],
            [
                'name' => 'Yure Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );
    }
}
