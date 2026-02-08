-- =====================================================
-- UPDATE CURRENCY FROM USD TO NGN (NAIRA)
-- =====================================================
-- Run this in Supabase SQL Editor to update existing data
-- =====================================================

-- Update default currency in payments table
ALTER TABLE public.payments 
ALTER COLUMN currency SET DEFAULT 'NGN';

-- Update existing payment records to NGN
UPDATE public.payments 
SET currency = 'NGN' 
WHERE currency = 'USD' OR currency IS NULL;

-- Note: You may want to convert the amounts based on exchange rate
-- Current rate: 1 USD ≈ 1,500 NGN (adjust as needed)
-- Uncomment the line below if you want to convert amounts:
-- UPDATE public.payments SET amount = amount * 1500 WHERE currency = 'NGN';

-- Verify the update
SELECT id, amount, currency, status, created_at 
FROM public.payments 
LIMIT 10;
