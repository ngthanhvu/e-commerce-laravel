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

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
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
                        <a class="nav-link" href="/profile/address">Địa chỉ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/profile/history">Đơn hàng</a>
                    </li>
                </ul>
            </div>

            <!-- Cột bên phải: Thông tin cá nhân -->
            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                        <form class="profile-form">
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
                            <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
