<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('X-Webhook-Signature');
        $payload = $request->getContent();
        
        if (!$signature) {
            return response()->json([
                'success' => false,
                'message' => 'Missing webhook signature',
            ], 401);
        }

        // Verify signature based on payment method
        $transactionId = $request->route('transactionId');
        $payment = \App\Models\Payment::where('transaction_id', $transactionId)->first();
        
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 404);
        }

        $isValid = $this->verifySignature($payment->payment_method, $signature, $payload);
        
        if (!$isValid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook signature',
            ], 401);
        }

        return $next($request);
    }

    /**
     * Verify webhook signature based on payment gateway
     */
    private function verifySignature(string $paymentMethod, string $signature, string $payload): bool
    {
        switch ($paymentMethod) {
            case 'stripe':
                return $this->verifyStripeSignature($signature, $payload);
            case 'paystack':
                return $this->verifyPaystackSignature($signature, $payload);
            case 'paypal':
                return $this->verifyPayPalSignature($signature, $payload);
            default:
                return false;
        }
    }

    private function verifyStripeSignature(string $signature, string $payload): bool
    {
        $secret = config('services.stripe.webhook_secret');
        if (!$secret) return false;
        
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($signature, $expectedSignature);
    }

    private function verifyPaystackSignature(string $signature, string $payload): bool
    {
        $secret = config('services.paystack.webhook_secret');
        if (!$secret) return false;
        
        $expectedSignature = hash_hmac('sha512', $payload, $secret);
        return hash_equals($signature, $expectedSignature);
    }

    private function verifyPayPalSignature(string $signature, string $payload): bool
    {
        // PayPal uses different verification method
        // This is a simplified version - implement proper PayPal webhook verification
        $secret = config('services.paypal.webhook_secret');
        if (!$secret) return false;
        
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($signature, $expectedSignature);
    }
}