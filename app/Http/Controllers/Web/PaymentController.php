<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Payment;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayService $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Display checkout page for a property
     */
    public function checkout(Property $property)
    {
        $property->load(['category', 'primaryImage', 'user']);

        if (!$property->is_active || !in_array($property->status, [Property::STATUS_AVAILABLE, Property::STATUS_PUBLISHED])) {
            return redirect()->route('properties.show', $property->slug)->with('error', 'This property is no longer available for transaction.');
        }

        // Calculate fees based on property type and price
        $basePrice = $property->price;
        $acquisitionFee = $property->type === 'sale' ? 1250 : 250; // Higher fee for purchases
        $legalFee = $property->type === 'sale' ? 450 : 150; // Legal fees
        $totalAmount = $basePrice + $acquisitionFee + $legalFee;

        return view('payments.checkout', compact('property', 'basePrice', 'acquisitionFee', 'legalFee', 'totalAmount'));
    }

    /**
     * Process a payment transaction
     */
    public function process(Request $request, Property $property)
    {
        $request->validate([
            'payment_method' => 'required|in:stripe,paystack',
            'transaction_type' => 'required|in:purchase,rent_payment,deposit,inspection_fee',
        ]);

        // Calculate amount based on transaction type
        $amount = $this->calculateAmount($property, $request->transaction_type);

        // Create a pending payment
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'property_id' => $property->id,
            'transaction_id' => 'TXN_' . Str::upper(Str::random(12)),
            'payment_method' => $request->payment_method,
            'amount' => $amount,
            'currency' => 'USD',
            'status' => 'pending',
            'type' => $request->transaction_type,
            'description' => $this->getTransactionDescription($property, $request->transaction_type),
        ]);

        // Process payment through the selected gateway
        $result = $this->paymentGateway->processPayment($payment, $request->payment_method);

        if ($result['success']) {
            // Redirect to payment gateway
            return redirect($result['redirect_url']);
        } else {
            // Payment processing failed
            $payment->update(['status' => 'failed']);
            
            return redirect()->route('properties.show', $id)
                ->with('error', $result['error'] ?? 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Calculate amount based on transaction type
     */
    private function calculateAmount($property, $transactionType)
    {
        switch ($transactionType) {
            case 'purchase':
                return $property->price + 1250 + 450; // Base + acquisition + legal fees
            case 'rent_payment':
                return $property->price + 250 + 150; // Base + fees
            case 'deposit':
                return $property->price * 0.1; // 10% deposit
            case 'inspection_fee':
                return 500; // Fixed inspection fee
            default:
                return $property->price;
        }
    }

    /**
     * Get transaction description
     */
    private function getTransactionDescription($property, $transactionType)
    {
        $descriptions = [
            'purchase' => 'Full purchase of property: ',
            'rent_payment' => 'Rental payment for property: ',
            'deposit' => 'Security deposit for property: ',
            'inspection_fee' => 'Inspection fee for property: ',
        ];

        return ($descriptions[$transactionType] ?? 'Payment for property: ') . $property->title;
    }

    /**
     * Handle payment success callback
     */
    public function success(Request $request, $id)
    {
        $payment = Payment::with(['property'])->findOrFail($id);

        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        // Verify payment if not already completed
        if ($payment->status === 'pending') {
            $gatewayData = [];
            
            // Collect gateway-specific data
            if ($payment->payment_method === 'stripe' && $request->has('session_id')) {
                $gatewayData['session_id'] = $request->session_id;
            } elseif ($payment->payment_method === 'paystack' && $request->has('reference')) {
                $gatewayData['reference'] = $request->reference;
            } elseif ($payment->payment_method === 'paypal' && $request->has('paymentId')) {
                $gatewayData['paymentId'] = $request->paymentId;
                $gatewayData['PayerID'] = $request->PayerID;
            }

            // Verify the payment
            $verified = $this->paymentGateway->verifyPayment($payment, $payment->payment_method, $gatewayData);
            
            if ($verified) {
                // Update property status after successful payment
                $this->updatePropertyStatus($payment);
            } else {
                // Payment verification failed
                $payment->update(['status' => 'failed']);
                
                return redirect()->route('properties.show', $payment->property_id)
                    ->with('error', 'Payment verification failed. Please contact support if you were charged.');
            }
        }

        return view('payments.success', compact('payment'));
    }

    /**
     * Update property status after payment
     */
    private function updatePropertyStatus($payment)
    {
        $property = $payment->property;
        
        switch ($payment->type) {
            case 'purchase':
                $property->update(['status' => Property::STATUS_SOLD]);
                break;
            case 'rent_payment':
                $property->update(['status' => Property::STATUS_RENTED]);
                break;
            case 'deposit':
                $property->update(['status' => Property::STATUS_PENDING]);
                break;
            // inspection_fee doesn't change property status
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        // Update payment status to cancelled
        $payment->update(['status' => 'cancelled']);

        return redirect()->route('properties.show', $payment->property_id)
            ->with('warning', 'Payment was cancelled. You can try again anytime.');
    }
}
