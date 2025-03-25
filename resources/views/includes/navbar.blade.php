<nav class="py-2 bg-body-tertiary">
    <div class="container d-flex flex-wrap border-top">
        <ul class="nav mx-auto mt-3">
            <li class="nav-item">
                <a href="/" class="nav-link link-body-emphasis px-2 text-secondary fw-bold">Trang
                    chủ</a>
            </li>
            <li class="nav-item">
                <a href="/san-pham" class="nav-link link-body-emphasis px-2 text-secondary fw-bold">Sản
                    phẩm</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link link-body-emphasis px-2 text-secondary fw-bold">Về chúng
                    tôi</a>
            </li>
            @if (Auth::check() && Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a href="/admin" class="nav-link link-body-emphasis px-2 text-secondary fw-bold">Admin</a>
                </li>
            @endif
        </ul>
    </div>
</nav>
