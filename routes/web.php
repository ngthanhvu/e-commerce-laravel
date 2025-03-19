<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
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
Route::get('/chi-tiet/{slug}', [ProductController::class, 'show'])->name('products.show');

//auth
Route::post('dang-ky', [UserController::class, 'register']);
Route::post('dang-nhap', [UserController::class, 'login']);
Route::post('dang-xuat', [UserController::class, 'logout']);

//admin
Route::middleware('check.role:admin')->group(function () {
    Route::get('/admin', function () {
        $title = 'Trang quản trị';
        return view('admin.index', compact('title'));
    });
    //products
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create']);
    Route::post('/admin/products', [ProductController::class, 'store']);
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy']);
    //categories
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create']);
    Route::post('/admin/categories', [CategoryController::class, 'store']);
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit']);
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
});
