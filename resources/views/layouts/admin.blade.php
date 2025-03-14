<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
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

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
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
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center mb-4">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-house-door me-2"></i>Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person me-2"></i>Users
                </a>
            </li>

            <!-- Menu phân cấp Settings -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#settingsMenu" role="button">
                    <div><i class="bi bi-gear me-2"></i>Settings</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="settingsMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="#">General</a></li>
                        <li><a class="nav-link" href="#">Security</a></li>
                        <li><a class="nav-link" href="#">Notifications</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
            </li>

            <!-- Menu phân cấp Products -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#productsMenu" role="button">
                    <div><i class="bi bi-box me-2"></i>Products</div>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="productsMenu">
                    <ul class="nav flex-column ps-3">
                        <li><a class="nav-link" href="#">List Products</a></li>
                        <li><a class="nav-link" href="#">Add Product</a></li>
                        <li><a class="nav-link" href="#">Categories</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>

    <!-- Nội dung chính -->
    <div class="content container-fluid">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
