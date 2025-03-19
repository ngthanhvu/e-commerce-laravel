@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Thêm danh mục mới</h2>
    </div>

    <div class="container">
        <form action="/admin/categories" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả"></textarea>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" accept="image/*" id="image" name="image">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tạo danh mục</button>
        </form>
    </div>
@endsection
