-- =====================================================
-- FIX PROPERTY IMAGES - Run this in Supabase SQL Editor
-- =====================================================

-- Step 1: Check current policies
SELECT policyname, cmd FROM pg_policies WHERE tablename = 'property_images';

-- Step 2: Drop all existing policies on property_images
DROP POLICY IF EXISTS "Property images are viewable by everyone" ON public.property_images;
DROP POLICY IF EXISTS "Property owners can manage images" ON public.property_images;
DROP POLICY IF EXISTS "Property owners can insert images" ON public.property_images;
DROP POLICY IF EXISTS "Property owners can update images" ON public.property_images;
DROP POLICY IF EXISTS "Property owners can delete images" ON public.property_images;
DROP POLICY IF EXISTS "Admins can manage all property images" ON public.property_images;

-- Step 3: Create new policies (correct ones)
-- Allow everyone to VIEW images
CREATE POLICY "Anyone can view property images" 
    ON public.property_images FOR SELECT 
    USING (true);

-- Allow property owners to INSERT images
CREATE POLICY "Property owners can insert images" 
    ON public.property_images FOR INSERT 
    WITH CHECK (
        EXISTS (
            SELECT 1 FROM public.properties 
            WHERE id = property_id AND user_id = auth.uid()
        )
    );

-- Allow property owners to UPDATE their images
CREATE POLICY "Property owners can update images" 
    ON public.property_images FOR UPDATE 
    USING (
        EXISTS (
            SELECT 1 FROM public.properties 
            WHERE id = property_id AND user_id = auth.uid()
        )
    );

-- Allow property owners to DELETE their images
CREATE POLICY "Property owners can delete images" 
    ON public.property_images FOR DELETE 
    USING (
        EXISTS (
            SELECT 1 FROM public.properties 
            WHERE id = property_id AND user_id = auth.uid()
        )
    );

-- Allow admins to do EVERYTHING with images
CREATE POLICY "Admins can manage all images" 
    ON public.property_images FOR ALL 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- Step 4: Verify policies are created
SELECT 
    policyname, 
    cmd as command,
    CASE 
        WHEN cmd = 'SELECT' THEN 'View'
        WHEN cmd = 'INSERT' THEN 'Create'
        WHEN cmd = 'UPDATE' THEN 'Edit'
        WHEN cmd = 'DELETE' THEN 'Remove'
        WHEN cmd = 'ALL' THEN 'Full Access'
    END as permission
FROM pg_policies 
WHERE tablename = 'property_images'
ORDER BY cmd;

-- Step 5: Check if images exist in database
SELECT COUNT(*) as total_images FROM property_images;

-- Step 6: Show sample property with images
SELECT 
    p.id,
    p.title,
    COUNT(pi.id) as image_count
FROM properties p
LEFT JOIN property_images pi ON pi.property_id = p.id
GROUP BY p.id, p.title
ORDER BY p.created_at DESC
LIMIT 10;
