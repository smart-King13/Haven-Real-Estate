# Gmail Setup Guide for Haven Password Reset

## Step-by-Step Gmail Configuration

### 1. **Enable 2-Factor Authentication (Required)**

1. Go to [Google Account Settings](https://myaccount.google.com/)
2. Click **Security** in the left sidebar
3. Under "Signing in to Google", click **2-Step Verification**
4. Follow the setup process to enable 2FA
5. **Important**: You MUST complete this step before proceeding

### 2. **Generate App Password**

1. After enabling 2FA, go back to **Security** settings
2. Under "Signing in to Google", click **2-Step Verification**
3. Scroll down and click **App passwords**
4. You might need to sign in again
5. In the "Select app" dropdown, choose **Mail**
6. In the "Select device" dropdown, choose **Other (Custom name)**
7. Type: **Haven Real Estate**
8. Click **Generate**
9. **Copy the 16-character password** (it looks like: `abcd efgh ijkl mnop`)

### 3. **Update Your .env File**

Replace these values in your `.env` file:

```env
MAIL_USERNAME=your-actual-gmail@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
```

**Example:**
```env
MAIL_USERNAME=john.doe@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
```

### 4. **Clear Configuration Cache**

Run these commands in your terminal:

```bash
php artisan config:clear
php artisan cache:clear
```

### 5. **Test the Setup**

1. Try the password reset feature
2. Check your email inbox
3. Check spam folder if not in inbox

## Complete .env Configuration

Your final email configuration should look like this:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-actual-gmail@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@haven.com"
MAIL_FROM_NAME="Haven Real Estate"
```

## Troubleshooting

### Common Issues:

1. **"Invalid credentials" error**
   - Make sure you're using the App Password, not your regular Gmail password
   - Ensure 2FA is enabled first

2. **"Less secure app access" error**
   - This shouldn't happen with App Passwords
   - If it does, you're probably using your regular password instead of App Password

3. **Connection timeout**
   - Check if your hosting/firewall blocks port 587
   - Try port 465 with SSL:
   ```env
   MAIL_PORT=465
   MAIL_ENCRYPTION=ssl
   ```

4. **Emails going to spam**
   - This is normal for development
   - Check spam folder
   - For production, consider using a dedicated email service

### Alternative Ports:

If port 587 doesn't work, try:

```env
# Option 1: Port 465 with SSL
MAIL_PORT=465
MAIL_ENCRYPTION=ssl

# Option 2: Port 25 (less secure)
MAIL_PORT=25
MAIL_ENCRYPTION=null
```

## Security Notes

- **Never share your App Password**
- **App Passwords bypass 2FA** - keep them secure
- **Revoke unused App Passwords** from Google Account settings
- **For production**, consider using dedicated email services like SendGrid

## Testing Commands

```bash
# Test email functionality
php artisan tinker
>>> Mail::raw('Test email', function($m) { $m->to('test@example.com')->subject('Test'); });

# Check logs for errors
tail -f storage/logs/laravel.log
```

## Next Steps

1. ✅ Enable 2FA on Gmail
2. ✅ Generate App Password
3. ✅ Update .env file with real credentials
4. ✅ Clear cache
5. ✅ Test password reset

Once completed, your password reset emails will be sent through Gmail successfully!