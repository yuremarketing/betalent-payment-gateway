<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
| Eu defini esta rota como POST, seguindo o padrão REST para criação de recursos.
| Usei '::class' para que o Laravel consiga localizar o controlador corretamente.
*/
Route::post('/payments', [PaymentController::class, 'store']);

/*
|criei o endpoint de listagem de transações para iniciar o Card 5
|implementei a rota de listagem e o método index com paginação
*/
Route::get('/transactions', [App\Http\Controllers\PaymentController::class, 'index']);

