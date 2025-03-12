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
                <div class="col-md-3 mb-3">
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
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                <div class="col-md-3">
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
            <button class="btn btn-dark text-center mx-auto d-block">Xem thêm</button>
        </section>
    </div>
@endsection
