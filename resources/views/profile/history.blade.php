@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar">
                @include('profile.includes.sidebar')
            </div>

            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Lịch sử đơn hàng</h4>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã Đơn Hàng</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Tổng Tiền</th>
                                    <th scope="col">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                {{-- @dd($orders) --}}
                                @forelse ($orders as $order)
                                    <tr>
                                        <th scope="row">{{ $index++ }}</th>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-yellow-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-yellow-800 tw-ring-1 tw-ring-yellow-600/20 tw-ring-inset">
                                                    Chưa thanh toán
                                                </span>
                                            @elseif($order->status == 'paid')
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-green-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-green-800 tw-ring-1 tw-ring-green-600/20 tw-ring-inset">
                                                    Đã thanh toán
                                                </span>
                                            @elseif($order->status == 'canceled')
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-red-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-red-800 tw-ring-1 tw-ring-red-600/20 tw-ring-inset">
                                                    Đã hủy
                                                </span>
                                            @elseif($order->status == 'fail')
                                                <span
                                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-gray-50 tw-px-2 tw-py-1 tw-text-xs tw-font-medium tw-text-gray-800 tw-ring-1 tw-ring-gray-600/20 tw-ring-inset">
                                                    Thất bại
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_price) }}₫</td>
                                        <td>
                                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#orderDetailModal{{ $order->id }}"><i
                                                    class="fa-solid fa-eye"></i></button>
                                            @if ($order->status == 'pending')
                                                <a href="#" class="btn btn-outline-secondary btn-sm"><i
                                                        class="fa-solid fa-ban"></i></a>
                                            @else
                                                <a href="#" class="btn btn-outline-secondary btn-sm"><i
                                                        class="fa-solid fa-rotate-left"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @foreach ($orders as $order)
                            <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
                                aria-labelledby="orderDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng
                                                #{{ $order->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
