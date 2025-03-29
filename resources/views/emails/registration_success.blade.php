<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #0288d1;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .button {
            background: #0288d1;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://res.cloudinary.com/kineticlabs/image/upload/v1642032264/api-images/categories/keycaps_e3hsth.png"
                alt="Logo" style="max-width: 100px;">
        </div>
        <div class="content">
            <h2>Chào mừng bạn!</h2>
            <p>Tài khoản của bạn tại <strong>Kciap.com</strong> đã được tạo thành công.</p>
            <p>Đăng nhập để bắt đầu mua sắm nào!!!</p>
            <a href="{{ url('/') }}" class="button">Mua ngay</a>
        </div>
        <div class="footer">
            <p>© 2025 Kciap. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
