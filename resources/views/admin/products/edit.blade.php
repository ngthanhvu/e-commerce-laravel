@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Chỉnh sửa sản phẩm: {{ $product->name }}</h2>
    </div>

    <div class="container">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            value="{{ old('quantity', $product->quantity) }}" required>
                        @error('quantity')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="main_image" class="form-label">Ảnh chính</label>
                        <input type="file" class="form-control" id="main_image" name="main_image">
                        <div id="main_image_preview" class="mt-2">
                            @if ($product->mainImage)
                                <img src="{{ asset('storage/' . $product->mainImage->sub_image) }}"
                                    alt="{{ $product->name }}" style="max-width: 200px; border-radius: 5px;">
                            @endif
                        </div>
                        @error('main_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sub_images" class="form-label">Ảnh phụ</label>
                        <input type="file" class="form-control" id="sub_images" name="sub_images[]" multiple>
                        <div id="sub_images_preview" class="mt-2 d-flex flex-wrap gap-2">
                            @foreach ($product->images()->where('is_main', false)->get() as $image)
                                <img src="{{ asset('storage/' . $image->sub_image) }}" alt="Sub image"
                                    style="max-width: 100px; border-radius: 5px;">
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Thêm biến thể sản phẩm <span class="text-muted">(tuỳ chọn)</span></label>
                        <div id="variant-container">
                            @foreach ($product->variants as $index => $variant)
                                <div class="variant-item mb-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control mb-2"
                                                name="variants[{{ $index }}][name]"
                                                value="{{ $variant->varriant_name }}" placeholder="Tên biến thể">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control mb-2"
                                                name="variants[{{ $index }}][price]"
                                                value="{{ $variant->varriant_price }}" placeholder="Giá">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control mb-2"
                                                name="variants[{{ $index }}][quantity]"
                                                value="{{ $variant->varriant_quantity }}" placeholder="Số lượng">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control mb-2"
                                                name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}"
                                                placeholder="SKU">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-variant">Thêm biến thể</button>
                    </div>
                </div>

                <!-- Nút submit -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Thêm biến thể
        document.getElementById('add-variant').addEventListener('click', function() {
            let container = document.getElementById('variant-container');
            let count = container.getElementsByClassName('variant-item').length;
            let html = `
                <div class="variant-item mb-2">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" name="variants[${count}][name]" placeholder="Tên biến thể">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control mb-2" name="variants[${count}][price]" placeholder="Giá">
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control mb-2" name="variants[${count}][quantity]" placeholder="Số lượng">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control mb-2" name="variants[${count}][sku]" placeholder="SKU">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Preview ảnh chính
        document.getElementById('main_image').addEventListener('change', function(e) {
            const preview = document.getElementById('main_image_preview');
            preview.innerHTML = ''; // Xóa preview cũ

            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.maxWidth = '200px';
                    img.style.borderRadius = '5px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // Preview ảnh phụ
        document.getElementById('sub_images').addEventListener('change', function(e) {
            const preview = document.getElementById('sub_images_preview');
            preview.innerHTML = '';

            const files = e.target.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.maxWidth = '100px';
                        img.style.borderRadius = '5px';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(files[i]);
                }
            }
        });
    </script>
@endsection
