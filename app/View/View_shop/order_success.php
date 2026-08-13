<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($orderInfo) || !is_array($orderInfo)) {
    $orderInfo = [];
}
?>
<?php require_once __DIR__ . '/header.php'; ?>

<main class="order-success-page" style="max-width: 960px; margin: 48px auto; padding: 0 18px;">
    <section style="background:#fff; padding:42px 36px; border-radius:18px; box-shadow:0 24px 60px rgba(15,23,42,.08); text-align:center;">
        <div style="width:96px; height:96px; margin:0 auto 24px; display:flex; align-items:center; justify-content:center; border-radius:50%; background:#e6fffa; color:#0f766e; font-size:3rem;">
            ✓
        </div>
        <h1 style="font-size:2.4rem; margin:0 0 12px; color:#111;">Đặt hàng thành công</h1>
        <p style="margin:0 0 24px; color:#475569; font-size:1rem; line-height:1.75;">
            Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được gửi đi và đang được xử lý.
        </p>
        <div style="display:grid; gap:10px; justify-items:center; margin-bottom:32px;">
            <span style="font-size:0.95rem; color:#334155;">Mã đơn hàng: <strong>#<?= htmlspecialchars($orderInfo['id'] ?? '') ?></strong></span>
            <span style="font-size:0.95rem; color:#334155;">Bạn sẽ nhận được thông báo khi đơn hàng được cập nhật.</span>
        </div>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index" style="padding:14px 24px; background:#111; color:#fff; border-radius:999px; text-decoration:none; font-weight:700;">Quay về trang chủ</a>
            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=orderDetail&id=<?= (int)$orderInfo['id'] ?>" style="padding:14px 24px; border:1px solid #111; color:#111; border-radius:999px; text-decoration:none; font-weight:700;">Xem sản phẩm đã mua</a>
            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=index" style="padding:14px 24px; border:1px solid #111; color:#111; border-radius:999px; text-decoration:none; font-weight:700;">Xem lại giỏ hàng</a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
