<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .user-message {
            background-color: #e3f2fd;
            margin-left: 20%;
        }

        .bot-message {
            background-color: #f5f5f5;
            margin-right: 20%;
        }

        .input-group {
            display: flex;
        }

        .input-group input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        .input-group button {
            padding: 10px;
            border: 1px solid #ccc;
            border-left: none;
            background-color: #007bff;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .input-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <h2>Trợ lý Chatbot</h2>
        <div class="chat-box" id="chatBox">
            <div class="message bot-message">Xin chào! Tôi có thể giúp bạn tìm sản phẩm gì hôm nay?</div>
        </div>
        <div class="input-group">
            <input type="text" id="messageInput" placeholder="Nhập tin nhắn..." autocomplete="off">
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <script>
        async function sendMessage() {
            const input = document.getElementById('messageInput');
            const chatBox = document.getElementById('chatBox');
            const message = input.value.trim();

            if (!message) return;

            // Thêm tin nhắn người dùng
            const userDiv = document.createElement('div');
            userDiv.className = 'message user-message';
            userDiv.textContent = message;
            chatBox.appendChild(userDiv);

            // Xóa input
            input.value = '';

            // Cuộn xuống dưới
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const response = await fetch('{{ route('chatbot.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        message
                    }),
                });

                const data = await response.json();

                // Thêm phản hồi bot
                const botDiv = document.createElement('div');
                botDiv.className = 'message bot-message';
                botDiv.innerHTML = data.message.replace(/\n/g, '<br>');
                chatBox.appendChild(botDiv);

                // Cuộn xuống dưới
                chatBox.scrollTop = chatBox.scrollHeight;
            } catch (error) {
                console.error('Lỗi:', error);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'message bot-message';
                errorDiv.textContent = 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại.';
                chatBox.appendChild(errorDiv);
            }
        }

        // Gửi tin nhắn bằng phím Enter
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>
</body>

</html>
