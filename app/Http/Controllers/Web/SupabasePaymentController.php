<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SupabasePaymentController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Show checkout page
     */
    public function checkout(Request $request, $propertyId)
    {
        try {
            $user = supabase_user();

            // Get property
            $property = $this->supabase->findOne('properties', ['id' => $propertyId]);

            if (!$property) {
                abort(404, 'Property not found');
            }

            // Get property images
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $property->id
            ], ['limit' => 1]);
            $property->images = $imagesResponse->data ?? [];

            $paymentType = $request->get('type', 'purchase');
            $amount = $property->price;

            // Adjust amount based on payment type
            if ($paymentType === 'deposit') {
                $amount = $property->price * 0.1; // 10% deposit
            } elseif ($paymentType === 'inspection_fee') {
                $amount = 50; // Fixed inspection fee
            }

            return view('payments.checkout', compact('property', 'paymentType', 'amount'));

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load checkout page');
        }
    }

    /**
     * Process payment
     */
    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:stripe,paystack',
            'payment_type' => 'required|in:purchase,rent_payment,deposit,commission,inspection_fee',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = supabase_user();

            // Generate unique transaction ID
            $transactionId = 'TXN-' . strtoupper(Str::random(12)) . '-' . time();

            // Create payment record
            $paymentData = [
                'user_id' => $user->id,
                'property_id' => $request->property_id,
                'transaction_id' => $transactionId,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'currency' => $request->currency ?? 'USD',
                'status' => 'pending',
                'type' => $request->payment_type,
                'description' => $request->description ?? 'Property payment',
            ];

            $response = $this->supabase->insert('payments', $paymentData);
            $payment = $response->data[0] ?? null;

            if (!$payment) {
                throw new \Exception('Failed to create payment record');
            }

            // Here you would integrate with actual payment gateway
            // For now, we'll simulate a successful payment
            
            // Redirect to payment gateway or success page
            return redirect()->route('payments.success', ['transaction_id' => $transactionId])
                ->with('success', 'Payment initiated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Payment success page
     */
    public function success(Request $request)
    {
        try {
            $transactionId = $request->get('transaction_id');

            if (!$transactionId) {
                return redirect()->route('home')->with('error', 'Invalid payment reference');
            }

            // Get payment
            $payment = $this->supabase->findOne('payments', ['transaction_id' => $transactionId]);

            if (!$payment) {
                return redirect()->route('home')->with('error', 'Payment not found');
            }

            // Get property
            $property = $this->supabase->findOne('properties', ['id' => $payment->property_id]);

            return view('payments.success', compact('payment', 'property'));

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to load payment details');
        }
    }

    /**
     * User payment history
     */
    public function history(Request $request)
    {
        try {
            $user = supabase_user();

            // Get user payments
            $paymentsResponse = $this->supabase->select('payments', '*', [
                'user_id' => $user->id
            ], ['order' => ['column' => 'created_at', 'ascending' => false]]);

            $payments = $paymentsResponse->data ?? [];

            // Get property details for each payment
            foreach ($payments as &$payment) {
                $property = $this->supabase->findOne('properties', ['id' => $payment->property_id]);
                $payment->property = $property;
            }

            return view('user.payment-history', compact('payments'));

        } catch (\Exception $e) {
            return view('user.payment-history', [
                'payments' => [],
                'error' => 'Failed to load payment history'
            ]);
        }
    }

    /**
     * Admin: View all payments
     */
    public function adminIndex(Request $request)
    {
        try {
            // Get all payments
            $paymentsResponse = $this->supabase->select('payments', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 50
            ]);

            $payments = $paymentsResponse->data ?? [];

            // Get related data
            foreach ($payments as &$payment) {
                $property = $this->supabase->findOne('properties', ['id' => $payment->property_id]);
                $user = $this->supabase->getUserProfile($payment->user_id);
                
                $payment->property = $property;
                $payment->user = $user;
            }

            // Calculate statistics
            $stats = [
                'total_revenue' => 0,
                'completed_payments' => 0,
                'pending_payments' => 0,
                'failed_payments' => 0,
            ];

            foreach ($payments as $payment) {
                if ($payment->status === 'completed') {
                    $stats['total_revenue'] += $payment->amount;
                    $stats['completed_payments']++;
                } elseif ($payment->status === 'pending') {
                    $stats['pending_payments']++;
                } elseif ($payment->status === 'failed') {
                    $stats['failed_payments']++;
                }
            }

            return view('admin.payments.index', compact('payments', 'stats'));

        } catch (\Exception $e) {
            return view('admin.payments.index', [
                'payments' => [],
                'stats' => [],
                'error' => 'Failed to load payments'
            ]);
        }
    }

    /**
     * Admin: Update payment status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,completed,failed,cancelled,refunded',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $updateData = ['status' => $request->status];

            if ($request->status === 'completed') {
                $updateData['paid_at'] = now()->toIso8601String();
            }

            $this->supabase->update('payments', $updateData, ['id' => $id]);

            return back()->with('success', 'Payment status updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update payment status');
        }
    }

    /**
     * Webhook handler for payment gateways
     */
    public function webhook(Request $request, $gateway)
    {
        try {
            // Verify webhook signature based on gateway
            if ($gateway === 'stripe') {
                // Handle Stripe webhook
                $payload = $request->getContent();
                $signature = $request->header('Stripe-Signature');
                
                // Verify and process Stripe webhook
                // Update payment status in Supabase
                
            } elseif ($gateway === 'paystack') {
                // Handle Paystack webhook
                $payload = $request->getContent();
                $signature = $request->header('X-Paystack-Signature');
                
                // Verify and process Paystack webhook
                // Update payment status in Supabase
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 400);
        }
    }
}
