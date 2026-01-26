<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Get user's payment history
     */
    public function index(Request $request)
    {
        $payments = Payment::with(['property:id,title,price,type', 'user:id,name,email'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    /**
     * Get all payments (Admin only)
     */
    public function adminIndex(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $query = Payment::with(['property:id,title,price,type', 'user:id,name,email']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    /**
     * Initiate a payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'payment_method' => 'required|in:stripe,paystack,paypal',
            'type' => 'required|in:purchase,rent_payment,deposit,commission',
            'description' => 'nullable|string',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Check if property is available
        if ($property->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Property is not available for payment.',
            ], 400);
        }

        // Create payment record
        $payment = Payment::create([
            'user_id' => $request->user()->id,
            'property_id' => $request->property_id,
            'transaction_id' => 'TXN_' . Str::upper(Str::random(12)),
            'payment_method' => $request->payment_method,
            'amount' => $property->price,
            'currency' => 'USD',
            'status' => 'pending',
            'type' => $request->type,
            'description' => $request->description,
        ]);

        // Here you would integrate with actual payment gateways
        // For now, we'll return the payment details for frontend processing
        $paymentData = [
            'payment_id' => $payment->id,
            'transaction_id' => $payment->transaction_id,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'payment_method' => $payment->payment_method,
        ];

        // Add gateway-specific data
        switch ($request->payment_method) {
            case 'stripe':
                $paymentData['client_secret'] = $this->createStripePaymentIntent($payment);
                break;
            case 'paystack':
                $paymentData['authorization_url'] = $this->createPaystackPayment($payment);
                break;
            case 'paypal':
                $paymentData['approval_url'] = $this->createPayPalPayment($payment);
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated successfully',
            'data' => $paymentData,
        ], 201);
    }

    /**
     * Show payment details
     */
    public function show(Request $request, $id)
    {
        $payment = Payment::with(['property:id,title,price,type', 'user:id,name,email'])
            ->findOrFail($id);

        // Users can only view their own payments, admins can view all
        if (!$request->user()->isAdmin() && $payment->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this payment.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    /**
     * Verify payment status (webhook endpoint)
     */
    public function verify(Request $request, $transactionId)
    {
        $payment = Payment::where('transaction_id', $transactionId)->firstOrFail();

        $request->validate([
            'payment_gateway_id' => 'required|string|max:255',
            'status' => 'required|in:completed,failed,cancelled',
            'gateway_response' => 'nullable|array',
        ]);

        // Prevent duplicate processing
        if ($payment->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed',
            ], 400);
        }

        // Log the webhook for audit purposes
        \Log::info('Payment webhook received', [
            'transaction_id' => $transactionId,
            'status' => $request->status,
            'gateway_id' => $request->payment_gateway_id,
            'ip' => $request->ip(),
        ]);

        $payment->update([
            'payment_gateway_id' => $request->payment_gateway_id,
            'status' => $request->status,
            'gateway_response' => $request->gateway_response,
            'paid_at' => $request->status === 'completed' ? now() : null,
        ]);

        // Update property status if payment is completed
        if ($request->status === 'completed') {
            $this->updatePropertyStatus($payment);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully',
            'data' => $payment->only(['id', 'status', 'paid_at']),
        ]);
    }

    /**
     * Get payment statistics (Admin only)
     */
    public function statistics(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $stats = [
            'total_payments' => Payment::count(),
            'completed_payments' => Payment::completed()->count(),
            'pending_payments' => Payment::pending()->count(),
            'total_revenue' => Payment::completed()->sum('amount'),
            'monthly_revenue' => Payment::completed()
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
            'payment_methods' => Payment::completed()
                ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('payment_method')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Create Stripe Payment Intent (placeholder)
     */
    private function createStripePaymentIntent($payment)
    {
        // This is a placeholder - implement actual Stripe integration
        return 'pi_' . Str::random(24);
    }

    /**
     * Create Paystack Payment (placeholder)
     */
    private function createPaystackPayment($payment)
    {
        // This is a placeholder - implement actual Paystack integration
        return 'https://checkout.paystack.com/' . Str::random(16);
    }

    /**
     * Create PayPal Payment (placeholder)
     */
    private function createPayPalPayment($payment)
    {
        // This is a placeholder - implement actual PayPal integration
        return 'https://www.paypal.com/checkoutnow?token=' . Str::random(16);
    }

    /**
     * Update property status after successful payment
     */
    private function updatePropertyStatus($payment)
    {
        $property = $payment->property;
        
        switch ($payment->type) {
            case 'purchase':
                $property->update(['status' => 'sold']);
                break;
            case 'rent_payment':
                $property->update(['status' => 'rented']);
                break;
            case 'deposit':
                $property->update(['status' => 'pending']);
                break;
        }
    }
}