<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Kicap Store</title>
    <link rel="icon"
        href="https://res.cloudinary.com/kineticlabs/image/upload/v1642032264/api-images/categories/keycaps_e3hsth.png"
        type="image/x-icon">
    {{-- css  --}}
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- boostrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- font Saira Semi Condensed -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Saira+Semi+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <!-- swal alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FontAwesome 6 Free CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- iziToast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS with prefix -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    {{-- swipper js --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .chatbot-container {
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 360px;
            max-height: 500px;
            height: 500px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            z-index: 1000;
        }

        .chatbot-container.open {
            display: flex;
        }

        .chatbot-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chatbot-header h3 {
            margin: 0;
            font-size: 16px;
        }

        .chatbot-close {
            cursor: pointer;
            font-size: 20px;
        }

        .chat-box {
            flex: 1;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
            border-bottom: 1px solid #ddd;
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

        .bot-message img {
            max-width: 100px;
            margin-top: 5px;
            border-radius: 4px;
        }

        .input-group-chatbot {
            display: flex;
            padding: 10px;
        }

        .input-group-chatbot input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            font-size: 14px;
        }

        .input-group-chatbot button {
            padding: 8px;
            border: 1px solid #ccc;
            border-left: none;
            background-color: #007bff;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .input-group-chatbot button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    @include('includes.header')
    <main class="container-fluid mt-3">
        @yield('content')
    </main>

    <div class="chatbot-icon text-white" onclick="toggleChatbot()">
        <i class="fa-regular fa-comment"></i>
    </div>
    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">
            <h3>Trợ lý Chatbot</h3>
            <span class="chatbot-close" onclick="toggleChatbot()">×</span>
        </div>
        <div class="chat-box" id="chatBox">
            <div class="message bot-message">Xin chào! Tôi có thể giúp bạn tìm sản phẩm gì hôm nay?</div>
        </div>
        <div class="input-group-chatbot">
            <input type="text" id="messageInput" placeholder="Nhập tin nhắn..." autocomplete="off">
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    @include('includes.footer')

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        function toggleChatbot() {
            const container = document.getElementById('chatbotContainer');
            container.classList.toggle('open');
        }

        async function sendMessage() {
            const input = document.getElementById('messageInput');
            const chatBox = document.getElementById('chatBox');
            const message = input.value.trim();

            if (!message) return;

            const userDiv = document.createElement('div');
            userDiv.className = 'message user-message';
            userDiv.textContent = message;
            chatBox.appendChild(userDiv);

            input.value = '';

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

                const htmlContent = marked.parse(data.message);

                const botDiv = document.createElement('div');
                botDiv.className = 'message bot-message';
                botDiv.innerHTML = htmlContent;
                chatBox.appendChild(botDiv);

                chatBox.scrollTop = chatBox.scrollHeight;
            } catch (error) {
                console.error('Lỗi:', error);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'message bot-message';
                errorDiv.textContent = 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại.';
                chatBox.appendChild(errorDiv);
            }
        }

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>
</body>

</html>
