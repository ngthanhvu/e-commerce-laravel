<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $title = 'Trang chủ';
    return view('index', compact('title'));
});
Route::get('/dang-nhap', function () {
    $title = 'Đăng nhập';
    return view('auth.login', compact('title'));
});
Route::get('/dang-ky', function () {
    $title = 'Đăng ký';
    return view('auth.register', compact('title'));
});
Route::get('/san-pham', function () {
    $title = 'Sản phẩm';
    return view('products', compact('title'));
});
Route::get('/gio-hang', function () {
    $title = 'Giỏ hàng';
    return view('carts', compact('title'));
});
