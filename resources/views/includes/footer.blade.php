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
