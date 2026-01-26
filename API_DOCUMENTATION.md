# Haven Real Estate API Documentation

## Overview
This is a comprehensive Real Estate Management System API built with Laravel. It supports both web applications (Blade) and mobile applications (React Native) with token-based authentication.

## Base URL
```
http://localhost:8000/api
```

## Authentication
- **Web**: Session-based authentication
- **Mobile**: Token-based authentication using Laravel Sanctum

### Headers for API Requests
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token} (for protected routes)
```

## API Endpoints

### Authentication

#### Register User
```http
POST /api/register
```
**Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1234567890",
    "address": "123 Main St"
}
```

#### Login User
```http
POST /api/login
```
**Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Logout User
```http
POST /api/logout
```
**Headers:** `Authorization: Bearer {token}`

#### Get User Profile
```http
GET /api/profile
```
**Headers:** `Authorization: Bearer {token}`

#### Update User Profile
```http
PUT /api/profile
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "name": "John Doe Updated",
    "phone": "+1234567890",
    "address": "456 New St"
}
```

### Properties

#### Get All Properties (with filters)
```http
GET /api/properties
```
**Query Parameters:**
- `search` - Search keyword
- `type` - rent|sale
- `min_price` - Minimum price
- `max_price` - Maximum price
- `location` - Location filter
- `category_id` - Category ID
- `property_type` - Property type
- `bedrooms` - Minimum bedrooms
- `sort_by` - price_low|price_high|newest|oldest
- `per_page` - Items per page (default: 15)

#### Get Single Property
```http
GET /api/properties/{id}
```

#### Get Featured Properties
```http
GET /api/properties/featured/list
```

#### Create Property (Admin Only)
```http
POST /api/properties
```
**Headers:** `Authorization: Bearer {admin_token}`
**Body:**
```json
{
    "title": "Beautiful House",
    "description": "A beautiful house in the city center",
    "price": 250000,
    "location": "New York",
    "address": "123 Main St, NY",
    "latitude": 40.7128,
    "longitude": -74.0060,
    "type": "sale",
    "bedrooms": 3,
    "bathrooms": 2,
    "area": 150.5,
    "property_type": "house",
    "features": ["parking", "garden", "pool"],
    "category_id": 1,
    "is_featured": true
}
```

#### Update Property (Admin Only)
```http
PUT /api/properties/{id}
```
**Headers:** `Authorization: Bearer {admin_token}`

#### Delete Property (Admin Only)
```http
DELETE /api/properties/{id}
```
**Headers:** `Authorization: Bearer {admin_token}`

### Saved Properties

#### Get User's Saved Properties
```http
GET /api/saved-properties
```
**Headers:** `Authorization: Bearer {token}`

#### Save Property
```http
POST /api/saved-properties
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "property_id": 1
}
```

#### Remove Saved Property
```http
DELETE /api/saved-properties/{propertyId}
```
**Headers:** `Authorization: Bearer {token}`

#### Check if Property is Saved
```http
GET /api/saved-properties/check/{propertyId}
```
**Headers:** `Authorization: Bearer {token}`

#### Toggle Save Status
```http
POST /api/saved-properties/toggle
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "property_id": 1
}
```

### Payments

#### Get User's Payment History
```http
GET /api/payments
```
**Headers:** `Authorization: Bearer {token}`

#### Initiate Payment
```http
POST /api/payments
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
    "property_id": 1,
    "payment_method": "stripe",
    "type": "purchase",
    "description": "Property purchase payment"
}
```

#### Get Payment Details
```http
GET /api/payments/{id}
```
**Headers:** `Authorization: Bearer {token}`

#### Get All Payments (Admin Only)
```http
GET /api/payments/admin/all
```
**Headers:** `Authorization: Bearer {admin_token}`

#### Get Payment Statistics (Admin Only)
```http
GET /api/payments/admin/statistics
```
**Headers:** `Authorization: Bearer {admin_token}`

### Dashboard

#### Get User Dashboard Stats
```http
GET /api/dashboard/user
```
**Headers:** `Authorization: Bearer {token}`

#### Get Admin Dashboard Stats
```http
GET /api/dashboard/admin
```
**Headers:** `Authorization: Bearer {admin_token}`

#### Get Public Overview
```http
GET /api/overview
```

## Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        // Validation errors (if any)
    }
}
```

## Status Codes
- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Database Schema

### Users Table
- id, name, email, password, role (admin|user), phone, address, avatar, is_active, timestamps

### Categories Table
- id, name, slug, description, is_active, timestamps

### Properties Table
- id, title, description, price, location, address, latitude, longitude, type (rent|sale), status, bedrooms, bathrooms, area, property_type, features (JSON), category_id, user_id, is_featured, is_active, timestamps

### Property Images Table
- id, property_id, image_path, alt_text, is_primary, sort_order, timestamps

### Payments Table
- id, user_id, property_id, transaction_id, payment_method, payment_gateway_id, amount, currency, status, type, description, gateway_response (JSON), paid_at, timestamps

### Saved Properties Table
- id, user_id, property_id, timestamps

## Testing

### Default Users
- **Admin**: admin@haven.com / password123
- **User**: user@haven.com / password123

### Test the API
1. Start the server: `php artisan serve`
2. Test authentication: `POST /api/login`
3. Use the returned token for protected routes
4. Test property endpoints with filters
5. Test payment flow
6. Test saved properties functionality

## Security Features
- Password hashing
- API token authentication
- Role-based access control
- Input validation
- CSRF protection for web forms
- SQL injection prevention
- XSS protection

## Payment Integration
The system is designed to integrate with:
- Stripe
- Paystack  
- PayPal

Payment methods are implemented as placeholders and need actual gateway integration.