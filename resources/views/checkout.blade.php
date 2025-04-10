@extends('layouts.main')

@section('content')
    <style>
        .steps {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 20px auto;
        }

        .step {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .step i {
            font-size: 2em;
            color: #007bff;
            margin-bottom: 10px;
        }

        .step p {
            margin: 0;
            font-size: 1.1em;
        }

        .arrow {
            font-size: 1.5em;
            color: #666;
        }

        .step.active i {


            color: #28a745;
        }

        .address-form .d-flex {
            flex-wrap: wrap;
            gap: 10px;
        }

        .address-form .w-50 {
            flex: 1;
            min-width: 48%;
        }
    </style>
    <div class="container tw-mt-5">
        <div class="steps">
            <div class="step active">
                <i class="fas fa-shopping-cart"></i>
                <p class="text-success">Giỏ hàng</p>
            </div>
            <span class="arrow text-success"><i class="fas fa-arrow-right"></i></span>
            <div class="step active">
                <i class="fas fa-credit-card"></i>
                <p class="text-success">Thanh toán</p>
            </div>
            <span class="arrow"><i class="fas fa-arrow-right"></i></span>
            <div class="step">
                <i class="fas fa-check-circle"></i>
                <p>Thành công</p>
            </div>
        </div>
        <h2 class="tw-mb-4 tw-text-[30px] tw-font-bold text-center">Thanh toán</h2>
        <div class="row">
            <!-- Thông tin khách hàng -->
            <div class="col-md-6">
                <h4 class="tw-text-lg tw-font-semibold">Thông tin khách hàng</h4>
                @if (!empty($addresses) && count($addresses) > 0)
                    <div id="existing-addresses" class="tw-mt-3 tw-border tw-p-3 tw-rounded">
                        @foreach ($addresses as $address)
                            <div class="form-check mb-2 rounded-3 d-flex align-items-center"
                                style="border: 1px solid #ccc; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                <input class="form-check-input me-2" type="radio" name="address_id_temp"
                                    id="address{{ $address->id }}" value="{{ $address->id }}"
                                    {{ $loop->first ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="address{{ $address->id }}">
                                    <strong>{{ $address->name }} - {{ $address->phone }}</strong> <br>
                                    {{ $address->street }} - {{ $address->ward }} - {{ $address->district }} -
                                    {{ $address->province }}
                                </label>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-link tw-mt-2 tw-p-0" id="toggle-address-form">Thêm địa chỉ
                            khác</button>
                    </div>
                @endif
                @if (empty($addresses) || count($addresses) == 0)
                    <div class="alert alert-danger" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i> Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ giao
                        hàng.
                    </div>
                    <button type="button" class="btn btn-link tw-mt-2 tw-p-0" id="toggle-address-form">Thêm địa chỉ
                        khác</button>
                @endif

                <!-- Form thêm địa chỉ mới -->
                <form action="{{ route('address.store') }}" method="POST" id="new-address-form"
                    style="display: {{ empty($addresses) ? 'block' : 'none' }};" class="tw-mt-3 address-form">
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
                        <div class="d-flex">
                            <div class="w-50">
                                <label for="province">Tỉnh/Thành phố</label>
                                <select class="form-control form-select tw-border-gray-300" id="province">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                </select>
                            </div>
                            <div class="w-50">
                                <label for="district">Quận/Huyện</label>
                                <select class="form-control form-select tw-border-gray-300" id="district">
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-50">
                                <label for="ward">Xã/Phường</label>
                                <select class="form-control form-select tw-border-gray-300" id="ward">
                                    <option value="">Chọn xã/phường</option>
                                </select>
                            </div>
                            <div class="w-50">
                                <label for="street">Số nhà, tên đường</label>
                                <input type="text" class="form-control tw-border-gray-300" id="street" name="street"
                                    placeholder="Nhập số nhà, tên đường">
                            </div>
                        </div>
                    </div>

                    <!-- Các input ẩn để gửi tên thay vì ID -->
                    <input type="hidden" name="province" id="province_name">
                    <input type="hidden" name="district" id="district_name">
                    <input type="hidden" name="ward" id="ward_name">
                    <input type="hidden" name="user_id" value="{{ optional(Auth::user())->id }}">
                    <input type="hidden" name="address" id="full_address">

                    <button type="submit" class="btn btn-dark">Thêm địa chỉ</button>
                </form>
            </div>

            <!-- Form Checkout -->
            <div class="col-md-6">
                <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                    @csrf
                    <h4 class="tw-text-lg tw-font-semibold">Phương thức thanh toán</h4>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2"
                        style="border: 1px solid #ccc; padding-left: 30px; padding-top: 10px; padding-bottom: 10px; border-radius: 5px;">
                        <input class="form-check-input tw-me-2" type="radio" name="payment_method" id="cod"
                            value="cod" checked>
                        <label class="form-check-label tw-d-flex tw-align-items-center" for="cod">
                            <img src="https://cdn-icons-png.flaticon.com/512/2897/2897832.png" alt="COD"
                                class="tw-w-5 tw-h-5 tw-me-2">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2"
                        style="border: 1px solid #ccc; padding-left: 30px; padding-top: 10px; padding-bottom: 10px; border-radius: 5px;">
                        <input class="form-check-input tw-me-2" type="radio" name="payment_method" id="vnpay"
                            value="vnpay">
                        <label class="form-check-label tw-d-flex tw-align-items-center" for="vnpay">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s"
                                alt="VNPay" class="tw-w-5 tw-h-5 tw-me-2">
                            VNPay
                        </label>
                    </div>
                    <div class="form-check tw-d-flex tw-align-items-center tw-mb-2"
                        style="border: 1px solid #ccc; padding-left: 30px; padding-top: 10px; padding-bottom: 10px; border-radius: 5px;">
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
                        @forelse ($carts as $cart)
                            <li class="list-group-item tw-d-flex tw-justify-between tw-align-items-center">
                                <div class="tw-d-flex tw-align-items-center tw-gap-3">
                                    @if ($cart->product->mainImage)
                                        <img src="{{ asset('storage/' . $cart->product->mainImage->sub_image) }}"
                                            alt="{{ $cart->product->name }}" class="product-image" width="50"
                                            height="50" style="border: 1px solid #ccc">
                                    @else
                                        <img src="https://img.freepik.com/free-vector/page-found-concept-illustration_114360-1869.jpg"
                                            alt="Default" class="product-image" width="50">
                                    @endif
                                    <span>{{ $cart->product->name }} (x{{ $cart->quantity }})</span>
                                </div>
                                <strong
                                    class="tw-absolute tw-right-4 tw-top-1/2 tw-transform -tw-translate-y-1/2">{{ number_format($cart->price * $cart->quantity) }}₫</strong>
                            </li>
                        @empty
                            <li class="list-group-item">Không có sản phẩm nào trong giỏ hàng</li>
                        @endforelse
                        <li class="list-group-item tw-d-flex tw-justify-between">
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
                            <strong
                                id="total_amount_display">{{ number_format($carts->sum(fn($cart) => $cart->price * $cart->quantity) + 20000) }}₫</strong>
                        </li>
                    </ul>

                    <!-- Hidden inputs để gửi dữ liệu -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="address_id" id="address_id"
                        value="{{ $addresses->first()->id ?? '' }}">
                    <input type="hidden" name="shipping_fee" id="shipping_fee" value="20000">
                    <input type="hidden" name="total_amount" id="total_amount"
                        value="{{ $carts->sum(fn($cart) => $cart->price * $cart->quantity) + 20000 }}">
                    <input type="hidden" name="discount" id="discount" value="0">
                    <button type="submit"
                        class="btn btn-primary tw-w-full tw-bg-blue-600 tw-text-white hover:tw-bg-blue-700">
                        Đặt hàng <i class="fa-solid fa-bag-shopping tw-ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const toggleAddressFormBtn = document.getElementById("toggle-address-form");
            const newAddressForm = document.getElementById("new-address-form");
            const addressIdInput = document.getElementById("address_id");
            let isFormVisible = {{ empty($addresses) ? 'true' : 'false' }};

            const GHN_TOKEN = "c0da72a0-0ea6-11f0-9f28-eacfdef119b3"; // Thay bằng token thực tế của bạn
            const SHOP_ID = "196271"; // Thay bằng ShopId thực tế của bạn

            async function fetchData(url, method = "GET", body = null) {
                try {
                    const headers = {
                        "Content-Type": "application/json",
                        "Token": GHN_TOKEN
                    };
                    if (method === "POST") headers["ShopId"] = SHOP_ID;

                    const response = await fetch(url, {
                        method,
                        headers,
                        body: body ? JSON.stringify(body) : null
                    });
                    return await response.json();
                } catch (error) {
                    console.error("Lỗi khi gọi API:", error);
                    return null;
                }
            }

            async function loadProvinces() {
                const data = await fetchData(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province");
                if (data && data.code === 200) {
                    const provinceSelect = document.getElementById("province");
                    provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>';
                    data.data.forEach(province => {
                        const option = document.createElement("option");
                        option.value = province.ProvinceID; // ID để tính phí ship
                        option.text = province.ProvinceName;
                        option.dataset.name = province.ProvinceName; // Tên để gửi lên server
                        provinceSelect.appendChild(option);
                    });
                }
            }

            async function loadDistricts(provinceId) {
                const districtSelect = document.getElementById("district");
                const wardSelect = document.getElementById("ward");

                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

                if (!provinceId) return;

                const data = await fetchData(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district");
                if (data && data.code === 200) {
                    const districts = data.data.filter(d => d.ProvinceID == provinceId);
                    districts.forEach(district => {
                        const option = document.createElement("option");
                        option.value = district.DistrictID; // ID để tính phí ship
                        option.text = district.DistrictName;
                        option.dataset.name = district.DistrictName; // Tên để gửi lên server
                        districtSelect.appendChild(option);
                    });
                }
            }

            async function loadWards(districtId) {
                const wardSelect = document.getElementById("ward");
                wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

                if (!districtId) return;

                const data = await fetchData(
                    `https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id=${districtId}`
                );
                if (data && data.code === 200) {
                    data.data.forEach(ward => {
                        const option = document.createElement("option");
                        option.value = ward.WardCode; // ID để tính phí ship
                        option.text = ward.WardName;
                        option.dataset.name = ward.WardName; // Tên để gửi lên server
                        wardSelect.appendChild(option);
                    });
                }
            }

            async function calculateShippingFee(fromDistrictId, toDistrictId, toWardCode) {
                const shippingFeeDisplay = document.getElementById("shipping_fee_display");
                const shippingFeeInput = document.getElementById("shipping_fee");
                const totalAmountDisplay = document.getElementById("total_amount_display");
                const totalAmountInput = document.getElementById("total_amount");

                const payload = {
                    "from_district_id": parseInt(fromDistrictId),
                    "to_district_id": parseInt(toDistrictId),
                    "to_ward_code": toWardCode,
                    "service_type_id": 2,
                    "weight": 1000,
                    "length": 20,
                    "width": 20,
                    "height": 20,
                    "insurance_value": 0,
                    "coupon": null
                };

                const data = await fetchData(
                    "https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee", "POST",
                    payload);
                if (data && data.code === 200) {
                    const shippingFee = data.data.total;
                    shippingFeeInput.value = shippingFee;
                    shippingFeeDisplay.textContent = shippingFee.toLocaleString() + "₫";

                    let subtotal = {{ $carts->sum(fn($cart) => $cart->price * $cart->quantity) }};
                    let discount = parseInt(document.getElementById("discount").value) || 0;
                    let newTotal = subtotal + shippingFee - discount;
                    totalAmountInput.value = newTotal;
                    totalAmountDisplay.textContent = newTotal.toLocaleString() + "₫";
                } else {
                    shippingFeeDisplay.textContent = "Không tính được phí ship!";
                }
            }

            const applyCouponBtn = document.getElementById("apply_coupon");
            const couponCodeInput = document.getElementById("coupon_code");
            const couponMessage = document.getElementById("coupon_message");
            const totalAmountDisplay = document.getElementById("total_amount_display");
            const shippingFeeDisplay = document.getElementById("shipping_fee_display");
            const shippingFeeInput = document.getElementById("shipping_fee");
            const totalAmountInput = document.getElementById("total_amount");
            const discountInput = document.getElementById("discount");

            let shippingFee = parseInt(shippingFeeInput.value);
            let originalSubtotal = {{ $carts->sum(fn($cart) => $cart->price * $cart->quantity) }};
            let totalAmount = parseInt(totalAmountInput.value);

            applyCouponBtn.addEventListener("click", async function() {
                const couponCode = couponCodeInput.value.trim();
                if (!couponCode) {
                    couponMessage.textContent = "Vui lòng nhập mã giảm giá!";
                    return;
                }

                try {
                    const response = await fetch("{{ route('coupon.apply') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            coupon_code: couponCode,
                            total_amount: originalSubtotal + shippingFee
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        couponMessage.classList.remove("tw-text-red-500");
                        couponMessage.classList.add("tw-text-green-500");
                        couponMessage.textContent = result.message;

                        const newTotal = result.new_total;
                        totalAmountDisplay.textContent = newTotal.toLocaleString() + "₫";
                        totalAmountInput.value = newTotal;
                        discountInput.value = result.discount;

                        // Cập nhật lại tổng tiền với phí ship
                        shippingFee = parseInt(shippingFeeInput.value);
                        totalAmountInput.value = newTotal + shippingFee;
                        totalAmountDisplay.textContent = (newTotal + shippingFee).toLocaleString() +
                            "₫";
                    } else {
                        couponMessage.classList.remove("tw-text-green-500");
                        couponMessage.classList.add("tw-text-red-500");
                        couponMessage.textContent = result.message;
                    }
                } catch (error) {
                    couponMessage.textContent = "Đã xảy ra lỗi, vui lòng thử lại!";
                    console.error(error);
                }
            });

            if (toggleAddressFormBtn) {
                toggleAddressFormBtn.addEventListener("click", function() {
                    if (isFormVisible) {
                        newAddressForm.style.display = "none";
                        toggleAddressFormBtn.textContent = "Thêm địa chỉ khác";
                    } else {
                        newAddressForm.style.display = "block";
                        toggleAddressFormBtn.textContent = "Ẩn form thêm địa chỉ";
                        document.querySelectorAll('input[name="address_id_temp"]').forEach(input =>
                            input.checked = false);
                        addressIdInput.value = "";
                    }
                    isFormVisible = !isFormVisible;
                });
            }

            document.querySelectorAll('input[name="address_id_temp"]').forEach(radio => {
                radio.addEventListener("change", function() {
                    addressIdInput.value = this.value;
                });
            });

            const checkedRadio = document.querySelector('input[name="address_id_temp"]:checked');
            if (checkedRadio) {
                addressIdInput.value = checkedRadio.value;
            }

            document.getElementById("province").addEventListener("change", async function() {
                await loadDistricts(this.value); // Sử dụng ProvinceID để load quận/huyện
            });

            document.getElementById("district").addEventListener("change", async function() {
                await loadWards(this.value); // Sử dụng DistrictID để load phường/xã
            });

            document.getElementById("ward").addEventListener("change", async function() {
                const districtId = document.getElementById("district").value;
                const wardCode = this.value;
                if (districtId && wardCode) {
                    await calculateShippingFee("3695", districtId,
                        wardCode); // Thay YOUR_FROM_DISTRICT_ID
                }
            });

            await loadProvinces();

            document.getElementById("new-address-form").addEventListener("submit", async function(e) {
                e.preventDefault();

                const provinceSelect = document.getElementById("province");
                const districtSelect = document.getElementById("district");
                const wardSelect = document.getElementById("ward");

                const provinceName = provinceSelect.options[provinceSelect.selectedIndex]?.dataset
                    .name || "";
                const districtName = districtSelect.options[districtSelect.selectedIndex]?.dataset
                    .name || "";
                const wardName = wardSelect.options[wardSelect.selectedIndex]?.dataset.name || "";
                const street = document.getElementById("street").value;

                document.getElementById("province_name").value = provinceName;
                document.getElementById("district_name").value = districtName;
                document.getElementById("ward_name").value = wardName;
                document.getElementById("full_address").value =
                    `${street}, ${wardName}, ${districtName}, ${provinceName}`;

                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('address.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || "Có lỗi xảy ra");
                    }

                    // alert("Thêm địa chỉ thành công!");
                    iziToast.success({
                        title: 'Thành công',
                        message: 'Thêm địa chỉ thành công!',
                        position: 'topRight'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } catch (error) {
                    console.error("Lỗi khi gửi form:", error);
                    alert("Đã xảy ra lỗi: " + error.message);
                }
            });
        });
    </script>
@endsection
