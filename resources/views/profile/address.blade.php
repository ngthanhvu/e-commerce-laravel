@extends('layouts.main')

@section('content')
    <style>
        .sidebar {
            background-color: #fff;
            padding: 20px 0;
        }

        .sidebar .nav-link {
            color: #333;
            padding: 10px 20px;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f0f2f5;
            color: #ff6200;
        }

        .profile-content {
            padding: 30px;
        }

        .profile-form .form-label {
            font-weight: 500;
        }

        .profile-form .form-control {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .btn-save {
            background-color: #ff6200;
            border-color: #ff6200;
            color: #fff;
        }

        .btn-save:hover {
            background-color: #e55a00;
            border-color: #e55a00;
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

        /* CSS cho bảng địa chỉ */
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

        /* Ẩn form mặc định */
        .address-form {
            display: none;
        }
    </style>
    <div class="container mt-3">
        <div class="row">
            <!-- Cột bên trái: Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Thông tin tài khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/profile/address">Địa chỉ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/history">Đơn hàng</a>
                    </li>
                </ul>
            </div>

            <!-- Cột bên phải: Nội dung địa chỉ -->
            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản lý địa chỉ</h5>

                        <!-- Nút hiển thị form -->
                        <button class="btn btn-add-address" onclick="toggleAddressForm()">Thêm địa chỉ</button>

                        <!-- Form thêm địa chỉ (ẩn mặc định) -->
                        <form class="profile-form address-form" method="POST" action="/profile/address" id="addressForm">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" value="nguo_dung"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="example@email.com">
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                    value="Nguyễn Văn A">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Nhập địa chỉ của bạn">
                            </div>
                            <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                        </form>

                        <!-- Danh sách địa chỉ -->
                        <div class="address-table mt-2">
                            <h5>Danh sách địa chỉ</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>Địa chỉ</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ví dụ dữ liệu tĩnh -->
                                    @php
                                        $addresses = [
                                            [
                                                'id' => 1,
                                                'fullname' => 'Nguyễn Văn A',
                                                'address' => '123 Đường Láng, Hà Nội',
                                            ],
                                            [
                                                'id' => 2,
                                                'fullname' => 'Nguyễn Văn A',
                                                'address' => '456 Nguyễn Trãi, Thanh Xuân',
                                            ],
                                        ];
                                    @endphp
                                    @forelse ($addresses as $index => $address)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $address['fullname'] }}</td>
                                            <td>{{ $address['address'] }}</td>
                                            <td>
                                                <form action="/profile/address/delete/{{ $address['id'] }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete"><i class="bi bi-trash"></i>
                                                        Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa có địa chỉ nào được thêm.</td>
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

    <!-- Script để toggle form -->
    <script>
        function toggleAddressForm() {
            var form = document.getElementById('addressForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
@endsection
