@extends('layouts.admin')

@section('content')
    <div class="tw-mb-5">
        <h3 class="tw-text-3xl tw-font-bold text-center tw-mb-3">Thêm bài viết</h3>
    </div>

    <div class="container tw-w-[70%] tw-bg-white tw-p-5 tw-rounded-[15px]">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data"
            onsubmit="syncQuillContent()">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title"
                    placeholder="Nhập tiêu đề bài viết">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <input type="text" class="form-control" id="description" name="description"
                    placeholder="Nhập mô tả bài viết">
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input class="form-control" type="file" id="image" name="image">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <!-- Editor sẽ render vào đây -->
                <div id="quill-editor" style="height: 400px;"></div>
                <!-- Hidden textarea để submit -->
                <textarea name="content" id="content" class="d-none"></textarea>
                @error('content')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-control" id="status" name="status">
                    <option value="0">Chưa duyệt</option>
                    <option value="1">Đã duyệt</option>
                </select>
                @error('status')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-outline-primary me-2">Tạo bài viết</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-danger">Huỷ</a>
        </form>
    </div>

    <script>
        const quill = new Quill('#quill-editor', {
            theme: 'snow'
        });

        function syncQuillContent() {
            const content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        }
    </script>
@endsection
