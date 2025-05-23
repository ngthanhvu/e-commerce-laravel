@extends('layouts.admin')

@section('content')
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-3 bg-white tw-rounded-[15px] tw-pt-3 tw-pl-4">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Quản lý đơn hàng</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các đơn hàng đang có!</p>
        </div>
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
                <form method="GET" action="#" id="entriesForm">
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
                <form method="GET" action="#">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                        value="{{ $search }}" aria-label="Search">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Đơn hàng ID</th>
                    <th scope="col">Phương thức thanh toán</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">Thời gian tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @php
                    $index = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @if ($order->status == 'pending')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-yellow-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-yellow-800 tw-ring-1 tw-ring-yellow-600/20 tw-ring-inset">Chưa
                                    thanh toán</span>
                            @elseif($order->status == 'paid')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-green-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-green-800 tw-ring-1 tw-ring-green-600/20 tw-ring-inset">Đã
                                    thanh toán</span>
                            @elseif($order->status == 'cancelled')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-red-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-red-800 tw-ring-1 tw-ring-red-600/20 tw-ring-inset">Đã
                                    hủy</span>
                            @elseif($order->status == 'delivered')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-purple-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-purple-800 tw-ring-1 tw-ring-purple-600/20 tw-ring-inset">Đã
                                    giao hàng</span>
                            @elseif($order->status == 'fail')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-red-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-red-800 tw-ring-1 tw-ring-red-600/20 tw-ring-inset">Thất
                                    bại</span>
                            @elseif($order->status == 'canceled')
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-red-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-red-800 tw-ring-1 tw-ring-red-600/20 tw-ring-inset">Đã
                                    hủy</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->total_price) }}₫</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#orderDetailModal{{ $order->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>

                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editOrderModal{{ $order->id }}" data-id="{{ $order->id }}">
                                    <i class="fa-solid fa-gear"></i>
                                </button>


                                <form action="{{ Route('admin.orders.destroy', $order->id) }}" method="POST"
                                    class="d-inline-block m-0 delete-order-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                                <a href="{{ route('orders.printInvoice', $order->id) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm no-loading">
                                    <i class="fa fa-print"></i> In hóa đơn
                                </a>

                            </div>
                        </td>

                    </tr>
                @endforeach
                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="bi bi-inbox tw-text-[40px]"></i><br>
                            Không có đơn hàng nào
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- modal --}}
        @foreach ($orders as $order)
            <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="orderDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
                            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }}₫</p>

                            <h5>Sản phẩm trong đơn hàng:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price) }}₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- modal edit startus --}}
            <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="editOrderModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editOrderModalLabel{{ $order->id }}">Chỉnh sửa trạng thái
                                    đơn
                                    hàng #{{ $order->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chưa
                                            thanh
                                            toán</option>
                                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh
                                            toán
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã
                                            hủy
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã
                                            giao hàng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Phân trang -->
        <div class="row">
            <div class="col-md-6">
                <p>Hiển thị {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} trong {{ $orders->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $orders->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>

                        <!-- Các trang -->
                        @for ($i = 1; $i <= $orders->lastPage(); $i++)
                            <li class="page-item {{ $orders->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $orders->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Nút Next -->
                        <li class="page-item {{ $orders->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $orders->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteForms = document.querySelectorAll('.delete-order-form');

            deleteForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // chặn form submit

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xoá đơn hàng này?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Vâng, xoá đi!',
                        cancelButtonText: 'Hủy bỏ'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // tiếp tục submit nếu xác nhận
                        }
                    });
                });
            });
        });
    </script>
@endsection
