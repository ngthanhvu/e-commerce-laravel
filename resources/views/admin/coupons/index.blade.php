@extends('layouts.admin')

@section('content')
    <div class="tw-flex tw-justify-between tw-items-center tw-p-3 bg-white tw-rounded-[15px] mb-3">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Quản lý mã giảm giá</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các mã giảm giá đang có!</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-plus tw-mr-1"></i> Tạo mã giảm giá mới
        </a>
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
    <div class="bg-white tw-p-5 tw-rounded-[15px]">
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.coupons.index') }}" id="entriesForm">
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
                <form method="GET" action="{{ route('admin.coupons.index') }}">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                        value="{{ $search }}" aria-label="Search">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th scope="col"># </th>
                    <th scope="col">Mã giảm giá</th>
                    <th scope="col">Giá giảm </th>
                    <th scope="col">Loại giảm </th>
                    <th scope="col">Số tiền giảm </th>
                    <th scope="col">Giới hạn dùng </th>
                    <th scope="col">Số lần dùng </th>
                    <th scope="col">Thời gian tạo </th>
                    <th scope="col">Thời gian kết thúc </th>
                    <th scope="col">Thao tác </th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @php
                    $index = 1;
                @endphp
                @foreach ($coupons as $coupon)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->min_order_amount ?? 0 }}</td>
                        <td>{{ $coupon->type }}</td>
                        <td>{{ $coupon->discount }}</td>
                        <td>{{ $coupon->max_usage }}</td>
                        <td>{{ $coupon->used_count }}</td>
                        <td>{{ $coupon->start_date }}</td>
                        <td>{{ $coupon->end_date }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="/admin/coupons/{{ $coupon->id }}/edit"
                                    class="btn btn-outline-secondary btn-sm me-1"><i class="fa fa-edit"></i></a>
                                <form action="/admin/coupons/{{ $coupon->id }}/delete" method="POST"
                                    onsubmit="confirmDelete(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if ($coupons->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">
                            <i class="bi bi-inbox tw-text-[40px]"></i><br>
                            Không có mã giảm giá nào
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="row">
            <div class="col-md-6">
                <p>Hiển thị {{ $coupons->firstItem() }} đến {{ $coupons->lastItem() }} trong {{ $coupons->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $coupons->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $coupons->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>

                        <!-- Các trang -->
                        @for ($i = 1; $i <= $coupons->lastPage(); $i++)
                            <li class="page-item {{ $coupons->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $coupons->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Nút Next -->
                        <li class="page-item {{ $coupons->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $coupons->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        const confirmDelete = (event, form) => {
            event.preventDefault(); // Ngăn chặn form submit ngay lập tức

            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Hành động này không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Có, xóa ngay!",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Chỉ submit form nếu người dùng xác nhận
                }
            });
        };
    </script>
@endsection
