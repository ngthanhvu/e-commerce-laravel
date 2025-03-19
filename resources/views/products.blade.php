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

        .category-tree {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-item {
            margin: 5px 0;
        }

        .category-link {
            display: block;
            padding: 8px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .category-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        .category-link.active {
            background-color: #0d6efd;
            color: white;
        }

        .category-subtree {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-name {
            font-size: 14px;
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
            <div class="col-md-3 sidebar">
                <h4 class="mb-3">Danh Mục</h4>
                @include('partials.category-accordion', [
                    'categories' => $categories,
                    'categoryId' => $categoryId,
                ])

                <h4 class="mt-4 mb-3">Lọc Theo Giá</h4>
                <div class="price-filter">
                    <form id="priceFilterForm" method="GET" action="{{ route('products') }}">
                        <label for="priceRange" class="form-label">Khoảng giá: <span
                                id="priceValue">{{ number_format($priceMax, 0, ',', '.') }}</span> VNĐ</label>
                        <input type="range" class="form-range" min="0" max="10000000" step="100000"
                            id="priceRange" name="price_max" value="{{ $priceMax }}" oninput="updatePrice(this.value)">
                        <input type="hidden" name="category_id" value="{{ $categoryId }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <button type="submit" class="btn btn-primary mt-3 w-100">Áp dụng</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row mb-4">
                    <div class="col-md-9">
                        <form id="searchForm" method="GET" action="{{ route('products') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                                    id="searchInput" name="search" value="{{ $search }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                                <input type="hidden" name="price_max" value="{{ $priceMax }}">
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form id="sortForm" method="GET" action="{{ route('products') }}">
                            <select class="form-select" id="sortSelect" name="sort" onchange="this.form.submit()">
                                <option value="">Sắp xếp theo</option>
                                <option value="name-az" {{ $sort == 'name-az' ? 'selected' : '' }}>Tên (A-Z)</option>
                                <option value="name-za" {{ $sort == 'name-za' ? 'selected' : '' }}>Tên (Z-A)</option>
                                <option value="price-high-low" {{ $sort == 'price-high-low' ? 'selected' : '' }}>Giá (Cao
                                    đến Thấp)</option>
                                <option value="price-low-high" {{ $sort == 'price-low-high' ? 'selected' : '' }}>Giá (Thấp
                                    đến Cao)</option>
                            </select>
                            <input type="hidden" name="category_id" value="{{ $categoryId }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="price_max" value="{{ $priceMax }}">
                        </form>
                    </div>
                </div>

                <div class="row" id="productList">
                    @forelse ($products as $product)
                        <div class="col-md-3 mb-3">
                            <a href="/chi-tiet/{{ $product->slug }}" class="text-decoration-none text-dark">
                                <div class="card border-0 product-card">
                                    @if ($product->mainImage)
                                        <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                            class="card-img-top" alt="{{ $product->name }}">
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
                    @empty
                        <div class="col-12 text-center">
                            <p>Không tìm thấy sản phẩm nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePrice(value) {
            document.getElementById('priceValue').innerText = new Intl.NumberFormat('vi-VN').format(value);
        }
    </script>
@endsection
