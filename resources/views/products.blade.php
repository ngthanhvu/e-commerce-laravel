@extends('layouts.main')

@section('content')
    <style>
        .sidebar {
            padding: 20px;
            border-right: 1px solid #ddd;
            height: 100vh;
            position: sticky;
            top: 0;
        }

        .category-list .list-group-item {
            cursor: pointer;
        }

        .category-list .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .price-filter .form-range::-webkit-slider-thumb {
            background: #0d6efd;
        }

        .product-card {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: scale(1.05);
        }
    </style>
    <div class="container mt-3 mb-3">
        <div class="row">
            <!-- Sidebar (Bên trái - col-md-3) -->
            <div class="col-md-3 sidebar">
                <h4 class="mb-3">Danh Mục</h4>
                <div class="category-list">
                    <ul class="list-group">
                        <li class="list-group-item">Điện thoại</li>
                        <li class="list-group-item">Laptop</li>
                        <li class="list-group-item">Máy tính bảng</li>
                        <li class="list-group-item">Phụ kiện</li>
                    </ul>
                </div>

                <h4 class="mt-4 mb-3">Lọc Theo Giá</h4>
                <div class="price-filter">
                    <label for="priceRange" class="form-label">Khoảng giá: <span id="priceValue">0 - 10,000,000</span>
                        VNĐ</label>
                    <input type="range" class="form-range" min="0" max="10000000" step="100000" id="priceRange"
                        value="10000000" oninput="updatePrice(this.value)">
                    <button class="btn btn-primary mt-3 w-100">Áp dụng</button>
                </div>
            </div>

            <!-- Products (Bên phải - col-md-9) -->
            <div class="col-md-9">
                <!-- Thanh tìm kiếm và sắp xếp -->
                <div class="row mb-4">
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                            <button class="btn btn-outline-primary" type="button" id="searchButton">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="sortSelect">
                            <option value="">Sắp xếp theo</option>
                            <option value="name-az">Tên (A-Z)</option>
                            <option value="name-za">Tên (Z-A)</option>
                            <option value="price-high-low">Giá (Cao đến Thấp)</option>
                            <option value="price-low-high">Giá (Thấp đến Cao)</option>
                        </select>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="row" id="productList">
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 product-card">
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                class="card-img-top" alt="Keycap Artisan Natra">
                            <div class="card-body text-center">
                                <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                                <h5 class="card-subtitle mb-2">KEYCAP ARTISAN NF NATRA</h5>
                                <p class="card-text">250.000₫</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 product-card">
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                class="card-img-top" alt="Keycap Artisan Natra">
                            <div class="card-body text-center">
                                <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                                <h5 class="card-subtitle mb-2">KEYCAP ARTISAN NF NATRA</h5>
                                <p class="card-text">250.000₫</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 product-card">
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                class="card-img-top" alt="Keycap Artisan Natra">
                            <div class="card-body text-center">
                                <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                                <h5 class="card-subtitle mb-2">KEYCAP ARTISAN NF NATRA</h5>
                                <p class="card-text">250.000₫</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-0 product-card">
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                class="card-img-top" alt="Keycap Artisan Natra">
                            <div class="card-body text-center">
                                <span class="card-title text-muted" style="font-size: 13px">KEYCAP LÊ</span>
                                <h5 class="card-subtitle mb-2">KEYCAP ARTISAN NF NATRA</h5>
                                <p class="card-text">250.000₫</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
