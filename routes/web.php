<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CartsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dang-nhap', function () {
    $title = 'Đăng nhập';
    return view('auth.login', compact('title'));
});
Route::get('/dang-ky', function () {
    $title = 'Đăng ký';
    return view('auth.register', compact('title'));
});
Route::get('/san-pham', [HomeController::class, 'products'])->name('products');
//carts
Route::get('/gio-hang', [CartsController::class, 'index'])->name('carts.index');
Route::post('/gio-hang/create', [CartsController::class, 'store'])->name('carts.store');
Route::delete('/gio-hang/{id}', [CartsController::class, 'delete'])->name('carts.delete');
Route::put('/gio-hang/{id}', [CartsController::class, 'update'])->name('carts.update');

Route::get('/chi-tiet/{slug}', [ProductController::class, 'show'])->name('products.show');

//auth
Route::post('dang-ky', [UserController::class, 'register']);
Route::post('dang-nhap', [UserController::class, 'login'])->name('dang-nhap');
Route::post('dang-xuat', [UserController::class, 'logout']);
Route::get('/login/google', [UserController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback']);
Route::get('/login/facebook', [UserController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [UserController::class, 'handleFacebookCallback']);

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
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit']);
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy']);
    //users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
});

Route::get('/404', function () {
    $title = "404 Not Found";
    return view('404', compact('title'));
});
