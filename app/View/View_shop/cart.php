<?php require_once 'header.php'; ?>

<style>
.cart-page { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
.cart-page h2 { font-size: 26px; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px; }
.cart-empty { text-align: center; padding: 60px 0; color: #888; font-size: 18px; }
.cart-empty a { color: #333; font-weight: bold; text-decoration: underline; }

.cart-table { width: 100%; border-collapse: collapse; }
.cart-table th { border-bottom: 2px solid #222; padding: 12px 8px; text-align: left; font-size: 13px; text-transform: uppercase; }
.cart-table td { padding: 16px 8px; border-bottom: 1px solid #eee; vertical-align: middle; }

.cart-table .product-cell { display: flex; align-items: center; gap: 16px; }
.cart-table .product-cell img { width: 80px; height: 96px; object-fit: cover; border: 1px solid #eee; }
.cart-table .product-name { font-weight: 600; font-size: 15px; }
.cart-table .product-size { color: #777; font-size: 13px; margin-top: 4px; }

.qty-form { display: flex; align-items: center; gap: 0; }
.qty-form input[type=number] {
    width: 54px; height: 38px; border: 1px solid #ddd;
    text-align: center; font-size: 15px; font-weight: bold;
    
}
.qty-form input::-webkit-outer-spin-button,
.qty-form input::-webkit-inner-spin-button { -webkit-appearance: none; }
.qty-form button {
    width: 36px; height: 38px; border: 1px solid #ddd; background: #f5f5f5;
    font-size: 18px; cursor: pointer; line-height: 1;
}
.qty-form button:hover { background: #e0e0e0; }

.btn-remove {
    background: none; border: none; color: #e53935; font-size: 20px;
    cursor: pointer; padding: 4px 8px;
}
.btn-remove:hover { color: #b71c1c; }

.cart-footer { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 32px; flex-wrap: wrap; gap: 24px; }
.cart-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-continue { padding: 13px 28px; border: 1px solid #333; background: #fff; font-weight: bold; cursor: pointer; text-decoration: none; color: #333; font-size: 14px; }
.btn-continue:hover { background: #f5f5f5; }
.btn-clear { padding: 13px 28px; border: 1px solid #e53935; background: #fff; color: #e53935; font-weight: bold; cursor: pointer; font-size: 14px; }
.btn-clear:hover { background: #fff3f3; }

.cart-summary { background: #f9f9f9; padding: 24px; min-width: 260px; }
.cart-summary h3 { font-size: 16px; text-transform: uppercase; margin-bottom: 16px; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 15px; }
.summary-row.total { font-weight: bold; font-size: 18px; border-top: 1px solid #ddd; padding-top: 12px; margin-top: 8px; }
.btn-checkout {
    display: block; width: 100%; padding: 14px; background: #222; color: #fff;
    border: none; font-weight: bold; font-size: 15px; cursor: pointer;
    text-transform: uppercase; margin-top: 16px; text-align: center;
    text-decoration: none;
}
.btn-checkout:hover { background: #000; }
</style>

<div class="cart-page">
    <h2>🛒 Giỏ hàng của bạn</h2>

    <?php
    $cart  = $_SESSION['cart'] ?? [];
    $total = 0;
    foreach ($cart as $item) $total += $item['gia'] * $item['so_luong'];
    ?>

    <?php if (empty($cart)): ?>
        <div class="cart-empty">
            <p>Giỏ hàng đang trống.</p>
            <br>
            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index">← Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $key => $item): ?>
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="<?= BASE_URL ?>img/<?= htmlspecialchars($item['hinh_anh']) ?>"
                                 onerror="this.src='<?= BASE_URL ?>img/ao_so_mi(1).webp'"
                                 alt="<?= htmlspecialchars($item['ten']) ?>">
                            <div>
                                <div class="product-name"><?= htmlspecialchars($item['ten']) ?></div>
                                <div class="product-size">Size: <?= htmlspecialchars($item['size']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?= number_format($item['gia']) ?> ₫</td>
                    <td>
                        <form method="POST" action="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=update">
                            <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                            <div class="qty-form">
                                <button type="button" onclick="changeQty(this, -1)">−</button>
                                <input type="number" name="so_luong" value="<?= (int)$item['so_luong'] ?>" min="1" max="99"
                                       onchange="this.form.submit()">
                                <button type="button" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </form>
                    </td>
                    <td><strong><?= number_format($item['gia'] * $item['so_luong']) ?> ₫</strong></td>
                    <td>
                        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=remove&key=<?= urlencode($key) ?>">
                            <button class="btn-remove" title="Xóa">✕</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-footer">
            <div class="cart-actions">
                <a class="btn-continue" href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index">← Tiếp tục mua sắm</a>
                <a class="btn-clear" href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=clear">Xóa giỏ hàng</a>
            </div>

            <div class="cart-summary">
                <h3>Tóm tắt đơn hàng</h3>
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span><?= number_format($total) ?> ₫</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span>Miễn phí</span>
                </div>
                <div class="summary-row total">
                    <span>Tổng cộng</span>
                    <span><?= number_format($total) ?> ₫</span>
                </div>
                <?php if (!empty($_SESSION['user'])): ?>
                    <a class="btn-checkout" href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=checkout">
                        Tiến hành đặt hàng →
                    </a>
                <?php else: ?>
                    <a class="btn-checkout" href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=login">
                        Đăng nhập để đặt hàng →
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>
</div>

<script>
function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[type=number]');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    input.form.submit();
}
</script>

<?php require_once 'footer.php'; ?>