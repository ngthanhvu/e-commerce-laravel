@extends('layouts.admin')

@section('content')
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-3 bg-white tw-rounded-[15px] tw-pt-3 tw-pl-4">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Quản lý bình luận & đánh giá</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các bình luận & đánh giá đang có!</p>
        </div>
    </div>
    @if (session('success'))
        <script>
            iziToast.success({
                title: 'Thành công',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            iziToast.error({
                title: 'Lỗi',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        </script>
    @endif
    <div class="bg-white tw-p-5 tw-rounded-[15px]">
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.users.index') }}" id="entriesForm">
                    <label for="entriesPerPage" class="form-label">Hiển thị</label>
                    <select id="entriesPerPage" name="per_page" class="form-select d-inline w-auto"
                        style="width: auto; display: inline-block;"
                        onchange="document.getElementById('entriesForm').submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span> mục trên mỗi trang</span>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="col-md-3 offset-md-3">
                <form method="GET" action="{{ route('admin.comments.index') }}">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..."
                        value="{{ $search }}" aria-label="Search">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nội dung bình luận</th>
                    <th scope="col">Đánh giá</th>
                    <th scope="col">Người đánh giá</th>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Phản hồi admin</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @php
                    $index = 1;
                @endphp
                @foreach ($ratings as $comment)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->rating }} <i class="fa-solid fa-star tw-text-[#FFD700]"></i></td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->product->name }}</td>
                        <td>{{ $comment->admin_reply ?? 'Chưa có phản hồi' }}</td>
                        <td>
                            <button class="btn btn-outline-secondary replyBtn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#replyModal" data-id="{{ $comment->id }}"
                                data-reply="{{ $comment->admin_reply }}">
                                <i class="fas fa-reply"></i> Phản hồi
                            </button>
                            <form action="/admin/ratings/{{ $comment->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($ratings->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="bi bi-inbox tw-text-[40px]"></i><br>
                            Không có người dùng nào
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="row">
            <div class="col-md-6">
                <p>Hiển thị {{ $ratings->firstItem() }} đến {{ $ratings->lastItem() }} trong {{ $ratings->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $ratings->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $ratings->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>

                        <!-- Các trang -->
                        @for ($i = 1; $i <= $ratings->lastPage(); $i++)
                            <li class="page-item {{ $ratings->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $ratings->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Nút Next -->
                        <li class="page-item {{ $ratings->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $ratings->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Phản hồi -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="replyForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">Phản hồi bình luận</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="adminReply" class="form-label">Nội dung phản hồi</label>
                            <textarea class="form-control" id="adminReply" name="admin_reply" rows="4"
                                placeholder="Nhập phản hồi của bạn..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.replyBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const reply = this.getAttribute('data-reply');
                const form = document.getElementById('replyForm');
                form.action = `/admin/ratings/${id}/reply`;
                document.getElementById('adminReply').value = reply || '';
            });
        });
    </script>
@endsection
