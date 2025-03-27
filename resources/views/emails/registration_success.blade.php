<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúc mừng bạn đã đăng ký thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .content p {
            font-size: 16px;
            color: #333333;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <p>Xin chào <strong>{{ $user->name }}</strong>,</p>
            <p>Chúng tôi rất vui mừng chào đón bạn đến với <strong>Kicap.vn</strong>! Tài khoản của bạn đã được tạo
                thành công.</p>
            <p>Email đăng nhập: <strong>{{ $user->email }}</strong></p>
            <p>Nhấn vào nút bên dưới để bắt đầu khám phá:</p>
            <a href="{{ url('/') }}" class="button">Truy cập Website</a>
        </div>
        <div class="footer">
            <p>Nếu bạn không đăng ký tài khoản này, vui lòng liên hệ với chúng tôi qua email: support@[tenwebsite].com
            </p>
            <p>&copy; {{ date('Y') }} [Tên Website]. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
