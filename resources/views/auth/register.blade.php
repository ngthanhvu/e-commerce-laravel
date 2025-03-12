@extends('layouts.main')

@section('content')
    <style>
        * {
            font-family: 'Quicksand', sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .toggle-form {
            cursor: pointer;
            color: #0d6efd;
        }

        .toggle-form:hover {
            text-decoration: underline;
        }
    </style>
    <div class="container">
        <div class="form-container" id="registerForm">
            <h2 class="text-center mb-4">Đăng Ký</h2>
            <form>
                <div class="mb-3">
                    <label for="registerUsername" class="form-label">Tên người dùng</label>
                    <input type="text" class="form-control" id="registerUsername" placeholder="Nhập tên người dùng"
                        required>
                </div>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="registerEmail" placeholder="Nhập email của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="registerPassword" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Xác nhận mật khẩu"
                        required>
                </div>
                <button type="submit" class="btn btn-success w-100">Đăng Ký</button>
                <div class="text-center mt-3">
                    <a href="/dang-nhap" class="text-center mt-3 text-decoration-none">Đã có tài khoản? <span
                            class="toggle-form">Đăng nhập
                            ngay</span></a>
                </div>
            </form>
        </div>
    </div>
@endsection
