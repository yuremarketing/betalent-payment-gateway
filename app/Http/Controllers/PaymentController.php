<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\Payments\PaymentService;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller {
    protected $paymentService;
    public function __construct(PaymentService $paymentService) {
        $this->paymentService = $paymentService;
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
                
                Transaction::create([
                    'product_id' => $data['product_id'],
                    'amount' => $data['amount'],
                    'gateway' => $result['gateway'] ?? 'Gateway A',
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
