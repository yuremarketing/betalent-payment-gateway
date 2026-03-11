<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
| Eu defini esta rota como POST, seguindo o padrão REST para criação de recursos.
| Usei '::class' para que o Laravel consiga localizar o controlador corretamente.
*/
Route::post('/payments', [PaymentController::class, 'store']);
