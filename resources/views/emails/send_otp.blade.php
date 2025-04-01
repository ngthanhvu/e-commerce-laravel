<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email OTP</title>
    <style>
        /* Reset CSS để đảm bảo hiển thị đồng nhất trên các email client */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #4a00e0;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            text-align: center;
        }

        .otp-code {
            display: inline-block;
            background-color: #f1f1f1;
            padding: 10px 20px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .message {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }

        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            Mã OTP của bạn
        </div>

        <!-- Content -->
        <div class="content">
            <p class="message">Xin chào,</p>
            <p class="message">Mật khẩu một lần (OTP) của bạn để xác minh tài khoản là:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p class="message">
                Mã OTP này có hiệu lực trong 10 phút. Vui lòng không chia sẻ mã này với bất kỳ ai.<br>
                Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.
            </p>
            <p class="message">Cảm ơn bạn đã dùng dịch vụ!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2024 Kicap. All rights reserved.
        </div>
    </div>
</body>

</html>
