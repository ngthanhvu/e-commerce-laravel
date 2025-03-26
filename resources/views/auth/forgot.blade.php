@extends('layouts.main')
@section('content')
    <style>
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
        <div class="form-container" id="loginForm">
            <h2 class="text-center mb-4">Quên mật khẩu</h2>
            <form method="POST" action="/dang-nhap">
                @csrf
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="loginEmail"
                        placeholder="Nhập email của bạn">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Gửi mail</button>
            </form>
        </div>
    </div>
@endsection
