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
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">0</span>
                                </a>
                            </div>
                            <!-- Avatar và tên (phiên bản chưa đăng nhập) -->
                            <div class="d-flex align-items-center">
                                <img src="https://muaclone247.com/assets/storage/images/avatar4N0.png" alt="avatar"
                                    class="rounded-circle me-2" width="40" height="40">
                                <div class="text-end">
                                    <div>
                                        @if (session('success'))
                                            <script>
                                                iziToast.success({
                                                    title: 'Thành công',
                                                    message: '{{ session('success') }}',
                                                    position: 'topRight'
                                                });
                                            </script>
                                        @endif

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
        @include('includes.navbar')
    </div>
</div>
