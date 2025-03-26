<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy nội dung</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS with tw- prefix -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    <style>
        /* Custom gradient for 404 text */
        .gradient-text {
            background: linear-gradient(90deg, #ff6ec4, #7873f5, #00ddeb, #f7ff00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>

<body class="tw-bg-gray-100 tw-font-sans">
    <div id="loading-spinner" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container tw-min-h-screen tw-flex tw-items-center tw-justify-center tw-text-center">
        <div>
            <h1 class="tw-text-[120px] tw-font-bold gradient-text tw-leading-none">404</h1>
            <h2 class="tw-text-[40px] tw-mt-4 tw-mb-2 tw-font-[900]">
                Không tìm thấy nội dung
                <span class="tw-text-[40px]">😢</span>
            </h2>
            <p class="tw-text-gray-600 tw-mb-2 tw-font-[500]">
                URL của nội dung này đã bị thay đổi hoặc không còn tồn tại.
            </p>
            <p class="tw-text-gray-600 tw-mb-6 tw-font-[500]">
                Nếu bạn đang lưu URL này, hãy thử truy cập lại từ trang chủ vì nội dung URL đã lưu.
            </p>
            <a href="/" class="btn btn-primary tw-px-6 tw-text-white tw-font-medium tw-rounded-full">
                VỀ TRANG CHỦ
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Optional for button functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loadingSpinner = document.getElementById("loading-spinner");

            function showLoading() {
                loadingSpinner.classList.add("show");
            }

            function hideLoading() {
                loadingSpinner.classList.remove("show");
            }
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", function(e) {
                    const href = this.getAttribute("href");
                    if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                        showLoading();
                    }
                });
            });
            window.addEventListener("pageshow", hideLoading);
        });
    </script>
</body>

</html>
