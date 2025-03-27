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
                    <!-- Cột bên trái để đẩy logo vào giữa -->
                    <div class="col-md-4"></div>
                    <div class="col-md-4 text-center">
                        <a href="/">
                            <img class="img-fluid d-flex mx-auto mt-3"
                                src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/logo.png?1741705947617"
                                alt="no logo" width="150">
                        </a>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end">
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
        @include('includes.navbar')
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
</style>
