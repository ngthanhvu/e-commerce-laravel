@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Thêm mã giảm giá mới</h2>

        <!-- Form thêm coupon -->
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="row g-3">
                <!-- Mã coupon -->
                <div class="col-md-6">
                    <label for="code" class="form-label">Mã giảm giá</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                        name="code" value="{{ old('code') }}" placeholder="Nhập mã giảm giá (VD: DISCOUNT50)" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giá trị giảm giá -->
                <div class="col-md-6">
                    <label for="discount" class="form-label">Giá trị giảm giá</label>
                    <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror"
                        id="discount" name="discount" value="{{ old('discount') }}" placeholder="VD: 50000 hoặc 10"
                        required>
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Loại giảm giá -->
                <div class="col-md-6">
                    <label for="type" class="form-label">Loại giảm giá</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Chọn loại</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Cố định (VNĐ)</option>
                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Giá trị đơn hàng tối thiểu -->
                <div class="col-md-6">
                    <label for="min_order_amount" class="form-label">Giá trị đơn hàng tối thiểu</label>
                    <input type="number" step="0.01"
                        class="form-control @error('min_order_amount') is-invalid @enderror" id="min_order_amount"
                        name="min_order_amount" value="{{ old('min_order_amount') }}" placeholder="VD: 100000">
                    <small class="form-text text-muted">Để trống nếu không yêu cầu.</small>
                    @error('min_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số lần sử dụng tối đa -->
                <div class="col-md-6">
                    <label for="max_usage" class="form-label">Số lần sử dụng tối đa</label>
                    <input type="number" class="form-control @error('max_usage') is-invalid @enderror" id="max_usage"
                        name="max_usage" value="{{ old('max_usage', 1) }}" min="1" required>
                    @error('max_usage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày bắt đầu -->
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                        id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ngày kết thúc -->
                <div class="col-md-6">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                        name="end_date" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div class="col-md-6">
                    <label for="is_active" class="form-label">Trạng thái</label>
                    <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active"
                        required>
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Nút submit -->
            <div class="mt-4">
                <button type="submit" class="btn btn-outline-primary">Thêm mã giảm giá</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-danger">Huỷ</a>
            </div>
        </form>
    </div>

    <!-- Script validation của Bootstrap 5 -->
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
