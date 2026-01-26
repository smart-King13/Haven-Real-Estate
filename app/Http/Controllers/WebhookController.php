<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayService $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Handle Stripe webhooks
     */
    public function stripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event['type']) {
            case 'checkout.session.completed':
                $session = $event['data']['object'];
                $this->handleStripePaymentSuccess($session);
                break;
            
            case 'checkout.session.expired':
                $session = $event['data']['object'];
                $this->handleStripePaymentExpired($session);
                break;

            default:
                Log::info('Unhandled Stripe event type: ' . $event['type']);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Handle Paystack webhooks
     */
    public function paystack(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Paystack-Signature');
        $computedSignature = hash_hmac('sha512', $payload, config('services.paystack.webhook_secret'));

        if (!hash_equals($signature, $computedSignature)) {
            Log::error('Paystack webhook signature verification failed');
            return response('Invalid signature', 400);
        }

        $event = json_decode($payload, true);

        // Handle the event
        switch ($event['event']) {
            case 'charge.success':
                $this->handlePaystackPaymentSuccess($event['data']);
                break;
            
            case 'charge.failed':
                $this->handlePaystackPaymentFailed($event['data']);
                break;

            default:
                Log::info('Unhandled Paystack event type: ' . $event['event']);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Handle successful Stripe payment
     */
    private function handleStripePaymentSuccess($session)
    {
        $paymentId = $session['metadata']['payment_id'] ?? null;
        
        if (!$paymentId) {
            Log::error('No payment ID found in Stripe session metadata');
            return;
        }

        $payment = Payment::find($paymentId);
        
        if (!$payment) {
            Log::error('Payment not found for Stripe session: ' . $session['id']);
            return;
        }

        if ($payment->status !== 'completed') {
            $verified = $this->paymentGateway->verifyPayment($payment, 'stripe', [
                'session_id' => $session['id']
            ]);

            if ($verified) {
                $this->updatePropertyStatus($payment);
                Log::info('Stripe payment completed via webhook: ' . $payment->transaction_id);
            }
        }
    }

    /**
     * Handle expired Stripe payment
     */
    private function handleStripePaymentExpired($session)
    {
        $paymentId = $session['metadata']['payment_id'] ?? null;
        
        if ($paymentId) {
            $payment = Payment::find($paymentId);
            if ($payment && $payment->status === 'pending') {
                $payment->update(['status' => 'cancelled']);
                Log::info('Stripe payment expired: ' . $payment->transaction_id);
            }
        }
    }

    /**
     * Handle successful Paystack payment
     */
    private function handlePaystackPaymentSuccess($data)
    {
        $reference = $data['reference'] ?? null;
        
        if (!$reference) {
            Log::error('No reference found in Paystack webhook data');
            return;
        }

        $payment = Payment::where('payment_gateway_id', $reference)->first();
        
        if (!$payment) {
            Log::error('Payment not found for Paystack reference: ' . $reference);
            return;
        }

        if ($payment->status !== 'completed') {
            $verified = $this->paymentGateway->verifyPayment($payment, 'paystack', [
                'reference' => $reference
            ]);

            if ($verified) {
                $this->updatePropertyStatus($payment);
                Log::info('Paystack payment completed via webhook: ' . $payment->transaction_id);
            }
        }
    }

    /**
     * Handle failed Paystack payment
     */
    private function handlePaystackPaymentFailed($data)
    {
        $reference = $data['reference'] ?? null;
        
        if ($reference) {
            $payment = Payment::where('payment_gateway_id', $reference)->first();
            if ($payment && $payment->status === 'pending') {
                $payment->update(['status' => 'failed']);
                Log::info('Paystack payment failed: ' . $payment->transaction_id);
            }
        }
    }

    /**
     * Update property status after successful payment
     */
    private function updatePropertyStatus($payment)
    {
        $property = $payment->property;
        
        switch ($payment->type) {
            case 'purchase':
                $property->update(['status' => \App\Models\Property::STATUS_SOLD]);
                break;
            case 'rent_payment':
                $property->update(['status' => \App\Models\Property::STATUS_RENTED]);
                break;
            case 'deposit':
                $property->update(['status' => \App\Models\Property::STATUS_PENDING]);
                break;
            // inspection_fee doesn't change property status
        }
    }
}