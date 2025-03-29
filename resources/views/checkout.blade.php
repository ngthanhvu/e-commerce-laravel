@extends('layouts.main')

@section('content')
    <div class="container tw-mt-5">
        <h2 class="tw-mb-4 tw-text-2xl tw-font-bold">Thanh toán</h2>
        <div class="row">
            <!-- Thông tin khách hàng -->
            <div class="col-md-6">
                <h4 class="tw-text-lg tw-font-semibold">Thông tin khách hàng</h4>
                @if (!empty($addresses) && count($addresses) > 0)
                    <div id="existing-addresses" class="tw-mt-3 tw-border tw-p-3 tw-rounded">
                        @foreach ($addresses as $address)
                            <div class="form-check mb-2 rounded-3 d-flex align-items-center"
                                style="border: 1px solid #ccc; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                <input class="form-check-input me-2" type="radio" name="address_id"
                                    id="address{{ $address->id }}" value="{{ $address->id }}"
                                    {{ $loop->first ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="address{{ $address->id }}">
                                    <strong>{{ $address->name }} - {{ $address->phone }}</strong> <br>
                                    {{ $address->address }}
                                </label>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-link tw-mt-2 tw-p-0" id="toggle-address-form">Thêm địa chỉ
                            khác</button>
                    </div>
                @endif

                <!-- Form thêm địa chỉ mới -->
                <form action="{{ route('address.store') }}" method="POST" id="new-address-form"
                    style="display: {{ empty($addresses) ? 'block' : 'none' }};" class="tw-mt-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control tw-border-gray-300" name="name"
                            placeholder="Nhập họ và tên">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control tw-border-gray-300" name="phone"
                            placeholder="Nhập số điện thoại">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng</label>
                        <textarea class="form-control tw-border-gray-300" name="address" rows="3" placeholder="Nhập địa chỉ mới"></textarea>
                        <input type="hidden" name="user_id" value="{{ optional(Auth::user())->id }}">
                    </div>
                    <button type="submit" class="btn btn-dark">Thêm địa chỉ</button>
                </form>
            </div>

            <!-- Form Checkout -->
            <div class="col-md-6">
                <form action="/checkout/create" method="POST">
                    @csrf
                    <h4 class="tw-text-lg tw-font-semibold">Phương thức thanh toán</h4>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2">
                        <input class="form-check-input tw-me-2" type="radio" name="payment_method" id="cod"
                            value="cod" checked>
                        <label class="form-check-label tw-d-flex tw-align-items-center" for="cod">
                            <img src="https://cdn-icons-png.flaticon.com/512/2897/2897832.png" alt="COD"
                                class="tw-w-5 tw-h-5 tw-me-2">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2">
                        <input class="form-check-input tw-me-2" type="radio" name="payment_method" id="vnpay"
                            value="vnpay">
                        <label class="form-check-label tw-d-flex tw-align-items-center" for="vnpay">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s"
                                alt="VNPay" class="tw-w-5 tw-h-5 tw-me-2">
                            VNPay
                        </label>
                    </div>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2">
                        <input class="form-check-input tw-me-2" type="radio" name="payment_method" id="momo"
                            value="momo">
                        <label class="form-check-label tw-d-flex tw-align-items-center" for="momo">
                            <img src="https://play-lh.googleusercontent.com/uCtnppeJ9ENYdJaSL5av-ZL1ZM1f3b35u9k8EOEjK3ZdyG509_2osbXGH5qzXVmoFv0"
                                alt="MOMO" class="tw-w-5 tw-h-5 tw-me-2">
                            MOMO
                        </label>
                    </div>

                    <h4 class="tw-mt-4 tw-text-lg tw-font-semibold">Tóm tắt đơn hàng</h4>
                    <ul class="list-group tw-mb-3">
                        <li class="list-group-item tw-d-flex tw-justify-between">
                            <span>Sản phẩm 1</span>
                            <strong>250.000₫</strong>
                        </li>
                        <li class="list-group-item tw-d-flex tw-justify-between">
                            <span>Sản phẩm 2</span>
                            <strong>150.000₫</strong>
                        </li>
                        <li class="list-group-item">
                            <label for="coupon_code" class="tw-mb-1">Mã giảm giá</label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" class="form-control tw-border-gray-300"
                                    placeholder="Nhập mã giảm giá">
                                <button type="button" id="apply_coupon"
                                    class="btn btn-success tw-bg-green-600 hover:tw-bg-green-700">Áp dụng</button>
                            </div>
                            <small id="coupon_message" class="tw-text-red-500"></small>
                        </li>
                        <li class="list-group-item tw-d-flex tw-justify-between">
                            <strong>Phí vận chuyển</strong>
                            <strong id="shipping_fee_display">20.000₫</strong>
                        </li>
                        <li class="list-group-item tw-d-flex tw-justify-between">
                            <strong>Tổng cộng</strong>
                            <strong id="total_amount_display">420.000₫</strong>
                        </li>
                    </ul>

                    <button type="submit"
                        class="btn btn-primary tw-w-full tw-bg-blue-600 tw-text-white hover:tw-bg-blue-700">
                        Đặt hàng <i class="fa-solid fa-bag-shopping tw-ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script xử lý toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleAddressFormBtn = document.getElementById('toggle-address-form');
            const newAddressForm = document.getElementById('new-address-form');
            let isFormVisible = {{ empty($addresses) ? 'true' : 'false' }};

            if (toggleAddressFormBtn) {
                toggleAddressFormBtn.addEventListener('click', function() {
                    if (isFormVisible) {
                        newAddressForm.style.display = 'none';
                        toggleAddressFormBtn.textContent = 'Thêm địa chỉ khác';
                        document.querySelectorAll('input[name="address_id"]').forEach(input => {
                            if (input.checked) input.checked = true; // Giữ lựa chọn radio nếu có
                        });
                    } else {
                        newAddressForm.style.display = 'block';
                        toggleAddressFormBtn.textContent = 'Ẩn form thêm địa chỉ';
                        document.querySelectorAll('input[name="address_id"]').forEach(input => input
                            .checked = false);
                    }
                    isFormVisible = !isFormVisible;
                });
            }
        });
    </script>
@endsection
