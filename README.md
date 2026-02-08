# Haven Real Estate Platform

A modern, full-featured real estate platform built with Laravel and Supabase, offering property listings, user management, payment processing, and administrative tools. Designed specifically for the Nigerian real estate market with Naira (₦) currency support.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Supabase](https://img.shields.io/badge/Supabase-PostgreSQL-green)
![Currency](https://img.shields.io/badge/Currency-NGN_(₦)-success)
![License](https://img.shields.io/badge/License-MIT-yellow)

## 🏠 About Haven

Haven is a comprehensive real estate management platform tailored for the Nigerian market that connects property owners with potential buyers and renters. Built with modern web technologies, it provides a seamless experience for browsing properties, managing listings, and processing transactions in Nigerian Naira (₦).

## ✨ Features

### For Users
- 🔐 **Secure Authentication** - User registration and login with Supabase Auth
- 🏘️ **Property Browsing** - Search and filter properties by type, location, price
- ❤️ **Save Favorites** - Bookmark properties for later viewing
- 💳 **Payment Processing** - Integrated Stripe and PayStack payment gateways (NGN support)
- 💰 **Nigerian Naira (₦)** - All prices displayed in local currency
- 📧 **Newsletter Subscription** - Stay updated with latest listings
- 🔔 **Notifications** - Real-time updates on property status
- 👤 **Profile Management** - Update personal information and avatar
- 📊 **User Dashboard** - Track saved properties and payment history

### For Administrators
- 📝 **Property Management** - Create, edit, and delete property listings
- 🖼️ **Image Upload** - Multiple images per property with primary image selection
- 👥 **User Management** - View and manage registered users
- 💰 **Payment Tracking** - Monitor all transactions and payment status
- 📢 **Notification System** - Send notifications to users or broadcast to all
- 📰 **Newsletter Management** - Create and send email campaigns
- 🏷️ **Category Management** - Organize properties by categories
- 📈 **Analytics Dashboard** - View platform statistics and insights

## 🛠️ Technology Stack

- **Backend Framework**: Laravel 12.x
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: PostgreSQL (via Supabase)
- **Authentication**: Supabase Auth
- **Storage**: Supabase Storage
- **Payment Gateways**: 
  - PayStack (Primary - Nigerian Naira support)
  - Stripe (International payments)
- **Currency**: Nigerian Naira (₦ / NGN)
- **Email**: SMTP (Gmail configured)
- **Build Tools**: Vite

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- PostgreSQL (via Supabase)
- Web server (Apache/Nginx)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd haven-webapp
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` file with your credentials:

```env
# Application
APP_NAME="Haven Real Estate"
APP_URL=http://localhost:8000

# Supabase Configuration
SUPABASE_URL=your_supabase_project_url
SUPABASE_KEY=your_supabase_anon_key
SUPABASE_SERVICE_KEY=your_supabase_service_role_key

# Payment Gateways
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
PAYSTACK_PUBLIC_KEY=your_paystack_public_key
PAYSTACK_SECRET_KEY=your_paystack_secret_key

# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
```

### 5. Database Setup

The database schema is provided in `database_schema.sql`. Run it in your Supabase SQL Editor:

1. Go to [Supabase Dashboard](https://supabase.com/dashboard)
2. Select your project
3. Navigate to SQL Editor
4. Copy contents of `database_schema.sql`
5. Paste and execute

**Important**: If you have existing data in USD, run `update_currency_to_naira.sql` to convert to NGN:
```sql
-- Update currency to Nigerian Naira
ALTER TABLE public.payments ALTER COLUMN currency SET DEFAULT 'NGN';
UPDATE public.payments SET currency = 'NGN' WHERE currency = 'USD' OR currency IS NULL;
```

### 6. Storage Setup

Create a symbolic link for public storage:

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run build
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🔑 Default Access

### Create Admin User

1. Register a new account at `/register`
2. Go to Supabase Dashboard → SQL Editor
3. Run this query with your email:

```sql
UPDATE public.profiles 
SET role = 'admin' 
WHERE email = 'your-email@example.com';
```

### Supabase Authentication Settings

For development, disable email confirmation:
1. Go to Supabase Dashboard → Authentication → Providers
2. Find "Confirm email" toggle
3. Turn it OFF
4. Save changes

## 📁 Project Structure

```
haven-webapp/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/              # API endpoints
│   │   │   ├── Auth/             # Authentication
│   │   │   └── Web/              # Web controllers
│   │   └── Middleware/           # Custom middleware
│   ├── Services/
│   │   └── SupabaseService.php   # Supabase integration
│   └── Helpers/
├── resources/
│   ├── views/
│   │   ├── admin/                # Admin dashboard views
│   │   ├── user/                 # User dashboard views
│   │   ├── properties/           # Property pages
│   │   ├── auth/                 # Login/Register pages
│   │   └── layouts/              # Layout templates
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                   # Web routes
│   └── api.php                   # API routes
├── public/
│   ├── images/                   # Static images
│   └── storage/                  # Uploaded files
├── database_schema.sql           # Database schema
└── .env                          # Environment configuration
```

## 🎨 Key Features Implementation

### Property Management
- Properties support both sale and rent types
- Multiple images per property with primary image selection
- Advanced filtering by category, type, location, price
- Featured properties on homepage
- Property views tracking
- **Prices displayed in Nigerian Naira (₦)**

### Payment Integration
- Dual payment gateway support (Stripe & PayStack)
- **PayStack optimized for Nigerian Naira transactions**
- Secure payment processing
- Transaction history tracking
- Payment status management (pending, completed, failed)
- **All amounts in NGN (₦)**

### User System
- Role-based access control (User/Admin)
- Profile management with avatar upload
- Saved properties functionality
- Payment history in Naira
- Notification system

### Admin Panel
- Comprehensive dashboard with statistics
- Property CRUD operations
- User management
- Payment monitoring
- Newsletter campaign management
- Notification broadcasting

## 🔒 Security Features

- Row Level Security (RLS) policies in Supabase
- CSRF protection
- XSS prevention
- SQL injection protection
- Secure password hashing
- Input sanitization middleware
- Security headers middleware

## 📱 API Endpoints

### Properties
- `GET /api/properties` - List all properties
- `GET /api/properties/{id}` - Get property details
- `GET /api/properties/featured/list` - Get featured properties

### Saved Properties
- `GET /api/saved-properties` - User's saved properties
- `POST /api/saved-properties` - Save a property
- `DELETE /api/saved-properties/{id}` - Remove saved property

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration
- `POST /api/auth/logout` - User logout

## 🧪 Testing

```bash
# Run tests
php artisan test
```

## 📝 Database Schema

The complete database schema includes:
- **profiles** - User information
- **categories** - Property categories
- **properties** - Property listings (prices in NGN)
- **property_images** - Property photos
- **saved_properties** - User favorites
- **payments** - Transaction records (currency: NGN)
- **notifications** - User notifications
- **newsletter_subscribers** - Email subscribers
- **newsletter_campaigns** - Email campaigns

See `database_schema.sql` for complete schema with relationships and policies.

## 💰 Currency & Localization

### Nigerian Naira (₦) Support
- All property prices displayed in Naira
- Payment processing in NGN
- Helper functions for currency formatting:
  ```php
  format_naira(1500000)  // Output: ₦1,500,000
  naira(250000)          // Output: ₦250,000
  ```

### Payment Gateways
- **PayStack** (Recommended): Native NGN support, lower fees for Nigerian transactions
- **Stripe**: International payments with NGN support

### Localization Features
- Currency symbol: ₦
- Number format: 1,500,000 (comma-separated)
- Optimized for Nigerian market

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Authors

- **Your Name** - Initial work

## 🙏 Acknowledgments

- Laravel Framework
- Supabase
- Tailwind CSS
- Alpine.js
- Stripe & PayStack
- Nigerian Real Estate Market

## 🇳🇬 Built for Nigeria

This platform is specifically designed and optimized for the Nigerian real estate market with:
- Nigerian Naira (₦) as the primary currency
- PayStack integration for seamless local payments
- Localized user experience
- Support for Nigerian property types and locations

## 📞 Support

For support, email support@haven.com or open an issue in the repository.

## 🔗 Links

- [Live Demo](#) - Coming soon
- [Documentation](#) - Coming soon
- [API Documentation](#) - Coming soon

---

Built with ❤️ for Nigeria using Laravel and Supabase | Currency: Nigerian Naira (₦)
