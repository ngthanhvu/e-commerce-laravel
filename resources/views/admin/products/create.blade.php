@extends('layouts.admin')

@section('content')
    <div class="p-3 mb-4 rounded-3 bg-light">
        <h2>Thêm sản phẩm mới</h2>
    </div>

    <div class="container">
        <form action="/admin/products" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột trái -->
                <div class="col-md-6">
                    <!-- Tên sản phẩm -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Giá sản phẩm -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>

                    <!-- Slug sản phẩm -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-md-6">
                    <!-- Danh mục -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ảnh chính -->
                    <div class="mb-3">
                        <label for="main_image" class="form-label">Ảnh chính</label>
                        <input type="file" class="form-control" id="main_image" name="main_image" required>
                        <div id="main_image_preview" class="mt-2"></div>
                    </div>

                    <!-- Ảnh phụ -->
                    <div class="mb-3">
                        <label for="sub_images" class="form-label">Ảnh phụ</label>
                        <input type="file" class="form-control" id="sub_images" name="sub_images[]" multiple>
                        <div id="sub_images_preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- Biến thể (toàn chiều rộng) -->
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Thêm biến thể sản phẩm</label>
                        <div id="variant-container">
                            <div class="variant-item mb-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control mb-2" name="variants[0][name]"
                                            placeholder="Tên biến thể">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control mb-2" name="variants[0][price]"
                                            placeholder="Giá">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control mb-2" name="variants[0][quantity]"
                                            placeholder="Số lượng">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control mb-2" name="variants[0][sku]"
                                            placeholder="SKU">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-variant">Thêm biến thể</button>
                    </div>
                </div>

                <!-- Nút submit -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
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
                    img.style.maxWidth = '200px'; // Giới hạn kích thước ảnh preview
                    img.style.borderRadius = '5px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

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
