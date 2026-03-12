<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // LISTAGEM (O que estava faltando)
    public function index()
    {
        // No Nível 3, retornamos as transações com os produtos relacionados
        return response()->json(Transaction::with('products')->get());
    }

    // PAGAMENTO
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_email' => 'required|email',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'card_number' => 'required|string',
            'card_cvv' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $productData = [];

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);
                $subtotal = $product->amount * $item['quantity'];
                $totalAmount += $subtotal;
                $productData[$item['id']] = ['quantity' => $item['quantity']];
            }

            $paymentResponse = $this->paymentService->process($totalAmount, $request->all());

            $transaction = Transaction::create([
                'external_id' => $paymentResponse['id'],
                'status' => $paymentResponse['status'],
                'amount' => $totalAmount,
                'client_name' => $request->client_name,
                'client_email' => $request->client_email,
                'gateway' => $paymentResponse['gateway'],
                'card_last_numbers' => substr($request->card_number, -4),
            ]);

            $transaction->products()->attach($productData);
            return response()->json($transaction, 201);
        });
    }
}
