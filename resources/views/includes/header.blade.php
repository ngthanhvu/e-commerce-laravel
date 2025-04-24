<div id="loading-spinner" class="loading-overlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="wrapper">
    <div style="background-color: #F5F6F7;">
        <div class="py-3">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Mobile: 1 hàng 3 cột: Menu | Logo | Giỏ hàng -->
                    <div class="col-12 d-md-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Nút mở sidebar -->
                            <button class="btn p-0" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#mobileNavbar" aria-controls="mobileNavbar">
                                <i class="bi bi-list fs-3"></i>
                            </button>

                            <!-- Logo ở giữa -->
                            <a href="/" class="mx-auto">
                                <img class="img-fluid"
                                    src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/logo.png?1741705947617"
                                    alt="no logo" style="max-height: 60px;">
                            </a>

                            <!-- Giỏ hàng -->
                            <div class="position-relative">
                                <a href="/gio-hang" class="text-decoration-none text-dark">
                                    <i class="bi bi-bag fs-4"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">0</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop: 3 cột truyền thống -->
                    <div class="col-md-4 d-none d-md-block"></div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <a href="/">
                            <img class="img-fluid mx-auto mt-3"
                                src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/logo.png?1741705947617"
                                alt="no logo" width="150">
                        </a>
                    </div>
                    <div class="col-md-4 d-none d-md-flex justify-content-end align-items-center mt-3">
                        <div class="d-flex justify-content-end mt-3 mb-3 gap-2">
                            <!-- Icon giỏ hàng -->
                            <div class="text-center me-3 position-relative">
                                <a href="/gio-hang" type="button" class="text-decoration-none text-dark"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Giỏ hàng">Giỏ
                                    hàng
                                    <i class="bi bi-cart2 fs-4"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">{{ session('count_cart', 0) }}</span>
                                </a>
                            </div>
                            <!-- Avatar và dropdown -->
                            <div class="d-flex align-items-center">
                                @if (Auth::check())
                                    <div class="avatar-container">
                                        <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://muaclone247.com/assets/storage/images/avatar4N0.png @endif"
                                            class="rounded-circle me-2 avatar" alt="Avatar" data-bs-toggle="dropdown"
                                            aria-expanded="false" width="40" height="40">
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li class="user-info">
                                                <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://muaclone247.com/assets/storage/images/avatar4N0.png @endif"
                                                    alt="User Avatar" width="50" height="50">
                                                <div>
                                                    <div class="user-name">{{ Auth::user()->name }}</div>
                                                    <div class="user-handle">{{ Auth::user()->name }}</div>
                                                </div>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ url('/profile') }}">Trang cá nhân</a>
                                            </li>
                                            <li><a class="dropdown-item" href="/profile/favorite">Sản phẩm yêu thích</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                                            <li>
                                                <form action="/dang-xuat" method="post" id="logoutForm">
                                                    @csrf
                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                                        Đăng xuất
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <img src="https://muaclone247.com/assets/storage/images/avatar4N0.png"
                                        alt="avatar" class="rounded-circle me-2" width="40" height="40">
                                    <div class="text-end">
                                        <a href="/dang-nhap" class="text-primary text-decoration-none">Đăng nhập</a>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <script>
                                        iziToast.success({
                                            title: 'Thành công',
                                            message: '{{ session('success') }}',
                                            position: 'topRight'
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        @include('includes.navbar')
    </div>

    <!-- Offcanvas Sidebar cho Mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavbar" aria-labelledby="mobileNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold" id="mobileNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Avatar + thông tin người dùng -->
            <div class="d-flex align-items-center mb-3">
                @if (Auth::check())
                    <img src="@if (Auth::user()->avatar) {{ asset(Auth::user()->avatar) }} @else https://muaclone247.com/assets/storage/images/avatar4N0.png @endif"
                        class="rounded-circle me-2" width="50" height="50" alt="Avatar">
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">{{ Auth::user()->name }}</small>
                    </div>
                @else
                    <img src="https://muaclone247.com/assets/storage/images/avatar4N0.png" class="rounded-circle me-2"
                        width="50" height="50" alt="Avatar">
                    <div>
                        <a href="/dang-nhap" class="text-decoration-none text-primary">Đăng nhập</a>
                    </div>
                @endif
            </div>

            <!-- Menu chính -->
            <ul class="navbar-nav">
                <li class="nav-item"><a href="/" class="nav-link text-dark">Trang chủ</a></li>
                <li class="nav-item"><a href="/san-pham" class="nav-link text-dark">Sản phẩm</a></li>
                <li class="nav-item"><a href="/tin-tuc" class="nav-link text-dark">Tin tức</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-dark">Về chúng tôi</a></li>
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item"><a href="/admin" class="nav-link text-dark">Admin</a></li>
                @endif
            </ul>

            <!-- Tùy chọn người dùng -->
            @if (Auth::check())
                <hr>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/profile" class="nav-link text-dark">Trang cá nhân</a></li>
                    <li class="nav-item"><a href="/profile/favorite" class="nav-link text-dark">Sản phẩm yêu
                            thích</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark">Cài đặt</a></li>
                    <li class="nav-item">
                        <form action="/dang-xuat" method="post" id="logoutForm" class="d-inline">
                            @csrf
                            <a href="#" class="nav-link text-danger"
                                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Đăng
                                xuất</a>
                        </form>
                    </li>
                </ul>
            @endif
        </div>
    </div>

</div>

<!-- Thêm CSS cần thiết -->
<style>
    /* CSS cho avatar và dropdown */
    .avatar-container {
        position: relative;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 250px;
        padding: 10px;
    }

    .dropdown-menu .dropdown-item {
        padding: 10px 15px;
        border-radius: 5px;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f0f2f5;
    }

    .user-info {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
    }

    .user-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-info .user-name {
        font-weight: bold;
        font-size: 16px;
    }

    .user-info .user-handle {
        color: #606770;
        font-size: 14px;
    }

    @media (max-width: 767px) {
        .position-relative {
            right: 10px;
        }
    }
</style>
