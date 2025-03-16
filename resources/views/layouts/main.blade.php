<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} | php3</title>
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

</head>
<style>
    * {
        font-family: 'Quicksand', sans-serif;
    }
</style>

<body>
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
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">0</span>
                                    </a>
                                </div>
                                <!-- Avatar và tên (phiên bản chưa đăng nhập) -->
                                <div class="d-flex align-items-center">
                                    <img src="https://muaclone247.com/assets/storage/images/avatar4N0.png"
                                        alt="avatar" class="rounded-circle me-2" width="40" height="40">
                                    <div class="text-end">
                                        <div>
                                            @if (Auth::check())
                                                <div>
                                                    <span>Chào, {{ Auth::user()->name }}</span>
                                                </div>
                                                <div class="mt-2">
                                                    <form action="/dang-xuat" method="post" id="logoutForm">
                                                        @csrf
                                                        <span onclick="document.getElementById('logoutForm').submit();"
                                                            class="text-danger text-decoration-none"
                                                            style="cursor: pointer">Đăng xuất</span>
                                                        </p>
                                                    </form>
                                                </div>
                                            @else
                                                <a href="/dang-nhap" class="text-primary text-decoration-none">Đăng
                                                    nhập</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <main class="container-fluid mt-3">
        @yield('content')
    </main>

    <footer class="text-dark py-4 mt-4" style="background-color: #F9F9F9">
        <div class="container mt-3">
            <div class="row">
                <!-- Cột 1: Thông tin công ty -->
                <div class="col-md-4">
                    <img src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/logo.png?1741705947617"
                        width="150"></img>
                    <p>HỘ KINH DOANH KICAP</p>
                    <p>Chứng nhận ĐKKD số: 01A8035150 do phòng TC-KH UBND quận Ba Đình cấp ngày 07/11/2023</p>
                    <p>38, ngõ 575 Kim Mã, Ba Đình, Hà Nội</p>
                    <p><i class="bi bi-telephone"></i> 0369161095</p>
                    <p><i class="bi bi-envelope"></i> kicap.vn@gmail.com</p>
                </div>

                <!-- Cột 2: Chính sách khách hàng -->
                <div class="col-md-4">
                    <h5 class="text-uppercase">Chính sách khách hàng</h5>
                    <ul class="list-unstyled" style="line-height: 3rem">
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo
                                hành</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách kiêm hàng</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách đổi trả hàng hoàn
                                tiền</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách thanh toán</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-dark text-decoration-none">Chính sách vận chuyển</a></li>
                    </ul>
                </div>
                <!-- Cột 3: Đăng ký nhận tin -->
                <div class="col-md-4">
                    <h5 class="text-uppercase">Đăng ký nhận tin</h5>
                    <p>Mua bàn phím cơ, keycap bộ, keycap lê, keycap resin. Bảo hành chính hãng. Ưu đãi khi mua online.
                        Dịch vụ mods phím cơ uy tín, chất lượng.</p>
                    <form action="#" method="post" class="d-flex flex-column">
                        <input type="email" class="form-control mb-2" placeholder="Email của bạn" required>
                        <button type="submit" class="btn btn-dark">Đăng ký</button>
                    </form>
                </div>
            </div>
            <hr>
            <p class="mt-3 text-center">&copy; 2025 Kicap | All Rights Reserved</p>
        </div>
    </footer>
</body>

</html>
