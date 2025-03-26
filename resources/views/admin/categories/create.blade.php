@extends('layouts.admin')

@section('content')
    <div class="tw-mb-5">
        <h3 class="tw-text-3xl tw-font-bold text-center tw-mb-3">Thêm danh mục</h3>
    </div>

    <div class="container tw-w-[50%] tw-bg-white tw-p-5 tw-rounded-[15px]">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên danh mục"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="parent_id" class="form-label">Danh mục cha</label>
                <select class="form-select" id="parent_id" name="parent_id">
                    <option value="">Không có danh mục cha</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                        @if ($category->children->isNotEmpty())
                            @include('admin.categories.partials.category-options', [
                                'categories' => $category->children,
                                'level' => 1,
                                'currentCategoryId' => null,
                                'selectedCategoryId' => old('parent_id'),
                            ])
                        @endif
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
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
            <button type="submit" class="btn btn-outline-secondary me-2">Tạo danh mục</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-danger">Huỷ</a>
        </form>
    </div>
@endsection
