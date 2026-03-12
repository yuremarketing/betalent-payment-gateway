<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Rota de Pagamento (Nível 3 - checkout)
    Route::post('/payments', [PaymentController::class, 'store']);

    // Rota de Listagem (Protegida pelo middleware 'admin')
    Route::get('/transactions', [PaymentController::class, 'index'])->middleware('admin');
});
