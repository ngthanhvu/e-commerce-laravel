<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/chi-tiet', function () {
    $title = 'Chi tiết sản phẩm';
    return view('detail', compact('title'));
});

//auth
Route::post('dang-ky', [UserController::class, 'register']);
Route::post('dang-nhap', [UserController::class, 'login']);
Route::post('dang-xuat', [UserController::class, 'logout']);

//admin
Route::get('/admin', function () {
    $title = 'Trang quản trị';
    return view('admin.index', compact('title'));
});
