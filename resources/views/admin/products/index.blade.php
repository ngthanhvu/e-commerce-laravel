@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Danh sách sản phẩm</h2>
    </div>
    @if (session('success'))
        <script>
            iziToast.success({
                title: 'Thành công',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            iziToast.error({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        </script>
    @endif
    <div class="p-3 mb-4 rounded-3 bg-light">
        <!-- Thanh điều hướng số dòng và tìm kiếm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.products.index') }}" id="entriesForm">
                    <label for="entriesPerPage" class="form-label">Hiển thị</label>
                    <select id="entriesPerPage" name="per_page" class="form-select d-inline w-auto"
                        style="width: auto; display: inline-block;"
                        onchange="document.getElementById('entriesForm').submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span> mục trên mỗi trang</span>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="col-md-3 offset-md-3">
                <form method="GET" action="{{ route('admin.products.index') }}" class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                        value="{{ $search }}" aria-label="Search">
                    <button class="btn btn-outline-secondary border-0" type="submit"><i class="bi bi-search"></i></button>
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        <!-- Bảng dữ liệu -->
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th scope="col"># <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Tên sản phẩm <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Danh mục <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Giá <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Hình ảnh <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Số lượng <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Biến thể <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Slug <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Thao tác <i class="bi bi-arrow-down-up"></i></th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Không có danh mục' }}</td>
                        <td>{{ number_format($product->price) }} đ</td>
                        <td>
                            @if ($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                    alt="{{ $product->name }}" style="width: 100px;">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if ($product->variants->isEmpty())
                                Không có
                            @else
                                @foreach ($product->variants as $variant)
                                    <div>
                                        <strong>{{ $variant->varriant_name }}</strong>
                                        - Giá: {{ number_format($variant->varriant_price) }} đ
                                        - SL: {{ $variant->varriant_quantity }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $product->slug }}</td>
                        <td>
                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-warning btn-sm edit-btn"><i
                                    class="bi bi-pencil-square"></i> Sửa</a>
                            <form action="/admin/products/{{ $product->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i>
                                    Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($products->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="row">
            <div class="col-md-6">
                <p>Hiển thị {{ $products->firstItem() }} đến {{ $products->lastItem() }} trong {{ $products->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $products->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $products->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $products->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Xử lý nút Xóa
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let categoryId = this.getAttribute("data-id");
                    let form = this.closest("form");

                    Swal.fire({
                        title: "Bạn có chắc chắn muốn xóa?",
                        text: "Dữ liệu này sẽ không thể khôi phục!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Xóa ngay!",
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Xử lý nút Sửa (Nếu muốn hiển thị cảnh báo khi bấm "Sửa")
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    let editUrl = this.getAttribute("href");

                    Swal.fire({
                        title: "Bạn có muốn chỉnh sửa?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Chỉnh sửa",
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                editUrl;
                        }
                    });
                });
            });
        });
    </script>
@endsection
