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
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mota</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hinh anh</label>
                <input type="file" class="form-control" accept="image/*" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Tạo danh mục</button>
        </form>
    </div>
@endsection
