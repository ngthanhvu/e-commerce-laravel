@extends('layouts.main')

@section('content')
    <style>
        .address-form {
            max-width: 100%;
            margin: auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .address-form label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .address-form input,
        .address-form select {
            border-radius: 5px;
        }

        .address-form .form-group {
            margin-bottom: 15px;
        }

        .address-form .d-flex {
            flex-wrap: wrap;
            gap: 10px;
        }

        .address-form .w-50 {
            flex: 1;
            min-width: 48%;
        }

        .btn-save {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: 600;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .btn-add-address {
            background-color: #ff6200;
            border-color: #ff6200;
            color: #fff;
            margin-bottom: 20px;
        }

        .btn-add-address:hover {
            background-color: #e55a00;
            border-color: #e55a00;
        }

        .address-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .address-table th,
        .address-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .address-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .address-table td {
            vertical-align: middle;
        }

        .btn-delete {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            color: #b02a37;
        }

        .address-form {
            display: none;
        }

        .form-select {
            margin-bottom: 15px;
        }
    </style>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar">
                @include('profile.includes.sidebar')
            </div>

            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản lý địa chỉ</h5>
                        <button class="btn btn-dark" onclick="toggleAddressForm()">Thêm địa chỉ</button>
                        <form class="profile-form address-form" method="POST" action="{{ route('address.store') }}"
                            id="addressForm">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nhập họ và tên">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <div class="d-flex">
                                    <div class="w-50">
                                        <label for="province">Tỉnh/Thành phố</label>
                                        <select class="form-control form-select" id="province" name="province">
                                            <option value="">Chọn tỉnh/thành phố</option>
                                        </select>
                                    </div>
                                    <div class="w-50">
                                        <label for="district">Quận/Huyện</label>
                                        <select class="form-control form-select" id="district" name="district">
                                            <option value="">Chọn quận/huyện</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="w-50">
                                        <label for="ward">Xã/Phường</label>
                                        <select class="form-control form-select" id="ward" name="ward">
                                            <option value="">Chọn xã/phường</option>
                                        </select>
                                    </div>
                                    <div class="w-50">
                                        <label for="street">Số nhà, tên đường</label>
                                        <input type="text" class="form-control" id="street" name="street"
                                            placeholder="Nhập số nhà, tên đường">
                                    </div>
                                </div>
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" name="user_id" value="{{ optional(auth()->user())->id }}">
                            <!-- Không cần full_address nữa vì ta gửi trực tiếp các trường riêng -->

                            <button type="submit" class="btn btn-dark">Thêm mới!</button>
                        </form>

                        <div class="address-table mt-2">
                            <h5>Danh sách địa chỉ</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($addresses as $index => $address)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $address['name'] }}</td>
                                            <td>{{ $address['phone'] }}</td>
                                            <td>{{ $address['province'] }} - {{ $address['district'] }} -
                                                {{ $address['ward'] }} - {{ $address['street'] }}</td>
                                            <td>
                                                <form action="{{ route('address.destroy', $address['id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-delete delete-btn"
                                                        data-target="delete">
                                                        <i class="bi bi-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Chưa có địa chỉ nào được thêm.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAddressForm() {
            var form = document.getElementById('addressForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", async function() {
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const wardSelect = document.getElementById("ward");

            async function fetchData(url) {
                try {
                    const response = await fetch(url);
                    return await response.json();
                } catch (error) {
                    console.error("Lỗi khi gọi API:", error);
                    return null;
                }
            }

            async function loadProvinces() {
                const data = await fetchData("https://provinces.open-api.vn/api/p/");
                if (data) {
                    data.forEach(province => {
                        const option = document.createElement("option");
                        option.value = province.name;
                        option.text = province.name;
                        provinceSelect.appendChild(option);
                    });
                }
            }

            async function loadDistricts(provinceName) {
                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

                if (!provinceName) return;

                const provinces = await fetchData("https://provinces.open-api.vn/api/p/");
                const province = provinces?.find(p => p.name === provinceName);

                if (province) {
                    const data = await fetchData(
                        `https://provinces.open-api.vn/api/p/${province.code}?depth=2`);
                    if (data) {
                        data.districts.forEach(district => {
                            const option = document.createElement("option");
                            option.value = district.name;
                            option.text = district.name;
                            districtSelect.appendChild(option);
                        });
                    }
                }
            }

            async function loadWards(districtName, provinceName) {
                wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

                if (!districtName || !provinceName) return;

                const provinces = await fetchData("https://provinces.open-api.vn/api/p/");
                const province = provinces?.find(p => p.name === provinceName);

                if (province) {
                    const data = await fetchData(
                        `https://provinces.open-api.vn/api/p/${province.code}?depth=2`);
                    const district = data?.districts.find(d => d.name === districtName);

                    if (district) {
                        const wardData = await fetchData(
                            `https://provinces.open-api.vn/api/d/${district.code}?depth=2`);
                        if (wardData) {
                            wardData.wards.forEach(ward => {
                                const option = document.createElement("option");
                                option.value = ward.name;
                                option.text = ward.name;
                                wardSelect.appendChild(option);
                            });
                        }
                    }
                }
            }

            provinceSelect.addEventListener("change", async function() {
                await loadDistricts(this.value);
            });

            districtSelect.addEventListener("change", async function() {
                await loadWards(this.value, provinceSelect.value);
            });

            await loadProvinces();

            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    Swal.fire({
                        title: "Bạn có chắc chắn?",
                        text: "Hành động này không thể hoàn tác!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Xóa",
                        cancelButtonText: "Hủy"
                    }).then(result => {
                        if (result.isConfirmed) {
                            this.closest("form").submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
