<?php

namespace App\Services;

// use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Yabacon\Paystack;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentGatewayService
{
    /**
     * Process payment through the selected gateway
     */
    public function processPayment($payment, string $gateway)
    {
        switch ($gateway) {
            case 'stripe':
                return $this->processStripePayment($payment);
            case 'paystack':
                return $this->processPaystackPayment($payment);
            default:
                throw new Exception("Unsupported payment gateway: {$gateway}");
        }
    }

    /**
     * Process Stripe payment
     */
    private function processStripePayment($payment)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($payment->currency),
                        'product_data' => [
                            'name' => $payment->description,
                            'description' => "Transaction ID: {$payment->transaction_id}",
                        ],
                        'unit_amount' => $payment->amount * 100, // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payments.success', ['id' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('properties.show', ['id' => $payment->property_id]) . '?payment_cancelled=1',
                'metadata' => [
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'property_id' => $payment->property_id,
                ],
            ]);

            // Update payment with Stripe session ID
            $payment->update([
                'payment_gateway_id' => $session->id,
                'gateway_response' => [
                    'gateway' => 'stripe',
                    'session_id' => $session->id,
                    'checkout_url' => $session->url,
                    'created_at' => now()->toISOString(),
                ]
            ]);

            return [
                'success' => true,
                'redirect_url' => $session->url,
                'gateway' => 'stripe',
                'session_id' => $session->id,
            ];

        } catch (Exception $e) {
            Log::error('Stripe payment error: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Payment processing failed. Please try again.',
                'gateway' => 'stripe',
            ];
        }
    }

    /**
     * Process Paystack payment
     */
    private function processPaystackPayment($payment)
    {
        try {
            $paystack = new Paystack(config('services.paystack.secret'));

            // Convert USD to NGN for PayStack
            $currencyService = new \App\Services\CurrencyConversionService();
            $conversion = $currencyService->convertUsdToNgn($payment->amount);
            
            $ngnAmount = $conversion['converted_amount'];
            $exchangeRate = $conversion['exchange_rate'];

            // PayStack test mode has transaction limits - use smaller amount for testing
            if (config('app.env') !== 'production') {
                // In test mode, limit to ₦2,500 (PayStack's test limit)
                if ($ngnAmount > 2500) {
                    $ngnAmount = 2500; // Use test limit
                    $conversion['test_mode_amount'] = true;
                    $conversion['test_amount_ngn'] = 2500;
                }
            }

            $tranx = $paystack->transaction->initialize([
                'amount' => $ngnAmount * 100, // Paystack uses kobo (cents)
                'currency' => 'NGN', // PayStack processes in Nigerian Naira
                'email' => $payment->user->email,
                'reference' => $payment->transaction_id,
                'callback_url' => route('payments.success', ['id' => $payment->id]),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'property_id' => $payment->property_id,
                    'transaction_type' => $payment->type,
                    'original_amount_usd' => $payment->amount,
                    'converted_amount_ngn' => $conversion['converted_amount'],
                    'processed_amount_ngn' => $ngnAmount,
                    'exchange_rate' => $exchangeRate,
                    'test_mode' => config('app.env') !== 'production',
                ],
                'channels' => ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer'],
            ]);

            if ($tranx->status) {
                // Update payment with Paystack reference and conversion info
                $payment->update([
                    'payment_gateway_id' => $tranx->data->reference,
                    'gateway_response' => [
                        'gateway' => 'paystack',
                        'reference' => $tranx->data->reference,
                        'authorization_url' => $tranx->data->authorization_url,
                        'access_code' => $tranx->data->access_code,
                        'currency_conversion' => $conversion,
                        'processed_amount_ngn' => $ngnAmount,
                        'created_at' => now()->toISOString(),
                    ]
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $tranx->data->authorization_url,
                    'gateway' => 'paystack',
                    'reference' => $tranx->data->reference,
                    'currency_info' => [
                        'original_amount' => $payment->amount,
                        'original_currency' => 'USD',
                        'paystack_amount' => $ngnAmount,
                        'paystack_currency' => 'NGN',
                        'exchange_rate' => $exchangeRate,
                        'test_mode_limit' => config('app.env') !== 'production' && $conversion['converted_amount'] > 2500,
                    ]
                ];
            } else {
                throw new Exception($tranx->message ?? 'Paystack initialization failed');
            }

        } catch (Exception $e) {
            Log::error('Paystack payment error: ' . $e->getMessage(), [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Payment processing failed. Please try again.',
                'gateway' => 'paystack',
            ];
        }
    }

    /**
     * Verify payment from webhook or callback
     */
    public function verifyPayment($payment, string $gateway, array $data = [])
    {
        switch ($gateway) {
            case 'stripe':
                return $this->verifyStripePayment($payment, $data);
            case 'paystack':
                return $this->verifyPaystackPayment($payment, $data);
            default:
                return false;
        }
    }

    /**
     * Verify Stripe payment
     */
    private function verifyStripePayment($payment, array $data)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $sessionId = $data['session_id'] ?? $payment->payment_gateway_id;
            $session = StripeSession::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'gateway_response' => array_merge($payment->gateway_response ?? [], [
                        'verified_at' => now()->toISOString(),
                        'payment_intent' => $session->payment_intent,
                        'payment_status' => $session->payment_status,
                    ])
                ]);

                return true;
            }

            return false;

        } catch (Exception $e) {
            Log::error('Stripe verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify Paystack payment
     */
    private function verifyPaystackPayment($payment, array $data)
    {
        try {
            $paystack = new Paystack(config('services.paystack.secret'));
            
            $reference = $data['reference'] ?? $payment->payment_gateway_id;
            $tranx = $paystack->transaction->verify(['reference' => $reference]);

            if ($tranx->status && $tranx->data->status === 'success') {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'gateway_response' => array_merge($payment->gateway_response ?? [], [
                        'verified_at' => now()->toISOString(),
                        'gateway_response' => $tranx->data,
                        'amount_paid' => $tranx->data->amount / 100,
                    ])
                ]);

                return true;
            }

            return false;

        } catch (Exception $e) {
            Log::error('Paystack verification error: ' . $e->getMessage());
            return false;
        }
    }
}