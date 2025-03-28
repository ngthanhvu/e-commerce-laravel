@extends('layouts.main')

@section('content')
    <style>
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
                @include('profile.includes.sidebar')
            </div>

            <!-- Cột bên phải: Nội dung địa chỉ -->
            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quản lý địa chỉ</h5>
                        <button class="btn btn-add-address" onclick="toggleAddressForm()">Thêm địa chỉ</button>
                        <form class="profile-form address-form" method="POST" action="{{ route('address.store') }}"
                            id="addressForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nhập họ và tên">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="phone" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Nhập địa chỉ của bạn">
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="user_id" value="{{ optional(auth()->user())->id }}">
                            <button type="submit" class="btn btn-save">Thêm mới!</button>
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
                                    @forelse ($addresses as $index => $address)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $address['name'] }}</td>
                                            <td>{{ $address['address'] }}</td>
                                            <td>
                                                <form action="{{ route('address.destroy', $address['id']) }}" method="POST"
                                                    style="display:inline;">
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
    <script>
        function toggleAddressForm() {
            var form = document.getElementById('addressForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest("form").submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
