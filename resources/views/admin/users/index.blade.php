@extends('layouts.admin')

@section('content')
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-3 bg-white tw-rounded-[15px] tw-pt-3 tw-pl-4">
        <div>
            <h3 class="tw-text-2xl tw-font-bold">Quản lý người dùng</h3>
            <p class="tw-text-gray-500 tw-mt-1">Danh sách các người dùng đang có!</p>
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
                <form method="GET" action="{{ route('admin.users.index') }}">
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
                    <th scope="col">Tên người dùng</th>
                    <th scope="col">Email</th>
                    <th scope="col">Vai trò</th>
                    <th scope="col">Thời gian tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @php
                    $index = 1;
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $index++ }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 'admin')
                                <span class="badge rounded-pill text-bg-danger">Admin</span>
                            @elseif ($user->role == 'user')
                                <span class="badge rounded-pill text-bg-success">User</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <button class="btn btn-outline-secondary editUserBtn btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="/admin/users/{{ $user->id }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary btn-sm"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">
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
                <p>Hiển thị {{ $users->firstItem() }} đến {{ $users->lastItem() }} trong {{ $users->total() }}
                    mục</p>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $users->previousPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}"
                                tabindex="-1">«</a>
                        </li>

                        <!-- Các trang -->
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $users->url($i) . '&per_page=' . $perPage . '&search=' . $search }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Nút Next -->
                        <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $users->nextPageUrl() . '&per_page=' . $perPage . '&search=' . $search }}">»</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Modal Sửa Người Dùng -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Chỉnh sửa người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Vai trò</label>
                            <select class="form-select" id="editUserRole" name="role">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu thay
                            đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".editUserBtn").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.getAttribute("data-id");
                    let userName = this.getAttribute("data-name");
                    let userEmail = this.getAttribute("data-email");
                    let userRole = this.getAttribute("data-role");
                    // document.getElementById("editUserForm").action = `/admin/users/${userId}`;
                    document.getElementById("editUserName").value = userName;
                    document.getElementById("editUserEmail").value = userEmail;
                    document.getElementById("editUserRole").value = userRole;
                });
            });
        });
    </script>
@endsection
