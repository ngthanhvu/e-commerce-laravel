@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Danh sách sản phẩm</h2>
    </div>
    <div class="p-3 mb-4 rounded-3 bg-light">
        <a href="/admin/products/create" class="btn btn-primary">Tạo sản phẩm</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Ảnh chính</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Biến thể</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Không có danh mục' }}</td>
                        <td>{{ number_format($product->price) }} đ</td>
                        <td>
                            @if ($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                    alt="{{ $product->name }}" style="width: 100px;">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if ($product->variants->isEmpty())
                                Không có
                            @else
                                @foreach ($product->variants as $variant)
                                    <div>
                                        <strong>{{ $variant->varriant_name }}</strong>
                                        - Giá: {{ number_format($variant->varriant_price) }} đ
                                        - SL: {{ $variant->varriant_quantity }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-primary">Sửa</a>
                            <form action="/admin/products/{{ $product->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($products->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
