<style>
    .sidebar {
        background-color: #fff;
        padding: 20px 0;
    }

    .sidebar .nav-link {
        color: #333;
        padding: 10px 20px;
        font-weight: 500;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #f0f2f5;
        color: #ff6200;
    }

    .profile-content {
        padding: 30px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
    }

    .profile-form .form-label {
        font-weight: 500;
    }

    .profile-form .form-control {
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .btn-save {
        background-color: #ff6200;
        border-color: #ff6200;
        color: #fff;
    }

    .btn-save:hover {
        background-color: #e55a00;
        border-color: #e55a00;
    }
</style>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="/profile">Thông tin tài khoản</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/profile/address">Địa chỉ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/profile/history">Đơn hàng</a>
    </li>
</ul>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>
