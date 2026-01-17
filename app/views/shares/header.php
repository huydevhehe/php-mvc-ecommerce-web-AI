<?php
require_once 'app/helpers/SessionHelper.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        .navbar-custom {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 0.45rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 36px;
            margin-right: 10px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.4s ease;
            display: block !important;
            min-width: 220px;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 6px;
            position: relative;
            color: #333;
            overflow: hidden;
            z-index: 1;
        }

        .dropdown-item::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            background: linear-gradient(270deg, #ff0000, #ff9900, #ffff00, #33cc33, #3399ff, #9900cc, #ff0000);
            background-size: 1400% 1400%;
            opacity: 0;
            transition: opacity 0.3s ease;
            animation: rainbowMove 12s linear infinite; /* 👈 Sửa tại đây */
        }


        .dropdown-item:hover::before {
            opacity: 1;
        }

        .dropdown-item span {
            z-index: 1;
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            width: 25px;
            margin-right: 8px;
        }

        @keyframes rainbowMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .gear-hover {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.5s ease;
        }

        .gear-hover[data-rotating="true"] {
            animation: rotateForward 0.8s ease forwards;
        }

        .gear-hover[data-rotating="false"] {
            animation: rotateBackward 0.8s ease forwards;
        }

        @keyframes rotateForward {
            from { transform: rotate(0deg); }
            to { transform: rotate(40deg); }
        }

        @keyframes rotateBackward {
            from { transform: rotate(40deg); }
            to { transform: rotate(0deg); }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <a class="navbar-brand d-flex align-items-center mr-auto" href="/webbanhang/Product">
        <img src="/webbanhang/uploads/logo.png" alt="Logo">
    </a>

    <ul class="navbar-nav d-flex align-items-center">
        <?php if (SessionHelper::isLoggedIn()): ?>
            <li class="nav-item">
                <span class="nav-link fw-bold">
                    👋 Xin chào <?php echo htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username'] ?? ''); ?>
                </span>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="/webbanhang/account/login">Đăng nhập</a>
            </li>
        <?php endif; ?>

        <li class="nav-item dropdown ml-3">
            <button class="btn gear-hover" type="button" id="menuDropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog fa-lg"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuDropdown">
                <a class="dropdown-item" href="/webbanhang/Product">
                    <span><i class="fas fa-list"></i> Danh sách sản phẩm</span>
                </a>

                <?php if (SessionHelper::isAdmin()): ?>
                    <a class="dropdown-item" href="/webbanhang/Product/add">
                        <span><i class="fas fa-plus-circle"></i> Thêm sản phẩm</span>
                    </a>
                    <a class="dropdown-item" href="/webbanhang/Order/adminList">
                        <span><i class="fas fa-tasks"></i> Quản lý đơn hàng</span>
                    </a>
                    <!-- ✅ THÊM DÒNG NÀY -->
                    <a class="dropdown-item" href="/webbanhang/category/list">
                        <span><i class="fas fa-tags"></i> Quản lý danh mục</span>
                    </a>
                    <a class="dropdown-item" href="/webbanhang/discount/index">
                         <span><i class="fas fa-percentage"></i> Quản lý mã giảm giá</span>
                    </a>
                    
                <?php endif; ?>

                <a class="dropdown-item" href="/webbanhang/Product/cart">
                    <span><i class="fas fa-shopping-cart"></i> Giỏ hàng</span>
                </a>

                <a class="dropdown-item" href="/webbanhang/Product/myOrders">
                    <span><i class="fas fa-receipt"></i> Đơn hàng của tôi</span>
                </a>

                <a class="dropdown-item" href="/webbanhang/profile">
                    <span><i class="fas fa-user-circle"></i> Hồ sơ</span>
                </a>

                <a class="dropdown-item text-danger" href="/webbanhang/account/logout">
                    <span><i class="fas fa-sign-out-alt"></i> Đăng xuất</span>
                </a>
            </div>
        </li>
    </ul>
</nav>

<script>
    const gearBtn = document.querySelector('.gear-hover');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    gearBtn.addEventListener('mouseenter', () => {
        gearBtn.setAttribute('data-rotating', 'true');
    });

    gearBtn.addEventListener('mouseleave', () => {
        if (!dropdownMenu.matches(':hover')) {
            gearBtn.setAttribute('data-rotating', 'false');
        }
    });

    dropdownMenu.addEventListener('mouseleave', () => {
        gearBtn.setAttribute('data-rotating', 'false');
    });
</script>
