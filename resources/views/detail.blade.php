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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{ $product->category->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6">
                @if ($product->mainImage)
                    <img id="mainImage" src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                        class="product-image img-fluid" alt="{{ $product->name }}">
                @else
                    <img id="mainImage"
                        src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                        class="product-image img-fluid" alt="Không có ảnh">
                @endif
                <div class="mt-3 d-flex">
                    @forelse ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->sub_image) }}"
                            class="thumbnail mx-1 {{ $image->is_main ? 'active' : '' }}" onclick="changeImage(this)"
                            alt="{{ $product->name }}">
                    @empty
                        <p>Không có ảnh phụ nào.</p>
                    @endforelse
                </div>
            </div>

            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p class="text-muted">Danh mục: {{ $product->category->name }}</p>
                <h3 class="text-danger" id="productPrice">{{ number_format($product->price, 0, ',', '.') }}₫</h3>
                <p><strong>Tình trạng:</strong>
                    <span id="stockStatus" class="{{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
                        {{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                    </span>
                </p>

                <p><strong>Phiên bản:</strong></p>
                @forelse ($product->variants as $variant)
                    <button class="btn btn-outline-dark btn-sm variant-btn" data-variant-id="{{ $variant->id }}"
                        data-price="{{ $variant->varriant_price }}" data-quantity="{{ $variant->varriant_quantity }}"
                        onclick="selectVariant('{{ $variant->varriant_name }}', {{ $variant->varriant_price }}, {{ $variant->varriant_quantity }}, {{ $variant->id }})">
                        {{ $variant->varriant_name }}
                    </button>
                @empty
                    <p>Không có phiên bản nào.</p>
                @endforelse

                <p class="mt-3"><strong>Số lượng:</strong> <span id="stockQuantity">{{ $product->quantity }}</span></p>
                <div class="input-group" style="width: 120px;">
                    <button class="btn btn-outline-dark" onclick="changeQuantity(-1)">-</button>
                    <input type="text" class="form-control text-center" id="quantity" value="1">
                    <button class="btn btn-outline-dark" onclick="changeQuantity(1)">+</button>
                </div>

                <form id="addToCartForm" action="{{ route('carts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <input type="hidden" name="user_id" value="{{ optional(auth()->user())->id }}">
                    <input type="hidden" name="session_id" value="{{ session()->getId() }}">
                    <input type="hidden" name="price" id="priceInput" value="{{ $product->price }}">
                    <input type="hidden" name="variant_id" id="variantIdInput" value="">
                    <button type="submit" class="btn btn-dark w-50 mt-3"><i class="fa-solid fa-cart-shopping"></i> THÊM VÀO
                        GIỎ HÀNG</button>
                    <button type="button" class="btn btn-outline-danger mt-3"><i class="fa-solid fa-heart"></i> Yêu
                        thích</button>
                </form>
            </div>
        </div>

        <div class="mt-5" style="border-top: 1px solid #ccc; padding-top: 20px;">
            <h4>MÔ TẢ</h4>
            @if ($product->description == null)
                <p>Không có mô tả nào.</p>
            @else
                <div>{!! $product->description !!}</div>
            @endif
        </div>
    </div>

    <script>
        let maxQuantity = {{ $product->quantity }};
        let selectedPrice = {{ $product->price }};

        function changeImage(img) {
            document.getElementById('mainImage').src = img.src;
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            img.classList.add('active');
        }

        function selectVariant(name, price, quantity, variantId) {
            selectedPrice = price;
            document.getElementById('productPrice').textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(price);

            maxQuantity = quantity;
            document.getElementById('stockQuantity').textContent = quantity;
            document.getElementById('stockStatus').textContent = quantity > 0 ? 'Còn hàng' : 'Hết hàng';
            document.getElementById('stockStatus').className = quantity > 0 ? 'text-success' : 'text-danger';

            document.getElementById('variantIdInput').value = variantId;
            document.getElementById('priceInput').value = price;

            document.getElementById('quantity').value = 1;
            document.getElementById('quantityInput').value = 1;

            document.querySelectorAll('.variant-btn').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }

        function changeQuantity(amount) {
            let qtyInput = document.getElementById('quantity');
            let qtyCart = document.getElementById('quantityInput');
            let qty = parseInt(qtyInput.value) + amount;

            if (qty < 1) qty = 1;
            if (qty > maxQuantity) qty = maxQuantity;

            qtyInput.value = qty;
            qtyCart.value = qty;
        }
    </script>
@endsection
