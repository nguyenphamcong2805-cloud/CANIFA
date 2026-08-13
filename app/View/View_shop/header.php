<?php
// header.php - CANIFA OFICELOOK Header Component
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css?v=<?= time(); ?>">
    <title>CANIFA OFICELOOK</title>
</head>
<body>

<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="./index_shop.php?ctrl=home&act=index" class="logo">
            <img src="<?= BASE_URL ?>img/logo.png" alt="CANIFA OFICELOOK Logo" style="width: 160px; height: auto; display: block; margin: 0 auto;">
        </a>

        <!-- Navigation Menu -->
        <nav>
            <a href="./index_shop.php?ctrl=home&act=index">TRANG CHỦ</a>
            <a href="./index_shop.php?ctrl=product&act=category&id=1">ÁO</a>
            <a href="./index_shop.php?ctrl=product&act=category&id=2">QUẦN</a>
            <a href="./index_shop.php?ctrl=blog&act=index">BÀI VIẾT</a>
            <a href="./index_shop.php?ctrl=home&act=about">VỀ CHÚNG TÔI</a>
            <a href="./index_shop.php?ctrl=home&act=contact">LIÊN HỆ</a>
        </nav>

        <!-- Right Section -->
        <div class="header-right">
            <!-- Search Box -->
            <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" placeholder="Bạn đang tìm gì ?">
            </div>

            <!-- Icons -->
            <div class="icon-buttons">
                <!-- User Account -->
                <?php if (empty($_SESSION['login'])): ?>
                    <a href="./index_shop.php?ctrl=home&act=login" title="Đăng nhập" class="account-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <div class="user-greeting">
                        <?php if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="<?= BASE_URL_SITE ?>index_admin.php?page=home" title="Admin" class="account-link">
                        <?php else: ?>
                            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=login" title="Tài khoản" class="account-link">
                        <?php endif; ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span class="account-name"><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['user']['ho_ten'] ?? 'User') ?></span>
                        </a>
                        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=user&act=logout" title="Đăng xuất" class="logout-link">Đăng xuất</a>
                    </div>
                <?php endif; ?>

                <!-- Shopping Cart -->
                <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=index" title="Giỏ hàng" class="cart-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>

</body>
</html>