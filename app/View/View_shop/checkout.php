<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart = isset($cart) && is_array($cart) ? $cart : [];
$total = isset($total) ? (float)$total : 0;

// Lấy thông tin tài khoản nếu đã đăng nhập (tuỳ chỉnh theo session của bạn)
$user = $_SESSION['user'] ?? [];
$fullname = $user['ho_ten'] ?? $user['name'] ?? '';
$phone = $user['so_dien_thoai'] ?? $user['phone'] ?? '';
$email = $user['email'] ?? '';
$address = $user['dia_chi'] ?? $user['address'] ?? '';
?>
<?php require_once 'header.php'; ?>

<style>
    .checkout-wrapper {
        max-width: 1080px;
        margin: 36px auto;
        padding: 0 18px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 28px;
    }
    @media (max-width: 868px) {
        .checkout-grid { grid-template-columns: 1fr; }
    }
    .card-box {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px 28px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 24px;
    }
    .form-group {
        margin-bottom: 16px;
    }
    .form-group label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }
    .radio-card-group {
        display: grid;
        gap: 12px;
    }
    .radio-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fafafa;
    }
    .radio-card:hover {
        border-color: #cbd5e1;
        background: #fff;
    }
    .radio-card input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #0284c7;
    }
    .radio-card.active {
        border-color: #0284c7;
        background: #f0f9ff;
    }
    .badge-vnpay {
        background: #005baa;
        color: white;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: bold;
    }
    .btn-submit {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 12px;
        background: #005baa;
        color: #fff;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .btn-submit:hover {
        background: #004480;
    }
</style>

<main class="checkout-wrapper">
    <!-- Header Page -->
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:28px;">
        <div>
            <h1 style="font-size:1.8rem; font-weight:800; margin:0; color:#0f172a;">Thanh toán đơn hàng</h1>
            <p style="margin:4px 0 0; color:#64748b; font-size:0.95rem;">Vui lòng điền thông tin người nhận và chọn phương thức thanh toán.</p>
        </div>
        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=index" style="padding:10px 16px; background:#fff; border:1px solid #cbd5e1; color:#334155; border-radius:10px; text-decoration:none; font-weight:500; font-size:0.9rem;">
            ← Quay lại giỏ hàng
        </a>
    </div>

    <!-- Alert Thông báo -->
    <?php if (!empty($_SESSION['info'])): ?>
        <div style="margin-bottom:22px; padding:14px 18px; border:1px solid #bbf7d0; background:#f0fdf4; color:#166534; border-radius:12px; font-weight:500;">
            <?= htmlspecialchars($_SESSION['info']); unset($_SESSION['info']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=checkout" id="checkoutForm">
        <div class="checkout-grid">
            
            <!-- CỘT TRÁI: THÔNG TIN GIAO HÀNG & PHƯƠNG THỨC -->
            <div>
                <!-- Thông tin giao hàng -->
                <div class="card-box">
                    <h2 style="font-size:1.2rem; font-weight:700; margin-top:0; margin-bottom:18px; color:#0f172a;">1. Thông tin giao hàng</h2>
                    
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div class="form-group">
                            <label>Họ và tên *</label>
                            <input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($fullname) ?>" required placeholder="Nguyễn Văn A">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại *</label>
                            <input type="tel" name="so_dien_thoai" class="form-control" value="<?= htmlspecialchars($phone) ?>" required placeholder="0901234567">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email (Nhận thông báo đơn hàng)</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="vidu@gmail.com">
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ nhận hàng *</label>
                        <input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($address) ?>" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label>Ghi chú đơn hàng (Tùy chọn)</label>
                        <textarea name="ghi_chu" class="form-control" rows="2" placeholder="Ghi chú thêm cho shipper (Ví dụ: Giao giờ hành chính)"></textarea>
                    </div>
                </div>

                <!-- Phương thức vận chuyển -->
                <div class="card-box">
                    <h2 style="font-size:1.2rem; font-weight:700; margin-top:0; margin-bottom:16px; color:#0f172a;">2. Phương thức vận chuyển</h2>
                    <div class="radio-card-group">
                        <label class="radio-card active">
                            <input type="radio" name="shipping_method" value="Giao hàng tiêu chuẩn" checked onchange="updateShippingFee(0, this)">
                            <div style="flex:1;">
                                <div style="font-weight:600; color:#0f172a;">Giao hàng tiêu chuẩn (2 - 4 ngày)</div>
                                <div style="font-size:0.85rem; color:#64748b;">Miễn phí vận chuyển</div>
                            </div>
                            <span style="font-weight:700; color:#16a34a;">Miễn phí</span>
                        </label>

                        <label class="radio-card">
                            <input type="radio" name="shipping_method" value="Giao hàng hoả tốc" onchange="updateShippingFee(30000, this)">
                            <div style="flex:1;">
                                <div style="font-weight:600; color:#0f172a;">Giao hàng hoả tốc (Trong ngày)</div>
                                <div style="font-size:0.85rem; color:#64748b;">Áp dụng nội thành</div>
                            </div>
                            <span style="font-weight:700; color:#0f172a;">30.000 ₫</span>
                        </label>
                    </div>
                </div>

                <!-- Phương thức thanh toán -->
                <div class="card-box">
                    <h2 style="font-size:1.2rem; font-weight:700; margin-top:0; margin-bottom:16px; color:#0f172a;">3. Phương thức thanh toán</h2>
                    <div class="radio-card-group">
                        <label class="radio-card active">
                            <input type="radio" name="payment_method" value="VNPAY" checked onchange="handlePaymentChange(this)">
                            <div style="flex:1;">
                                <div style="font-weight:600; color:#0f172a; display:flex; align-items:center; gap:8px;">
                                    Thanh toán qua VNPAY <span class="badge-vnpay">Khuyên dùng</span>
                                </div>
                                <div style="font-size:0.85rem; color:#64748b;">Thẻ ATM nội địa, QR Pay, Visa/Mastercard</div>
                            </div>
                        </label>

                        <label class="radio-card">
                            <input type="radio" name="payment_method" value="COD" onchange="handlePaymentChange(this)">
                            <div style="flex:1;">
                                <div style="font-weight:600; color:#0f172a;">Thanh toán khi nhận hàng (COD)</div>
                                <div style="font-size:0.85rem; color:#64748b;">Trả tiền mặt trực tiếp cho shipper khi nhận sản phẩm</div>
                            </div>
                        </label>

                        <label class="radio-card">
                            <input type="radio" name="payment_method" value="BANK_TRANSFER" onchange="handlePaymentChange(this)">
                            <div style="flex:1;">
                                <div style="font-weight:600; color:#0f172a;">Chuyển khoản ngân hàng trực tiếp</div>
                                <div style="font-size:0.85rem; color:#64748b;">Chuyển khoản qua App Ngân hàng / Mã QR</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- CỘT PHẢI: CHI TIẾT ĐƠN HÀNG & NÚT ĐẶT HÀNG -->
            <div>
                <div class="card-box" style="position:sticky; top:20px;">
                    <h2 style="font-size:1.2rem; font-weight:700; margin-top:0; margin-bottom:18px; color:#0f172a;">Đơn hàng của bạn</h2>
                    <div style="margin-bottom:18px; color:#64748b; font-size:0.9rem;">
                        Có <strong><?= array_sum(array_column($cart, 'so_luong')) ?> sản phẩm</strong> trong giỏ
                    </div>

                    <!-- Danh sách sản phẩm trong giỏ -->
                    <?php if (!empty($cart)): ?>
                        <ul style="list-style:none; padding:0; margin:0 0 20px; display:grid; gap:14px; max-height:300px; overflow-y:auto;">
                            <?php foreach ($cart as $item): ?>
                                <li style="display:flex; gap:12px; align-items:center;">
                                    <img src="<?= htmlspecialchars(BASE_URL . 'img/' . ($item['hinh_anh'] ?? '')) ?>" alt="<?= htmlspecialchars($item['ten']) ?>" style="width:60px; height:60px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;" onerror="this.src='<?= BASE_URL ?>img/ao_so_mi(1).webp'">
                                    <div style="flex:1; min-width:0;">
                                        <div style="font-weight:600; color:#0f172a; font-size:0.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($item['ten']) ?></div>
                                        <div style="color:#64748b; font-size:0.82rem;">Size: <?= htmlspecialchars($item['size'] ?? 'Free') ?> &times; <?= (int)$item['so_luong'] ?></div>
                                    </div>
                                    <div style="font-weight:700; color:#0f172a; font-size:0.9rem;">
                                        <?= number_format(($item['gia'] ?? 0) * (int)$item['so_luong']) ?> ₫
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p style="margin:0 0 20px; color:#94a3b8; font-size:0.9rem;">Giỏ hàng của bạn đang trống.</p>
                    <?php endif; ?>

                    <!-- Tính tiền -->
                    <div style="border-top:1px solid #f1f5f9; padding-top:16px; font-size:0.95rem;">
                        <div style="display:flex; justify-content:space-between; color:#64748b; margin-bottom:8px;">
                            <span>Tạm tính</span>
                            <span style="font-weight:600; color:#334155;"><?= number_format($total) ?> ₫</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; color:#64748b; margin-bottom:12px;">
                            <span>Phí vận chuyển</span>
                            <span id="shippingFeeText" style="font-weight:600; color:#16a34a;">Miễn phí</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-weight:800; font-size:1.15rem; color:#0f172a; border-top:1px dashed #e2e8f0; padding-top:12px; margin-bottom:20px;">
                            <span>Tổng thanh toán</span>
                            <span id="grandTotalText" style="color:#005baa;"><?= number_format($total) ?> ₫</span>
                        </div>
                    </div>

                    <!-- Nút xác nhận đặt hàng -->
                    <button type="submit" id="submitBtn" class="btn-submit">
                        Thanh toán ngay qua VNPAY
                    </button>
                    
                    <p style="margin:12px 0 0; text-align:center; font-size:0.8rem; color:#94a3b8;">
                        Bằng việc đặt hàng, bạn đồng ý với điều khoản dịch vụ của cửa hàng.
                    </p>
                </div>
            </div>

        </div>
    </form>
</main>

<script>
    const baseTotal = <?= (float)$total ?>;
    let currentShipping = 0;

    // Cập nhật phí vận chuyển và tổng tiền
    function updateShippingFee(fee, radioInput) {
        currentShipping = fee;
        const grandTotal = baseTotal + currentShipping;
        
        document.getElementById('shippingFeeText').innerText = fee === 0 ? 'Miễn phí' : fee.toLocaleString('vi-VN') + ' ₫';
        document.getElementById('shippingFeeText').style.color = fee === 0 ? '#16a34a' : '#0f172a';
        document.getElementById('grandTotalText').innerText = grandTotal.toLocaleString('vi-VN') + ' ₫';

        // Style active cho radio card
        const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
        shippingRadios.forEach(r => r.closest('.radio-card').classList.remove('active'));
        radioInput.closest('.radio-card').classList.add('active');
    }

    // Đổi chữ nút submit tùy theo hình thức thanh toán
    function handlePaymentChange(radioInput) {
        const btn = document.getElementById('submitBtn');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        paymentRadios.forEach(r => r.closest('.radio-card').classList.remove('active'));
        radioInput.closest('.radio-card').classList.add('active');

        if (radioInput.value === 'VNPAY') {
            btn.innerText = 'Thanh toán ngay qua VNPAY';
            btn.style.background = '#005baa';
        } else if (radioInput.value === 'COD') {
            btn.innerText = 'Xác nhận đặt hàng (COD)';
            btn.style.background = '#0f172a';
        } else {
            btn.innerText = 'Xác nhận & Nhận thông tin chuyển khoản';
            btn.style.background = '#0284c7';
        }
    }
</script>

<?php require_once 'footer.php'; ?>