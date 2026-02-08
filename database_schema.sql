-- =====================================================
-- HAVEN REAL ESTATE - DATABASE SCHEMA
-- =====================================================
-- This is a backup of the current database structure
-- Generated: February 6, 2026
-- Database: PostgreSQL (Supabase)
-- =====================================================

-- =====================================================
-- PROFILES TABLE
-- =====================================================
-- Stores user profile information
-- Linked to Supabase Auth users via trigger

CREATE TABLE IF NOT EXISTS public.profiles (
    id UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
    email TEXT UNIQUE NOT NULL,
    name TEXT,
    phone TEXT,
    address TEXT,
    avatar TEXT,
    role TEXT DEFAULT 'user' CHECK (role IN ('user', 'admin')),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Enable Row Level Security
ALTER TABLE public.profiles ENABLE ROW LEVEL SECURITY;

-- Policies for profiles
CREATE POLICY "Public profiles are viewable by everyone" 
    ON public.profiles FOR SELECT 
    USING (true);

CREATE POLICY "Users can update own profile" 
    ON public.profiles FOR UPDATE 
    USING (auth.uid() = id);

-- =====================================================
-- CATEGORIES TABLE
-- =====================================================
-- Property categories (Residential, Commercial, etc.)

CREATE TABLE IF NOT EXISTS public.categories (
    id BIGSERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    description TEXT,
    icon TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Enable Row Level Security
ALTER TABLE public.categories ENABLE ROW LEVEL SECURITY;

-- Policies for categories
CREATE POLICY "Categories are viewable by everyone" 
    ON public.categories FOR SELECT 
    USING (true);

CREATE POLICY "Only admins can modify categories" 
    ON public.categories FOR ALL 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- PROPERTIES TABLE
-- =====================================================
-- Main properties listing

CREATE TABLE IF NOT EXISTS public.properties (
    id BIGSERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(15, 2) NOT NULL,
    location TEXT NOT NULL,
    address TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    type TEXT NOT NULL CHECK (type IN ('sale', 'rent')),
    status TEXT DEFAULT 'available' CHECK (status IN ('available', 'pending', 'sold', 'rented', 'draft', 'archived')),
    bedrooms INTEGER,
    bathrooms INTEGER,
    area DECIMAL(10, 2),
    property_type TEXT,
    features JSONB,
    category_id BIGINT REFERENCES public.categories(id) ON DELETE SET NULL,
    user_id UUID REFERENCES public.profiles(id) ON DELETE CASCADE,
    is_featured BOOLEAN DEFAULT false,
    is_active BOOLEAN DEFAULT true,
    views INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Indexes for better performance
CREATE INDEX IF NOT EXISTS idx_properties_category ON public.properties(category_id);
CREATE INDEX IF NOT EXISTS idx_properties_user ON public.properties(user_id);
CREATE INDEX IF NOT EXISTS idx_properties_type ON public.properties(type);
CREATE INDEX IF NOT EXISTS idx_properties_status ON public.properties(status);
CREATE INDEX IF NOT EXISTS idx_properties_featured ON public.properties(is_featured);
CREATE INDEX IF NOT EXISTS idx_properties_slug ON public.properties(slug);

-- Enable Row Level Security
ALTER TABLE public.properties ENABLE ROW LEVEL SECURITY;

-- Policies for properties
CREATE POLICY "Properties are viewable by everyone" 
    ON public.properties FOR SELECT 
    USING (is_active = true OR user_id = auth.uid());

CREATE POLICY "Users can create properties" 
    ON public.properties FOR INSERT 
    WITH CHECK (auth.uid() = user_id);

CREATE POLICY "Users can update own properties" 
    ON public.properties FOR UPDATE 
    USING (auth.uid() = user_id);

CREATE POLICY "Admins can do everything with properties" 
    ON public.properties FOR ALL 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- PROPERTY IMAGES TABLE
-- =====================================================
-- Images for properties

CREATE TABLE IF NOT EXISTS public.property_images (
    id BIGSERIAL PRIMARY KEY,
    property_id BIGINT REFERENCES public.properties(id) ON DELETE CASCADE,
    image_path TEXT NOT NULL,
    is_primary BOOLEAN DEFAULT false,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Indexes
CREATE INDEX IF NOT EXISTS idx_property_images_property ON public.property_images(property_id);
CREATE INDEX IF NOT EXISTS idx_property_images_primary ON public.property_images(is_primary);

-- Enable Row Level Security
ALTER TABLE public.property_images ENABLE ROW LEVEL SECURITY;

-- Policies for property images
CREATE POLICY "Property images are viewable by everyone" 
    ON public.property_images FOR SELECT 
    USING (true);

CREATE POLICY "Property owners can manage images" 
    ON public.property_images FOR ALL 
    USING (
        EXISTS (
            SELECT 1 FROM public.properties 
            WHERE id = property_id AND user_id = auth.uid()
        )
    );

-- =====================================================
-- SAVED PROPERTIES TABLE
-- =====================================================
-- User's saved/favorited properties

CREATE TABLE IF NOT EXISTS public.saved_properties (
    id BIGSERIAL PRIMARY KEY,
    user_id UUID REFERENCES public.profiles(id) ON DELETE CASCADE,
    property_id BIGINT REFERENCES public.properties(id) ON DELETE CASCADE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    UNIQUE(user_id, property_id)
);

-- Indexes
CREATE INDEX IF NOT EXISTS idx_saved_properties_user ON public.saved_properties(user_id);
CREATE INDEX IF NOT EXISTS idx_saved_properties_property ON public.saved_properties(property_id);

-- Enable Row Level Security
ALTER TABLE public.saved_properties ENABLE ROW LEVEL SECURITY;

-- Policies for saved properties
CREATE POLICY "Users can view own saved properties" 
    ON public.saved_properties FOR SELECT 
    USING (auth.uid() = user_id);

CREATE POLICY "Users can save properties" 
    ON public.saved_properties FOR INSERT 
    WITH CHECK (auth.uid() = user_id);

CREATE POLICY "Users can unsave properties" 
    ON public.saved_properties FOR DELETE 
    USING (auth.uid() = user_id);

-- =====================================================
-- PAYMENTS TABLE
-- =====================================================
-- Payment transactions

CREATE TABLE IF NOT EXISTS public.payments (
    id BIGSERIAL PRIMARY KEY,
    user_id UUID REFERENCES public.profiles(id) ON DELETE CASCADE,
    property_id BIGINT REFERENCES public.properties(id) ON DELETE SET NULL,
    amount DECIMAL(15, 2) NOT NULL,
    currency TEXT DEFAULT 'NGN',
    payment_method TEXT,
    payment_gateway TEXT,
    transaction_id TEXT UNIQUE,
    status TEXT DEFAULT 'pending' CHECK (status IN ('pending', 'completed', 'failed', 'refunded', 'cancelled')),
    metadata JSONB,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Indexes
CREATE INDEX IF NOT EXISTS idx_payments_user ON public.payments(user_id);
CREATE INDEX IF NOT EXISTS idx_payments_property ON public.payments(property_id);
CREATE INDEX IF NOT EXISTS idx_payments_status ON public.payments(status);
CREATE INDEX IF NOT EXISTS idx_payments_transaction ON public.payments(transaction_id);

-- Enable Row Level Security
ALTER TABLE public.payments ENABLE ROW LEVEL SECURITY;

-- Policies for payments
CREATE POLICY "Users can view own payments" 
    ON public.payments FOR SELECT 
    USING (auth.uid() = user_id);

CREATE POLICY "Admins can view all payments" 
    ON public.payments FOR SELECT 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- NOTIFICATIONS TABLE
-- =====================================================
-- User notifications

CREATE TABLE IF NOT EXISTS public.notifications (
    id BIGSERIAL PRIMARY KEY,
    user_id UUID REFERENCES public.profiles(id) ON DELETE CASCADE,
    title TEXT NOT NULL,
    message TEXT NOT NULL,
    type TEXT DEFAULT 'info' CHECK (type IN ('info', 'success', 'warning', 'error')),
    send_to_all BOOLEAN DEFAULT false,
    is_read BOOLEAN DEFAULT false,
    read_at TIMESTAMP WITH TIME ZONE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Indexes
CREATE INDEX IF NOT EXISTS idx_notifications_user ON public.notifications(user_id);
CREATE INDEX IF NOT EXISTS idx_notifications_read ON public.notifications(is_read);
CREATE INDEX IF NOT EXISTS idx_notifications_broadcast ON public.notifications(send_to_all);

-- Enable Row Level Security
ALTER TABLE public.notifications ENABLE ROW LEVEL SECURITY;

-- Policies for notifications
CREATE POLICY "Users can view own notifications or broadcast" 
    ON public.notifications FOR SELECT 
    USING (auth.uid() = user_id OR send_to_all = true);

CREATE POLICY "Users can update own notifications" 
    ON public.notifications FOR UPDATE 
    USING (auth.uid() = user_id);

CREATE POLICY "Admins can create notifications" 
    ON public.notifications FOR INSERT 
    WITH CHECK (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- NEWSLETTER SUBSCRIBERS TABLE
-- =====================================================
-- Newsletter subscription management

CREATE TABLE IF NOT EXISTS public.newsletter_subscribers (
    id BIGSERIAL PRIMARY KEY,
    email TEXT UNIQUE NOT NULL,
    name TEXT,
    status TEXT DEFAULT 'active' CHECK (status IN ('active', 'unsubscribed')),
    subscribed_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    unsubscribed_at TIMESTAMP WITH TIME ZONE
);

-- Indexes
CREATE INDEX IF NOT EXISTS idx_newsletter_email ON public.newsletter_subscribers(email);
CREATE INDEX IF NOT EXISTS idx_newsletter_status ON public.newsletter_subscribers(status);

-- Enable Row Level Security
ALTER TABLE public.newsletter_subscribers ENABLE ROW LEVEL SECURITY;

-- Policies for newsletter
CREATE POLICY "Anyone can subscribe" 
    ON public.newsletter_subscribers FOR INSERT 
    WITH CHECK (true);

CREATE POLICY "Admins can view subscribers" 
    ON public.newsletter_subscribers FOR SELECT 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- NEWSLETTER CAMPAIGNS TABLE
-- =====================================================
-- Newsletter campaign management

CREATE TABLE IF NOT EXISTS public.newsletter_campaigns (
    id BIGSERIAL PRIMARY KEY,
    subject TEXT NOT NULL,
    content TEXT NOT NULL,
    status TEXT DEFAULT 'draft' CHECK (status IN ('draft', 'sent', 'scheduled')),
    sent_at TIMESTAMP WITH TIME ZONE,
    created_by UUID REFERENCES public.profiles(id) ON DELETE SET NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Enable Row Level Security
ALTER TABLE public.newsletter_campaigns ENABLE ROW LEVEL SECURITY;

-- Policies for campaigns
CREATE POLICY "Admins can manage campaigns" 
    ON public.newsletter_campaigns FOR ALL 
    USING (
        EXISTS (
            SELECT 1 FROM public.profiles 
            WHERE id = auth.uid() AND role = 'admin'
        )
    );

-- =====================================================
-- FUNCTIONS AND TRIGGERS
-- =====================================================

-- Function to update updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Apply updated_at trigger to tables
DROP TRIGGER IF EXISTS update_profiles_updated_at ON public.profiles;
CREATE TRIGGER update_profiles_updated_at
    BEFORE UPDATE ON public.profiles
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

DROP TRIGGER IF EXISTS update_categories_updated_at ON public.categories;
CREATE TRIGGER update_categories_updated_at
    BEFORE UPDATE ON public.categories
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

DROP TRIGGER IF EXISTS update_properties_updated_at ON public.properties;
CREATE TRIGGER update_properties_updated_at
    BEFORE UPDATE ON public.properties
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

DROP TRIGGER IF EXISTS update_payments_updated_at ON public.payments;
CREATE TRIGGER update_payments_updated_at
    BEFORE UPDATE ON public.payments
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Function to create profile on user signup
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO public.profiles (id, email, name, role)
    VALUES (
        NEW.id,
        NEW.email,
        COALESCE(NEW.raw_user_meta_data->>'name', ''),
        COALESCE(NEW.raw_user_meta_data->>'role', 'user')
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- Trigger to auto-create profile on signup
DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
CREATE TRIGGER on_auth_user_created
    AFTER INSERT ON auth.users
    FOR EACH ROW
    EXECUTE FUNCTION public.handle_new_user();

-- =====================================================
-- SAMPLE DATA (Optional - for testing)
-- =====================================================

-- Insert default categories
INSERT INTO public.categories (name, slug, description, is_active) VALUES
    ('Residential', 'residential', 'Houses, apartments, and residential properties', true),
    ('Commercial', 'commercial', 'Office spaces, retail, and commercial properties', true),
    ('Industrial', 'industrial', 'Warehouses, factories, and industrial properties', true),
    ('Land', 'land', 'Vacant land and development opportunities', true),
    ('Luxury', 'luxury', 'High-end luxury properties', true)
ON CONFLICT (slug) DO NOTHING;

-- =====================================================
-- END OF SCHEMA
-- =====================================================
