@extends('layouts.main')

@section('content')
    <style>
        .btn-backhome {
            background-color: #1158a3;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            border: 1px solid #1158a3;
        }

        .btn-backhome:hover {
            background-color: #fff;
            color: #1158a3;
            border: 1px solid #1158a3;
        }
    </style>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-danger fw-bold display-1">404</h1>
        <p class="text-muted fs-4">Xin lỗi, trang bạn tìm kiếm không tồn tại.</p>
        <a href="/" class="btn-backhome"><i class="fa-solid fa-house-chimney"></i> Trở về trang chủ</a>
    </div>
@endsection
