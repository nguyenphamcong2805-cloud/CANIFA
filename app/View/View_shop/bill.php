<?php require_once 'header.php'; ?>

<style>
.bill-page { max-width: 680px; margin: 50px auto; padding: 0 20px 60px; text-align: center; }
.bill-icon { font-size: 64px; margin-bottom: 16px; }
.bill-page h2 { font-size: 28px; margin-bottom: 8px; }
.bill-page .sub { color: #666; margin-bottom: 32px; font-size: 15px; }

.bill-box {
    background: #f9f9f9; border: 1px solid #eee;
    border-radius: 12px; padding: 24px; text-align: left; margin-bottom: 28px;
}
.bill-box h3 { font-size: 15px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; color: #555; }
.bill-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 15px; }
.bill-row:last-child { border-bottom: none; }
.bill-row.total { font-weight: bold; font-size: 18px; color: #111; padding-top: 12px; }

.bill-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-home {
    padding: 13px 30px; background: #222; color: #fff;
    border: none; border-radius: 6px; font-size: 15px; font-weight: bold;
    cursor: pointer; text-decoration: none;
}
.btn-home:hover { background: #000; }
.btn-orders {
    padding: 13px 30px; border: 1px solid #333; color: #333;
    border-radius: 6px; font-size: 15px; font-weight: bold;
    text-decoration: none; background: #fff;
}
.btn-orders:hover { background: #f5f5f5; }
</style>

<div class="bill-page">
    <div class="bill-icon">🎉</div>
    <h2>Đặt hàng thành công!</h2>
    <p class="sub">Cảm ơn bạn đã mua sắm tại CANIFA.<br>Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>

    <?php
    $cart  = $_SESSION['cart_last'] ?? $_SESSION['cart'] ?? [];
    $total = 0;
    foreach ($cart as $item) $total += $item['gia'] * $item['so_luong'];
    ?>

    <?php if (!empty($cart)): ?>
    <div class="bill-box">
        <h3>Chi tiết đơn hàng</h3>
        <?php foreach ($cart as $item): ?>
        <div class="bill-row">
            <span><?= htmlspecialchars($item['ten']) ?> (Size: <?= htmlspecialchars($item['size']) ?>) × <?= $item['so_luong'] ?></span>
            <span><?= number_format($item['gia'] * $item['so_luong']) ?> ₫</span>
        </div>
        <?php endforeach; ?>
        <div class="bill-row total">
            <span>Tổng cộng</span>
            <span><?= number_format($total) ?> ₫</span>
        </div>
    </div>
    <?php endif; ?>

    <div class="bill-actions">
        <a class="btn-home" href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index">Tiếp tục mua sắm</a>
    </div>
</div>

<?php
// Xóa giỏ sau khi đặt hàng thành công
$_SESSION['cart'] = [];
require_once 'footer.php';
?>
