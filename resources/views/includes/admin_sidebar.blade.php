<style>
    * {
        font-family: 'Signika Negative', sans-serif;
    }

    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #212529;
        padding-top: 20px;
    }

    .sidebar .nav-link {
        color: #adb5bd;
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: #fff;
        background-color: #343a40;
        border-radius: 5px;
    }

    .sidebar .nav-link i {
        font-size: 18px;
    }

    .sidebar .dropdown-menu {
        background-color: #343a40;
        border: none;
        padding: 0;
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: #adb5bd;
        padding: 8px 20px;
        transition: all 0.3s;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        color: #fff;
        background-color: #495057;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
        width: calc(100% - 250px);
    }


    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out;
    }

    .loading-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sidebar {
            width: 200px;
        }

        .content {
            margin-left: 210px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            position: relative;
        }

        .content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
<div id="loading-spinner" class="loading-overlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center mb-4"><a href="/" class="text-white text-decoration-none">Admin
            Panel</a></h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/admin#dashboard">
                <i class="bi bi-house-door me-2"></i>Bảng điều khiển
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                href="#productsMenu" role="button">
                <div><i class="bi bi-box me-2"></i>Sản phẩm</div>
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="productsMenu">
                <ul class="nav flex-column ps-3">
                    <li><a class="nav-link" href="/admin/products#list-products">Danh sách sản phẩm</a></li>
                    <li><a class="nav-link" href="/admin/products/create#add-product">Thêm sản phẩm</a></li>
                    <li><a class="nav-link" href="/admin/categories#categories">Danh mục</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/users#users">
                <i class="bi bi-person me-2"></i>Người dùng
            </a>
        </li>

        <!-- Menu phân cấp Settings -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                href="#settingsMenu" role="button">
                <div><i class="bi bi-gear me-2"></i>Cài đặt</div>
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="settingsMenu">
                <ul class="nav flex-column ps-3">
                    <li><a class="nav-link" href="/admin/settings/general#general">General</a></li>
                    <li><a class="nav-link" href="/admin/settings/security#security">Security</a></li>
                    <li><a class="nav-link" href="/admin/settings/notifications#notifications">Notifications</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/reports#reports">
                <i class="bi bi-bar-chart me-2"></i>Báo cáo
            </a>
        </li>
    </ul>
</div>
