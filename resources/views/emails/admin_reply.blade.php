<!DOCTYPE html>
<html>

<head>
    <title>Phản hồi từ Admin</title>
</head>

<body>
    <h1>Xin chào {{ $rating->user->name }},</h1>
    <p>Admin đã phản hồi bình luận của bạn về sản phẩm "{{ $rating->product->name }}":</p>
    <blockquote>
        <p>{{ $rating->admin_reply }}</p>
    </blockquote>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>

</html>
