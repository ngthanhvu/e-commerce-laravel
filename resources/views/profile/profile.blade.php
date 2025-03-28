@extends('layouts.main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <!-- Cột bên trái: Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                @include('profile.includes.sidebar')
            </div>

            <!-- Cột bên phải: Thông tin cá nhân -->
            <div class="col-md-9 col-lg-10 profile-content">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin cá nhân</h5>
                        <form class="profile-form" action="{{ route('profile.update', $profile->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên người dùng</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('username', $profile->name) }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $profile->email) }}">
                                <input type="hidden" name="role" value="{{ $profile->role }}">
                            </div>
                            <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>

                <!-- Form đổi mật khẩu -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Đổi mật khẩu</h5>
                        <form class="profile-form" action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="old_password" name="old_password"
                                    placeholder="Nhập mật khẩu hiện tại">
                                @error('old_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="Nhập mật khẩu mới">
                                @error('new_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới">
                                @error('new_password_confirmation')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-save">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
