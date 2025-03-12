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

        .social-btn {
            font-size: 16px;
            padding: 10px;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }

        .btn-google {
            background-color: #db4437;
            color: white;
        }

        .btn-facebook:hover,
        .btn-google:hover {
            opacity: 0.9;
        }
    </style>
    <div class="container">
        <div class="form-container" id="loginForm">
            <h2 class="text-center mb-4">Đăng Nhập</h2>
            <form>
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="loginEmail" placeholder="Nhập email của bạn" required>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="loginPassword" placeholder="Nhập mật khẩu" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Ghi nhớ tôi</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
            </form>

            <!-- Đăng nhập bằng mạng xã hội -->
            <div class="text-center mt-3">
                <p>Hoặc đăng nhập bằng:</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-facebook social-btn w-100">
                        <i class="bi bi-facebook me-2"></i> Facebook
                    </a>
                    <a href="#" class="btn btn-google social-btn w-100">
                        <i class="bi bi-google me-2"></i> Google
                    </a>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="/dang-ky" class="text-center mt-3 text-decoration-none">Chưa có tài khoản?
                    <span class="toggle-form">Đăng ký ngay</span>
                </a>
            </div>
        </div>
    </div>
@endsection
