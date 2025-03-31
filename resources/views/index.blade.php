@extends('layouts.main')

@section('content')
    <style>
        .card {
            transition: all 0.3s ease-in-out;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
        }

        .card:hover {
            border: 1px solid #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .card-body {
            padding: 15px;
        }

        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .card-title {
            font-size: 13px;
            color: #6c757d;
        }

        .card-subtitle {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin: 5px 0;
        }

        .card-text {
            font-size: 16px;
            color: #e74c3c;
            font-weight: bold;
        }

        .original-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
            margin-right: 8px;
        }

        .discount-price {
            font-size: 16px;
            color: #e74c3c;
            font-weight: bold;
        }
    </style>

    <div id="carouselExample" class="carousel slide mx-auto" data-bs-ride="carousel" style="width: 80%">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/slider_1.jpg?1741705947617"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/slider_3.jpg?1741705947617"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://bizweb.dktcdn.net/100/436/596/themes/980306/assets/slider_4.jpg?1741705947617"
                    class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-4">
        <!-- Phần Sản phẩm mới -->
        <section class="new-products border p-4 rounded-2 mb-4"
            style="min-height: 500px; background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);">
            <h2 class="text-center text-uppercase mb-4 mt-3">Sản phẩm mới</h2>
            @if (count($products) > 4)
                <div class="swiper product-swiper-new">
                    <div class="swiper-wrapper">
                        @php
                            $chunks = $products->chunk(4);
                        @endphp
                        @foreach ($chunks as $chunk)
                            <div class="swiper-slide">
                                <div class="row">
                                    @foreach ($chunk as $product)
                                        <div class="col-md-3 col-6">
                                            <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                                <div class="card">
                                                    @if ($product->mainImage)
                                                        <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                            class="card-img-top" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                            class="card-img-top" alt="Keycap Artisan Natra">
                                                    @endif
                                                    <div class="card-body text-center">
                                                        <span class="card-title">{{ $product->category['name'] }}</span>
                                                        <h5 class="card-subtitle ellipsis">{{ $product->name }}</h5>
                                                        <p class="card-text">
                                                            @if (isset($product->discount_price) && $product->discount_price < $product->price)
                                                                <span
                                                                    class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                                <span
                                                                    class="discount-price">{{ number_format($product->discount_price, 0, ',', '.') }}₫</span>
                                                            @else
                                                                <span
                                                                    class="discount-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev" style="color: #333;"></div>
                    <div class="swiper-button-next" style="color: #333;"></div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="row mt-3">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                <div class="card">
                                    @if ($product->mainImage)
                                        <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                            class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                            class="card-img-top" alt="Keycap Artisan Natra">
                                    @endif
                                    <div class="card-body text-center">
                                        <span class="card-title">{{ $product->category['name'] }}</span>
                                        <h5 class="card-subtitle ellipsis">{{ $product->name }}</h5>
                                        <p class="card-text">
                                            @if (isset($product->discount_price) && $product->discount_price < $product->price)
                                                <span
                                                    class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                <span
                                                    class="discount-price">{{ number_format($product->discount_price, 0, ',', '.') }}₫</span>
                                            @else
                                                <span
                                                    class="discount-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Phần sản phẩm theo danh mục -->
        @foreach ($categories as $category)
            <section class="new-products p-3 rounded-2 mb-4" style="min-height: 500px;">
                <h2 class="text-center text-uppercase mb-3">{{ $category->name }}</h2>
                @if ($category->products->count() > 4)
                    <div class="swiper product-swiper-{{ $category->id }}">
                        <div class="swiper-wrapper">
                            @php
                                $chunks = $category->products->chunk(4);
                            @endphp
                            @foreach ($chunks as $chunk)
                                <div class="swiper-slide">
                                    <div class="row">
                                        @foreach ($chunk as $product)
                                            <div class="col-md-3 col-6 mb-3">
                                                <a href="/chi-tiet/{{ $product->slug }}"
                                                    class="text-decoration-none text-dark">
                                                    <div class="card">
                                                        @if ($product->mainImage)
                                                            <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                                class="card-img-top" alt="{{ $product->name }}">
                                                        @else
                                                            <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                                class="card-img-top" alt="Keycap Artisan Natra">
                                                        @endif
                                                        <div class="card-body text-center">
                                                            <span class="card-title">{{ $category->name }}</span>
                                                            <h5 class="card-subtitle ellipsis">{{ $product->name }}</h5>
                                                            <p class="card-text">
                                                                @if (isset($product->discount_price) && $product->discount_price < $product->price)
                                                                    <span
                                                                        class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                                    <span
                                                                        class="discount-price">{{ number_format($product->discount_price, 0, ',', '.') }}₫</span>
                                                                @else
                                                                    <span
                                                                        class="discount-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev" style="color: #333;"></div>
                        <div class="swiper-button-next" style="color: #333;"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row mt-3">
                        @foreach ($category->products as $product)
                            <div class="col-md-3 col-6 mb-3">
                                <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                    <div class="card">
                                        @if ($product->mainImage)
                                            <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                class="card-img-top" alt="{{ $product->name }}">
                                        @else
                                            <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                class="card-img-top" alt="Keycap Artisan Natra">
                                        @endif
                                        <div class="card-body text-center">
                                            <span class="card-title">{{ $category->name }}</span>
                                            <h5 class="card-subtitle ellipsis">{{ $product->name }}</h5>
                                            <p class="card-text">
                                                @if (isset($product->discount_price) && $product->discount_price < $product->price)
                                                    <span
                                                        class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                    <span
                                                        class="discount-price">{{ number_format($product->discount_price, 0, ',', '.') }}₫</span>
                                                @else
                                                    <span
                                                        class="discount-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
                <button class="btn btn-dark text-center mx-auto d-block mt-3">Xem thêm</button>
            </section>
        @endforeach
    </div>

    @if (count($products) > 4 || $categories->pluck('products')->flatten()->count() > 4)
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (count($products) > 4)
                    var swiperNew = new Swiper('.product-swiper-new', {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            clickable: true,
                        },
                    });
                @endif

                @foreach ($categories as $category)
                    @if ($category->products->count() > 4)
                        var swiper{{ $category->id }} = new Swiper('.product-swiper-{{ $category->id }}', {
                            slidesPerView: 1,
                            spaceBetween: 20,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            pagination: {
                                clickable: true,
                            },
                        });
                    @endif
                @endforeach
            });
        </script>
    @endif
@endsection
