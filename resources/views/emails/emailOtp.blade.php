<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رمز التحقق OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            background: #f0fdf4;
            padding: 20px;
            border-radius: 12px;
            letter-spacing: 8px;
            color: #166534;
            margin: 20px 0;
            font-family: monospace;
        }
        .message {
            color: #333;
            line-height: 1.6;
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .expiry {
            color: #e11d48;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcWEsC6gzBQ6bfz8_VKkIeRqrIcygA-wsY5w&s"
                alt="Order Hub"
                style="width: 70px; height: auto; margin-bottom: 10px;">
        </div>
        <h1>Verification code 🔐</h1>
    </div>

        @if($name)
            <p class="message">Hi <strong>{{ $name }}</strong>،</p>
        @endif

        <p class="message">Copy the code below login to <strong>Order Hub</strong>.</p>

        <div class="otp-code">
            {{ $otp }}
        </div>

        <p class="message">The code can only be used once and expired in <strong>10 minutes</strong>.</p>

        <div class="expiry">
            If you did not request this code, please ignore this email ⚠️ .
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} منصة خدمتك. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
