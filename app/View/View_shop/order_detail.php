<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php require_once 'header.php'; ?>

<main class="order-detail-page" style="max-width: 980px; margin: 48px auto; padding: 0 18px;">
    <section style="background:#fff; padding:42px 36px; border-radius:18px; box-shadow:0 24px 60px rgba(15,23,42,.08);">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:28px;">
            <div>
                <h1 style="font-size:2rem; margin:0 0 12px; color:#111;">Chi tiết đơn hàng</h1>
                <p style="margin:0; color:#475569;">Mã đơn hàng: <strong>#<?= htmlspecialchars($orderInfo['don_hang_id'] ?? $orderInfo['id'] ?? '') ?></strong></p>
                <p style="margin:6px 0 0; color:#475569;">Ngày tạo: <strong><?= htmlspecialchars(date('d/m/Y H:i', strtotime($orderInfo['ngay_tao'] ?? '')) ) ?></strong></p>
            </div>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index" style="padding:12px 20px; border:1px solid #111; color:#111; border-radius:999px; text-decoration:none; font-weight:600;">Về trang chủ</a>
                <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=orderSuccess&id=<?= (int)($orderInfo['don_hang_id'] ?? $orderInfo['id'] ?? 0) ?>" style="padding:12px 20px; background:#111; color:#fff; border-radius:999px; text-decoration:none; font-weight:600;">Trang xác nhận</a>
            </div>
        </div>

        <div style="display:grid; gap:24px;">
            <div style="display:grid; gap:12px; padding:24px; background:#f8fafc; border-radius:16px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div><strong>Người mua:</strong><br><?= htmlspecialchars($_SESSION['user']['ho_ten'] ?? '') ?></div>
                    <div><strong>Email:</strong><br><?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?></div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div><strong>Tổng tiền:</strong><br><?= number_format($orderInfo['tong_tien'] ?? 0) ?> ₫</div>
                    <div><strong>Trạng thái:</strong><br><?= htmlspecialchars($orderInfo['trang_thai_thanh_toan'] ?? '') ?></div>
                </div>
            </div>

            <div style="background:#fff; border-radius:18px; overflow:hidden; box-shadow:0 12px 30px rgba(15,23,42,.08);">
                <div style="padding:24px 28px; border-bottom:1px solid #e2e8f0; background:#f8fafc;">
                    <h2 style="margin:0; font-size:1.4rem; color:#111;">Sản phẩm đã mua</h2>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; min-width:720px;">
                        <thead>
                            <tr style="background:#111; color:#fff; text-align:left;">
                                <th style="padding:14px 18px;">#</th>
                                <th style="padding:14px 18px;">Sản phẩm</th>
                                <th style="padding:14px 18px;">Số lượng</th>
                                <th style="padding:14px 18px;">Giá</th>
                                <th style="padding:14px 18px;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): ?>
                                <?php $count = 0; foreach ($items as $item): $count++; ?>
                                    <tr style="border-bottom:1px solid #e2e8f0;">
                                        <td style="padding:16px 18px; vertical-align:middle;"><?= $count ?></td>
                                        <td style="padding:16px 18px; vertical-align:middle;">
                                            <div style="display:flex; align-items:center; gap:14px;">
                                                <?php if (!empty($item['hinh_anh'])): ?>
                                                    <img src="<?= BASE_URL ?>img/<?= htmlspecialchars($item['hinh_anh']) ?>" alt="<?= htmlspecialchars($item['ten_san_pham'] ?? '') ?>" style="width:72px; height:72px; object-fit:cover; border-radius:14px; border:1px solid #e2e8f0;">
                                                <?php endif; ?>
                                                <div>
                                                    <strong><?= htmlspecialchars($item['ten_san_pham'] ?? 'Sản phẩm') ?></strong><br>
                                                    <small style="color:#475569;">Mã SP: <?= htmlspecialchars($item['san_pham_id'] ?? '') ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding:16px 18px; vertical-align:middle;"><?= htmlspecialchars($item['so_luong'] ?? 0) ?></td>
                                        <td style="padding:16px 18px; vertical-align:middle;"><?= number_format($item['gia'] ?? 0) ?> ₫</td>
                                        <td style="padding:16px 18px; vertical-align:middle;"><?= number_format((($item['gia'] ?? 0) * ($item['so_luong'] ?? 0))) ?> ₫</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="padding:24px 18px; text-align:center; color:#64748b;">Không tìm thấy sản phẩm trong đơn hàng.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>
