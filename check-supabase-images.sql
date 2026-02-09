-- =====================================================
-- PROPERTY IMAGES DIAGNOSTIC SQL
-- Run this in your Supabase SQL Editor
-- =====================================================

-- 1. Check all RLS policies on property_images table
SELECT 
    schemaname,
    tablename,
    policyname,
    permissive,
    roles,
    cmd as command,
    qual as using_expression,
    with_check
FROM pg_policies 
WHERE tablename = 'property_images'
ORDER BY policyname;

-- 2. Count total property images
SELECT COUNT(*) as total_images FROM property_images;

-- 3. Check properties with and without images
SELECT 
    p.id,
    p.title,
    p.is_active,
    p.status,
    COUNT(pi.id) as image_count,
    MAX(CASE WHEN pi.is_primary THEN pi.image_path END) as primary_image_path
FROM properties p
LEFT JOIN property_images pi ON pi.property_id = p.id
GROUP BY p.id, p.title, p.is_active, p.status
ORDER BY p.created_at DESC
LIMIT 20;

-- 4. Check for orphaned images (images without properties)
SELECT 
    pi.id,
    pi.property_id,
    pi.image_path,
    pi.is_primary,
    CASE 
        WHEN p.id IS NULL THEN 'ORPHANED - Property deleted'
        ELSE 'OK'
    END as status
FROM property_images pi
LEFT JOIN properties p ON p.id = pi.property_id
WHERE p.id IS NULL;

-- 5. Check if any property has multiple primary images (should only have 1)
SELECT 
    property_id,
    COUNT(*) as primary_count
FROM property_images
WHERE is_primary = true
GROUP BY property_id
HAVING COUNT(*) > 1;

-- 6. Sample property with full image data
SELECT 
    p.id as property_id,
    p.title,
    p.is_active,
    json_agg(
        json_build_object(
            'id', pi.id,
            'image_path', pi.image_path,
            'is_primary', pi.is_primary,
            'sort_order', pi.sort_order
        ) ORDER BY pi.is_primary DESC, pi.sort_order
    ) as images
FROM properties p
LEFT JOIN property_images pi ON pi.property_id = p.id
WHERE p.is_active = true
GROUP BY p.id, p.title, p.is_active
LIMIT 5;

-- 7. Fix: Ensure viewing policy exists (run if needed)
-- DROP POLICY IF EXISTS "Property images are viewable by everyone" ON public.property_images;
-- CREATE POLICY "Property images are viewable by everyone" 
--     ON public.property_images FOR SELECT 
--     USING (true);

-- 8. Fix: Ensure admins can manage all images (run if needed)
-- CREATE POLICY "Admins can manage all property images" 
--     ON public.property_images FOR ALL 
--     USING (
--         EXISTS (
--             SELECT 1 FROM public.profiles 
--             WHERE id = auth.uid() AND role = 'admin'
--         )
--     );
