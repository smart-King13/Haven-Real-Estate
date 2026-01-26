# Haven Mobile App - API Documentation

## Base URL
```
http://127.0.0.1:8000/api
```

**For Production:** Replace with your actual domain
```
https://yourdomain.com/api
```

---

## Authentication

All authenticated endpoints require a Bearer token in the header:
```
Authorization: Bearer {your_token_here}
```

---

## 📱 API Endpoints

### **1. Authentication**

#### Register
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

#### Login
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
**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {...},
    "token": "your_bearer_token_here"
  }
}
```

#### Logout
```http
POST /api/logout
```
**Headers:** `Authorization: Bearer {token}`

#### Get Profile
```http
GET /api/profile
```
**Headers:** `Authorization: Bearer {token}`

#### Update Profile
```http
PUT /api/profile
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "address": "123 Main St",
  "avatar": "base64_image_or_file"
}
```

#### Change Password
```http
PUT /api/change-password
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
  "current_password": "oldpassword",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

#### Forgot Password
```http
POST /api/forgot-password
```
**Body:**
```json
{
  "email": "john@example.com"
}
```

#### Reset Password
```http
POST /api/reset-password
```
**Body:**
```json
{
  "email": "john@example.com",
  "token": "reset_token",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

---

### **2. Properties**

#### Get All Properties
```http
GET /api/properties
```
**Query Parameters:**
- `search` - Search term
- `category_id` - Filter by category
- `type` - sale or rent
- `min_price` - Minimum price
- `max_price` - Maximum price
- `bedrooms` - Number of bedrooms
- `bathrooms` - Number of bathrooms
- `location` - Location filter
- `per_page` - Items per page (default: 10)

**Example:**
```
GET /api/properties?type=sale&min_price=100000&max_price=500000&bedrooms=3
```

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
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
  "title": "Luxury Villa",
  "description": "Beautiful villa...",
  "price": 500000,
  "location": "Malibu, CA",
  "address": "123 Ocean Drive",
  "type": "sale",
  "status": "available",
  "bedrooms": 4,
  "bathrooms": 3,
  "area": 3500,
  "property_type": "villa",
  "category_id": 1,
  "features": ["parking", "pool", "gym"],
  "is_featured": true
}
```

#### Update Property (Admin Only)
```http
PUT /api/properties/{id}
```
**Headers:** `Authorization: Bearer {token}`

#### Delete Property (Admin Only)
```http
DELETE /api/properties/{id}
```
**Headers:** `Authorization: Bearer {token}`

#### Upload Property Images (Admin Only)
```http
POST /api/properties/{id}/images
```
**Headers:** `Authorization: Bearer {token}`
**Body:** `multipart/form-data`
```
images[]: file1.jpg
images[]: file2.jpg
```

---

### **3. Saved Properties (Favorites)**

#### Get Saved Properties
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

#### Toggle Save Property
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

#### Check if Property is Saved
```http
GET /api/saved-properties/check/{propertyId}
```
**Headers:** `Authorization: Bearer {token}`

#### Remove Saved Property
```http
DELETE /api/saved-properties/{propertyId}
```
**Headers:** `Authorization: Bearer {token}`

---

### **4. Payments**

#### Get User Payments
```http
GET /api/payments
```
**Headers:** `Authorization: Bearer {token}`

#### Get Single Payment
```http
GET /api/payments/{id}
```
**Headers:** `Authorization: Bearer {token}`

#### Create Payment
```http
POST /api/payments
```
**Headers:** `Authorization: Bearer {token}`
**Body:**
```json
{
  "property_id": 1,
  "amount": 50000,
  "payment_method": "stripe",
  "payment_type": "full_payment"
}
```

#### Verify Payment
```http
POST /api/payments/verify/{transactionId}
```
**Headers:** `Authorization: Bearer {token}`

#### Get All Payments (Admin Only)
```http
GET /api/payments/admin/all
```
**Headers:** `Authorization: Bearer {token}`

#### Get Payment Statistics (Admin Only)
```http
GET /api/payments/admin/statistics
```
**Headers:** `Authorization: Bearer {token}`

---

### **5. Dashboard**

#### User Dashboard Stats
```http
GET /api/dashboard/user
```
**Headers:** `Authorization: Bearer {token}`
**Response:**
```json
{
  "success": true,
  "data": {
    "saved_properties": 5,
    "total_payments": 3,
    "pending_payments": 1,
    "recent_properties": [...]
  }
}
```

#### Admin Dashboard Stats
```http
GET /api/dashboard/admin
```
**Headers:** `Authorization: Bearer {token}`

#### Overview Stats
```http
GET /api/overview
```
**Headers:** `Authorization: Bearer {token}`

---

### **6. Email Verification**

#### Send Verification Email
```http
POST /api/email/verification-notification
```
**Headers:** `Authorization: Bearer {token}`

#### Verify Email
```http
POST /api/email/verify
```
**Body:**
```json
{
  "id": "user_id",
  "hash": "verification_hash"
}
```

---

### **7. System**

#### API Status Check
```http
GET /api/status
```
**Response:**
```json
{
  "status": "ok",
  "message": "API is running",
  "timestamp": "2026-01-21T10:00:00Z"
}
```

---

## 🔐 Authentication Flow

### For Mobile App:

1. **User Registration/Login**
   ```
   POST /api/register or POST /api/login
   ```
   
2. **Store Token**
   - Save the `token` from response
   - Store securely (Keychain/SharedPreferences)

3. **Use Token in Headers**
   ```
   Authorization: Bearer {token}
   ```

4. **Token Refresh**
   - Tokens don't expire by default
   - Implement logout to revoke token

---

## 📊 Response Format

### Success Response:
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

### Error Response:
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Error detail"]
  }
}
```

---

## 🚀 Quick Start for Mobile App

### 1. Base Configuration
```dart
// Flutter Example
class ApiConfig {
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  static const String storageUrl = 'http://127.0.0.1:8000/storage';
}
```

### 2. Authentication Service
```dart
Future<Map<String, dynamic>> login(String email, String password) async {
  final response = await http.post(
    Uri.parse('${ApiConfig.baseUrl}/login'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({
      'email': email,
      'password': password,
    }),
  );
  return jsonDecode(response.body);
}
```

### 3. Authenticated Request
```dart
Future<Map<String, dynamic>> getProfile(String token) async {
  final response = await http.get(
    Uri.parse('${ApiConfig.baseUrl}/profile'),
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
    },
  );
  return jsonDecode(response.body);
}
```

---

## 🖼️ Image URLs

### Property Images:
```
http://127.0.0.1:8000/storage/properties/{image_name}.jpg
```

### User Avatars:
```
http://127.0.0.1:8000/storage/avatars/{image_name}.jpg
```

### Example:
```json
{
  "image_path": "properties/abc123.jpg",
  "full_url": "http://127.0.0.1:8000/storage/properties/abc123.jpg"
}
```

---

## 🔧 Testing the API

### Using Postman:
1. Import the base URL: `http://127.0.0.1:8000/api`
2. Test login endpoint
3. Copy the token from response
4. Add to Authorization header for other requests

### Using cURL:
```bash
# Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@haven.com","password":"password"}'

# Get Properties
curl -X GET http://127.0.0.1:8000/api/properties \
  -H "Content-Type: application/json"

# Get Profile (Authenticated)
curl -X GET http://127.0.0.1:8000/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 📝 Notes

1. **CORS**: Already configured for mobile apps
2. **Rate Limiting**: No rate limiting currently applied
3. **Pagination**: Most list endpoints support pagination
4. **File Uploads**: Use `multipart/form-data` for images
5. **Timestamps**: All dates in ISO 8601 format

---

## 🆘 Support

For API issues or questions:
- Check response error messages
- Verify token is valid
- Ensure correct headers are sent
- Check network connectivity

---

**Last Updated:** January 21, 2026
**API Version:** 1.0
