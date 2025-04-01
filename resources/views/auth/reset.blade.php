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

        .otp-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
    </style>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Đặt lại mật khẩu</h2>
            <form method="POST" action="/reset-password">
                @csrf
                <div class="mb-3">
                    <label class="form-label d-block text-center">Mã xác nhận (6 số)</label>
                    <div class="otp-container">
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                        <input type="text" class="otp-input" name="otp[]" maxlength="1" pattern="\d" required>
                    </div>
                    @error('otp')
                        <p class="text-danger text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="Nhập email của bạn" value="{{ session('email') }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" name="password" id="password"
                        placeholder="Nhập mật khẩu mới">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                        placeholder="Xác nhận mật khẩu">
                </div>
                <button type="submit" class="btn btn-primary w-100">Xác nhận và lưu</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll(".otp-input");

            inputs.forEach((input, index) => {
                input.addEventListener("input", function(e) {
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener("keydown", function(e) {
                    if (e.key === "Backspace" && this.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener("paste", function(e) {
                    e.preventDefault();
                    let pasteData = (e.clipboardData || window.clipboardData).getData("text")
                        .trim();
                    let digits = pasteData.replace(/\D/g, "").split("").slice(0, inputs.length);

                    digits.forEach((digit, i) => {
                        inputs[i].value = digit;
                    });

                    if (digits.length === inputs.length) {
                        inputs[inputs.length - 1].focus();
                    } else if (digits.length > 0) {
                        inputs[digits.length].focus();
                    }
                });
            });
        });
    </script>
@endsection
