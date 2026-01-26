<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Haven Password</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo {
            width: 60px;
            height: 60px;
            background: #1a1a2e;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .title {
            color: #1a1a2e;
            font-size: 28px;
            font-weight: 900;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }
        .subtitle {
            color: #64748b;
            font-size: 14px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .content {
            margin-bottom: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 20px;
        }
        .message {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 30px;
        }
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #00CED1, #20B2AA);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 30px rgba(0, 206, 209, 0.3);
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 206, 209, 0.4);
        }
        .security-notice {
            background: #f1f5f9;
            border-left: 4px solid #00CED1;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
        }
        .security-title {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .security-text {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }
        .footer {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 12px;
        }
        .footer-links {
            margin-top: 20px;
        }
        .footer-links a {
            color: #00CED1;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
        }
        .alternative-link {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            word-break: break-all;
        }
        .alternative-title {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .alternative-url {
            color: #64748b;
            font-size: 12px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">H</div>
            <h1 class="title">Password Reset</h1>
            <p class="subtitle">Haven Real Estate</p>
        </div>

        <div class="content">
            <div class="greeting">Hello {{ $user->name }},</div>
            
            <div class="message">
                You are receiving this email because we received a password reset request for your Haven account. 
                If you requested this password reset, click the button below to choose a new password. If you did not request this, please ignore this email.
            </div>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="reset-button">Reset My Password</a>
            </div>

            <div class="security-notice">
                <div class="security-title">Security Information</div>
                <p class="security-text">
                    • This password reset link will expire in <strong>60 minutes</strong><br>
                    • The link can only be used once<br>
                    • If you didn't request this reset, your account is still secure<br>
                    • Never share this link with anyone
                </p>
            </div>

            <div class="alternative-link">
                <div class="alternative-title">Alternative Link</div>
                <div class="alternative-url">{{ $resetUrl }}</div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Haven Real Estate. All rights reserved.</p>
            <div class="footer-links">
                <a href="{{ url('/') }}">Visit Website</a>
                <a href="{{ route('contact') }}">Contact Support</a>
                <a href="{{ url('/') }}">Privacy Policy</a>
            </div>
        </div>
    </div>
</body>
</html>