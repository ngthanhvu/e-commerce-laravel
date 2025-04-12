<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đơn hàng</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            border-left: 5px solid #007bff;
        }

        h2 {
            color: #212529;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            color: #343a40;
            font-size: 15px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-top: 20px;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Xin chào {{ $order->customer_name ?? 'khách hàng' }},</h2>
        <p>Trạng thái đơn hàng #{{ $order->id }} của bạn đã được cập nhật:</p>
        <p><strong>Trạng thái mới:</strong> <span class="highlight">
                @if ($order->status == 'pending')
                    Đang chờ xác nhận
                @elseif($order->status == 'paid')
                    Đa thanh toán
                @elseif($order->status == 'delivered')
                    Đã giao hàng
                @elseif($order->status == 'cancelled')
                    Đã hủy
                @endif
            </span></p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }}₫</p>
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi!</p>
        <div class="footer">
            <p>Trân trọng, Đội ngũ cửa hàng.</p>
        </div>
    </div>
</body>

</html>
