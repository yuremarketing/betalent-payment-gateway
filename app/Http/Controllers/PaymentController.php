<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payments\PaymentService;
use App\Models\Transaction;
use App\Models\Gateway;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller {
    
    protected $paymentService;

    public function __construct(PaymentService $paymentService) {
        $this->paymentService = $paymentService;
    }

    public function index() {
        // O with(['gateway', 'product']) carrega os dados relacionados de uma vez só!
        $transactions = Transaction::with(['gateway', 'product'])
            ->latest()
            ->paginate(10);
            
        return response()->json($transactions);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer',
            'card_number' => 'required|string',
            'idempotency_key' => 'required|string|unique:transactions,idempotency_key',
        ]);

        try {
            return DB::transaction(function () use ($data) {
                $result = $this->paymentService->processPayment($data);
                
                $gatewayObj = Gateway::where('name', $result['gateway'])->first();

                Transaction::create([
                    'product_id' => $data['product_id'],
                    'gateway_id' => $gatewayObj->id,
                    'amount' => $data['amount'],
                    'gateway_transaction_id' => (string) ($result['transaction_id'] ?? 'N/A'),
                    'idempotency_key' => $data['idempotency_key'],
                    'status' => 'paid',
                ]);

                return response()->json($result);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
