<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- swal alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FontAwesome 6 Free CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- iziToast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    {{-- font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300..700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Signika Negative', sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #343a40;
            border-radius: 5px;
        }

        .sidebar .nav-link i {
            font-size: 18px;
        }

        .sidebar .dropdown-menu {
            background-color: #343a40;
            border: none;
            padding: 0;
        }

        .sidebar .dropdown-menu .dropdown-item {
            color: #adb5bd;
            padding: 8px 20px;
            transition: all 0.3s;
        }

        .sidebar .dropdown-menu .dropdown-item:hover {
            color: #fff;
            background-color: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
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

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 210px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="loading-spinner" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center mb-4"><a href="/" class="text-white text-decoration-none">Admin
                Panel</a></h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="/admin#dashboard">
                    <i class="bi bi-house-door me-2"></i>Bảng điều khiển
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#productsMenu" role="button">
                    <div><i class="bi bi-box me-2"></i>Sản phẩm</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="productsMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="/admin/products#list-products">Danh sách sản phẩm</a></li>
                        <li><a class="nav-link" href="/admin/products/create#add-product">Thêm sản phẩm</a></li>
                        <li><a class="nav-link" href="/admin/categories#categories">Danh mục</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/users#users">
                    <i class="bi bi-person me-2"></i>Người dùng
                </a>
            </li>

            <!-- Menu phân cấp Settings -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#settingsMenu" role="button">
                    <div><i class="bi bi-gear me-2"></i>Cài đặt</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="settingsMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="/admin/settings/general#general">General</a></li>
                        <li><a class="nav-link" href="/admin/settings/security#security">Security</a></li>
                        <li><a class="nav-link" href="/admin/settings/notifications#notifications">Notifications</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin/reports#reports">
                    <i class="bi bi-bar-chart me-2"></i>Báo cáo
                </a>
            </li>
        </ul>
    </div>

    <!-- Nội dung chính -->
    <div class="content container-fluid">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            function removeActive() {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Chỉ thực hiện nếu đây là liên kết bình thường
                    if (this.getAttribute('data-bs-toggle') === 'collapse') {
                        return;
                    }

                    removeActive();
                    this.classList.add('active');

                    // Thêm hash vào URL khi nhấp vào các liên kết trong sidebar
                    const href = this.getAttribute('href');
                    window.location.href = href; // Điều hướng đến URL mới bao gồm hash
                });
            });

            function setActiveFromHash() {
                const hash = window.location.hash;
                if (hash) {
                    removeActive();
                    const targetLink = document.querySelector(`.sidebar .nav-link[href*="${hash}"]`);
                    if (targetLink) {
                        targetLink.classList.add('active');
                    }
                } else {
                    removeActive();
                    document.querySelector('.sidebar .nav-link').classList.add('active');
                }
            }

            setActiveFromHash();
            window.addEventListener('hashchange', setActiveFromHash);
        });
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
