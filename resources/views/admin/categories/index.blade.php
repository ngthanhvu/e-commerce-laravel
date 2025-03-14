@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Danh sách danh mục</h2>
    </div>
    <div class="p-3 mb-4 rounded-3 bg-light">
        <a href="/admin/categories/create" class="btn btn-primary">Tạo danh mục</a>
        <table class="table table-striped mt-3 table-hover table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên danh mục</th>
                    <th scope="col">Mota</th>
                    <th scope="col">Hinh anh</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                style="width: 100px"></td>
                        <td>
                            <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-warning">Sửa</a>
                            <form action="/admin/categories/{{ $category->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($categories->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Không có danh mục nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
