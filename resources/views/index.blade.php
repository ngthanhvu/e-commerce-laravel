@extends('layouts.main')

@section('content')
    <style>
        .card {
            transition: border 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            border: 1px solid #ffffff !important;
            /* box-shadow: 0px 2px 5px #333333; */
        }

        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
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
                                                <div class="card border-0" style="background-color: transparent">
                                                    @if ($product->mainImage)
                                                        <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                            class="card-img-top" alt="{{ $product->name }}"
                                                            style="width: 100%; height: 300px; object-fit: cover; border: 1px solid #ccc; border-radius: 10px">
                                                    @else
                                                        <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                            class="card-img-top" alt="Keycap Artisan Natra">
                                                    @endif
                                                    <div class="card-body text-center">
                                                        <span class="card-title" style="font-size: 14px">
                                                            {{ $product->category['name'] }}
                                                        </span>
                                                        <h5
                                                            class="card-subtitle mb-2 tw-text-[20px] tw-uppercase tw-tracking-widest mt-1 ellipsis">
                                                            {{ $product->name }}
                                                        </h5>
                                                        <p class="card-text">
                                                            {{ number_format($product->price, 0, ',', '.') }}₫</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation buttons -->
                    <div class="swiper-button-prev" style="color: #007bff;"></div>
                    <div class="swiper-button-next" style="color: #007bff;"></div>
                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="row mt-3">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                <div class="card border-0">
                                    @if ($product->mainImage)
                                        <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                            class="card-img-top" alt="{{ $product->name }}"
                                            style="width: 100%; height: 300px; object-fit: cover; border: 1px solid #ccc; border-radius: 10px">
                                    @else
                                        <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                            class="card-img-top" alt="Keycap Artisan Natra">
                                    @endif
                                    <div class="card-body text-center">
                                        <span class="card-title text-muted" style="font-size: 13px">
                                            {{ $product->category['name'] }}
                                        </span>
                                        <h5 class="card-subtitle mb-2 ellipsis">{{ $product->name }}</h5>
                                        <p class="card-text">{{ number_format($product->price, 0, ',', '.') }}₫</p>
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
                                                    <div class="card border-0">
                                                        @if ($product->mainImage)
                                                            <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                                class="card-img-top" alt="{{ $product->name }}"
                                                                style="width: 100%; height: 300px; object-fit: cover; border: 1px solid #ccc; border-radius: 10px">
                                                        @else
                                                            <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                                class="card-img-top" alt="Keycap Artisan Natra">
                                                        @endif
                                                        <div class="card-body text-center">
                                                            <span class="card-title text-muted" style="font-size: 13px">
                                                                {{ $category->name }}
                                                            </span>
                                                            <h5 class="card-subtitle mb-2 ellipsis">{{ $product->name }}
                                                            </h5>
                                                            <p class="card-text">
                                                                {{ number_format($product->price, 0, ',', '.') }}₫</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Navigation buttons -->
                        <div class="swiper-button-prev" style="color: #007bff;"></div>
                        <div class="swiper-button-next" style="color: #007bff;"></div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="row mt-3">
                        @foreach ($category->products as $product)
                            <div class="col-md-3 col-6 mb-3">
                                <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                    <div class="card border-0">
                                        @if ($product->mainImage)
                                            <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                                class="card-img-top" alt="{{ $product->name }}"
                                                style="width: 100%; height: 300px; object-fit: cover; border: 1px solid #ccc; border-radius: 10px">
                                        @else
                                            <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                                class="card-img-top" alt="Keycap Artisan Natra">
                                        @endif
                                        <div class="card-body text-center">
                                            <span class="card-title text-muted" style="font-size: 13px">
                                                {{ $category->name }}
                                            </span>
                                            <h5 class="card-subtitle mb-2 ellipsis">{{ $product->name }}</h5>
                                            <p class="card-text">{{ number_format($product->price, 0, ',', '.') }}₫</p>
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

    <!-- Thêm Swiper CSS và JS -->
    @if (count($products) > 4 || $categories->pluck('products')->flatten()->count() > 4)
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Swiper cho Sản phẩm mới
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

                // Swiper cho từng danh mục
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
