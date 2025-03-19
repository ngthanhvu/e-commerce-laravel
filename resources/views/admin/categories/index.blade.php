@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Danh sách danh mục</h2>
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
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="/admin/categories/create" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tạo danh mục</a>
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
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th scope="col"># <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Tên danh mục <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Mota <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Hinh anh <i class="bi bi-arrow-down-up"></i></th>
                    <th scope="col">Thao tác <i class="bi bi-arrow-down-up"></i></th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                style="width: 100px" class="border"></td>
                        <td>
                            <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-warning btn-sm"><i
                                    class="bi bi-pencil-square"></i> Sửa</a>
                            <form action="/admin/categories/{{ $category->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>
                                    Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($categories->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Không có danh mục nào</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="row">
            <div class="col-md-6">
                <p>Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong
                    {{ $categories->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $categories->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>

                        <!-- Các trang -->
                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                            <li class="page-item {{ $categories->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $categories->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Nút Next -->
                        <li class="page-item {{ $categories->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $categories->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
