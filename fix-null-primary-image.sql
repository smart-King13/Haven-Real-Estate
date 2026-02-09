-- Fix NULL primary image and set correct primary
-- Run this in Supabase SQL Editor

-- Step 1: Delete the NULL image record
DELETE FROM property_images WHERE id = 31 AND image_path IS NULL;

-- Step 2: Set the first valid image as primary for property 14
UPDATE property_images 
SET is_primary = false 
WHERE property_id = 14;

UPDATE property_images 
SET is_primary = true 
WHERE id = (
    SELECT id FROM property_images 
    WHERE property_id = 14 AND image_path IS NOT NULL
    ORDER BY sort_order ASC 
    LIMIT 1
);

-- Step 3: Verify the fix
SELECT 
    id,
    property_id,
    image_path,
    is_primary,
    sort_order
FROM property_images 
WHERE property_id = 14
ORDER BY is_primary DESC, sort_order ASC;
