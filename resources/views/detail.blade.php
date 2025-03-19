@extends('layouts.main')

@section('content')
    <style>
        .product-image {
            width: 100%;
            border-radius: 5px;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: black;
        }

        .color-option {
            width: 40px;
            height: 40px;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.active {
            border: 2px solid black;
        }
    </style>
    <div class="container">
        <nav aria-label="breadcrumb"
            style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="container mb-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6">
                {{-- <img id="mainImage"
                    src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                    class="product-image img-fluid" alt="Bàn phím cơ"> --}}
                @if ($product->mainImage)
                    <img id="mainImage" src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                        class="product-image img-fluid" alt="{{ $product->name }}">
                @else
                    <img id="mainImage"
                        src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                        class="product-image img-fluid" alt="Keycap Artisan Natra">
                @endif
                <div class="mt-3 d-flex">
                    <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                        class="thumbnail mx-1 active" onclick="changeImage(this)">
                    {{-- <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                        class="thumbnail mx-1" onclick="changeImage(this)">
                    <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                        class="thumbnail mx-1" onclick="changeImage(this)">
                    <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                        class="thumbnail mx-1" onclick="changeImage(this)"> --}}
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p class="text-muted">Khung nhôm CNC, 3 Mode, có góc LED vỡ siêu đẹp</p>
                <h3 class="text-danger">{{ number_format($product->price, 0, ',', '.') }}₫</h3>
                <p><strong>Tình trạng:</strong> <span class="text-success">Còn hàng</span></p>

                <!-- Phiên bản -->
                <p><strong>Phiên bản:</strong></p>
                <button class="btn btn-outline-dark btn-sm">Stars75</button>
                <button class="btn btn-outline-dark btn-sm">Stars75 Pro</button>

                <!-- Màu sắc -->
                <p class="mt-3"><strong>Màu sắc:</strong></p>
                <div>
                    <div class="color-option bg-black" onclick="selectColor(this)"></div>
                    <div class="color-option bg-secondary" onclick="selectColor(this)"></div>
                    <div class="color-option bg-purple" onclick="selectColor(this)"></div>
                    <div class="color-option bg-danger" onclick="selectColor(this)"></div>
                </div>

                <!-- Số lượng -->
                <p class="mt-3"><strong>Số lượng:</strong></p>
                <div class="input-group" style="width: 120px;">
                    <button class="btn btn-outline-dark" onclick="changeQuantity(-1)">-</button>
                    <input type="text" class="form-control text-center" id="quantity" value="1">
                    <button class="btn btn-outline-dark" onclick="changeQuantity(1)">+</button>
                </div>

                <!-- Nút thêm vào giỏ hàng -->
                <button class="btn btn-dark w-50 mt-3"><i class="fa-solid fa-cart-shopping"></i> THÊM VÀO GIỎ HÀNG</button>
                <button class="btn btn-outline-danger mt-3"><i class="fa-solid fa-heart"></i> Yêu thích</button>
            </div>
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="mt-5" style="border-top: 1px solid #ccc; padding-top: 20px;">
            <h4>MÔ TẢ</h4>
            <p>Weikav Stars75 là mẫu bàn phím layout 75% với thiết kế nhôm CNC cao cấp, hỗ trợ ba chế độ kết nối và trang bị
                switch chất lượng cao. Đây là lựa chọn đáng cân nhắc cho những ai tìm kiếm một chiếc bàn phím vừa có hiệu
                năng mạnh mẽ, vừa mang lại trải nghiệm gõ thoải mái.</p>
        </div>
    </div>
    <div class="container mt-4">
        <section class="new-products border p-3 rounded-2">
            <h2 class="text-center text-uppercase mb-3">Sản phẩm liên quan</h2>
            <div class="row mt-3">
                <div class="col-md-3 col-6 mb-3">
                    <div class="card border-0">
                        <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                            class="card-img-top" alt="Keycap Artisan Natra">
                        <div class="card-body text-center">
                            <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                            <h5 class="card-subtitle mb-2 ">KEYCAP ARTISAN NF NATRA</h5>
                            <p class="card-text">250.000₫</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0">
                        <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                            class="card-img-top" alt="Keycap Artisan Natra">
                        <div class="card-body text-center">
                            <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                            <h5 class="card-subtitle mb-2 ">KEYCAP ARTISAN NF NATRA</h5>
                            <p class="card-text">250.000₫</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0">
                        <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                            class="card-img-top" alt="Keycap Artisan Natra">
                        <div class="card-body text-center">
                            <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                            <h5 class="card-subtitle mb-2 ">KEYCAP ARTISAN NF NATRA</h5>
                            <p class="card-text">250.000₫</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0">
                        <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                            class="card-img-top" alt="Keycap Artisan Natra">
                        <div class="card-body text-center">
                            <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                            <h5 class="card-subtitle mb-2 ">KEYCAP ARTISAN NF NATRA</h5>
                            <p class="card-text">250.000₫</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script xử lý số lượng và hình ảnh -->
    <script>
        function changeImage(img) {
            document.getElementById('mainImage').src = img.src;
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            img.classList.add('active');
        }

        function selectColor(element) {
            document.querySelectorAll('.color-option').forEach(color => color.classList.remove('active'));
            element.classList.add('active');
        }

        function changeQuantity(amount) {
            let qtyInput = document.getElementById('quantity');
            let qty = parseInt(qtyInput.value) + amount;
            qtyInput.value = qty > 0 ? qty : 1;
        }
    </script>
@endsection
