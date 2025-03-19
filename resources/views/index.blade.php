@extends('layouts.main')

@section('content')
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
        <section class="new-products border p-3 rounded-2">
            <h2 class="text-center text-uppercase mb-3">Sản phẩm mới</h2>
            <div class="row mt-3">
                @foreach ($products as $product)
                    <div class="col-md-3 col-6 mb-3">
                        <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                            <div class="card border-0">
                                @if ($product->mainImage)
                                    <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}" class="card-img-top"
                                        alt="{{ $product->name }}">
                                @else
                                    <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                        class="card-img-top" alt="Keycap Artisan Natra">
                                @endif
                                <div class="card-body text-center">
                                    <span class="card-title text-muted"
                                        style="font-size: 13px">{{ $product->category['name'] }}</span>
                                    <h5 class="card-subtitle mb-2">{{ $product->name }}</h5>
                                    <p class="card-text">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-dark text-center mx-auto d-block">Xem thêm</button>
        </section>
    </div>
@endsection
