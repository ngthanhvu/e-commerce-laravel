<nav class="navbar navbar-expand-md py-2 bg-body-tertiary border-top">
    <div class="container">
        <!-- Desktop Navbar -->
        <div class="collapse navbar-collapse justify-content-center d-none d-md-flex" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="/" class="nav-link text-secondary fw-bold">Trang chủ</a>
                </li>
                <li class="nav-item"><a href="/san-pham" class="nav-link text-secondary fw-bold">Sản phẩm</a>
                </li>
                <li class="nav-item"><a href="/tin-tuc" class="nav-link text-secondary fw-bold">Tin tức</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-secondary fw-bold">Về chúng
                        tôi</a></li>
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="/admin" class="nav-link link-body-emphasis px-2 text-secondary fw-bold">Admin</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
