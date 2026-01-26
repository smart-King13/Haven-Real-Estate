<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyConversionService
{
    /**
     * Convert USD to NGN (Nigerian Naira) for PayStack payments
     */
    public function convertUsdToNgn(float $usdAmount): array
    {
        try {
            // Get exchange rate (cached for 1 hour)
            $exchangeRate = Cache::remember('usd_to_ngn_rate', 3600, function () {
                return $this->getExchangeRate();
            });

            $ngnAmount = $usdAmount * $exchangeRate;

            return [
                'success' => true,
                'original_amount' => $usdAmount,
                'original_currency' => 'USD',
                'converted_amount' => round($ngnAmount, 2),
                'converted_currency' => 'NGN',
                'exchange_rate' => $exchangeRate,
                'rate_source' => 'exchangerate-api.com'
            ];

        } catch (\Exception $e) {
            Log::error('Currency conversion error: ' . $e->getMessage());
            
            // Fallback to approximate rate if API fails
            $fallbackRate = 1650; // Approximate USD to NGN rate
            $ngnAmount = $usdAmount * $fallbackRate;

            return [
                'success' => false,
                'original_amount' => $usdAmount,
                'original_currency' => 'USD',
                'converted_amount' => round($ngnAmount, 2),
                'converted_currency' => 'NGN',
                'exchange_rate' => $fallbackRate,
                'rate_source' => 'fallback_rate',
                'error' => 'Used fallback rate due to API error'
            ];
        }
    }

    /**
     * Get current USD to NGN exchange rate
     */
    private function getExchangeRate(): float
    {
        try {
            // Using free exchangerate-api.com service
            $response = Http::timeout(10)->get('https://api.exchangerate-api.com/v4/latest/USD');
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['rates']['NGN'] ?? 1650; // Fallback rate
            }

            // If API fails, use fallback rate
            return 1650;

        } catch (\Exception $e) {
            Log::error('Exchange rate API error: ' . $e->getMessage());
            return 1650; // Fallback rate
        }
    }

    /**
     * Get currency symbol for display
     */
    public function getCurrencySymbol(string $currency): string
    {
        $symbols = [
            'USD' => '$',
            'NGN' => '₦',
            'EUR' => '€',
            'GBP' => '£',
        ];

        return $symbols[$currency] ?? $currency;
    }

    /**
     * Format currency amount for display
     */
    public function formatCurrency(float $amount, string $currency): string
    {
        $symbol = $this->getCurrencySymbol($currency);
        
        if ($currency === 'NGN') {
            // Format Nigerian Naira with commas
            return $symbol . number_format($amount, 2);
        }

        return $symbol . number_format($amount, 2);
    }
}