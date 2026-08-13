<style>
.order-detail-wrapper {
    width: 85vw;
    margin-left: 250px; /* chừa 20% cho menu bên trái */
    padding: 2rem;
    font-family: 'Arial', sans-serif;
    color: #333;
    box-sizing: border-box;
}

/* Tiêu đề */
h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #222;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

h2 .badge {
    margin-left: auto;
    font-size: 1rem;
    background-color: #343a40;
    color: #fff;
}

/* Card chung */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

/* Header card */
.card-header {
    padding: 1.5rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    color: #fff;
}

.bg-primary { background: linear-gradient(135deg, #007bff, #0056b3); }
.bg-info { background: linear-gradient(135deg, #17a2b8, #117a8b); }
.bg-dark { background: linear-gradient(135deg, #343a40, #1d2124); }

/* Body card */
.card-body {
    padding: 2rem;
    background-color: #fff;
    font-size: 1rem;
    line-height: 1.6;
}

.card-body p {
    margin-bottom: 1rem;
}

/* Table sản phẩm */
.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
    min-width: 600px;
}

table th, table td {
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

table th {
    background-color: #f7f7f7;
    font-weight: 600;
    color: #555;
}

table tr:nth-child(even) {
    background-color: #fafafa;
}

table tr:hover {
    background-color: #f1f7ff;
}

tfoot tr {
    background-color: #343a40;
    color: #fff;
    font-weight: 700;
}

/* Badge trạng thái */
.badge {
    display: inline-block;
    padding: 0.35em 0.75em;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
}

/* Text utilities */
.fw-bold { font-weight: 700; }
.text-danger { color: #dc3545; }
.text-success { color: #28a745; }
.text-primary { color: #007bff; }
.text-end { text-align: right; }
.text-center { text-align: center; }

/* Button */
.btn {
    font-size: 1rem;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* Shadow tùy chỉnh cho card */
.card-shadow-custom {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

</style>



<div class="order-detail-wrapper">

    <?php $orderInfo = $order[0] ?? []; ?>

    <h2 class="mb-5 text-primary fw-bold" style="font-size: 2.2rem;">
        <i class="bi bi-receipt-cutoff"></i> Chi tiết đơn hàng
        <span class="badge bg-dark order-badge-id">#<?= htmlspecialchars($orderInfo['don_hang_id'] ?? $orderInfo['id'] ?? '—') ?></span>
    </h2>

    <div class="row g-5 mb-5">
        <!-- Thông tin đơn hàng -->
        <div class="col-xxl-8">
            <div class="card card-shadow-custom">
                <div class="card-header bg-gradient bg-primary text-white py-4">
                    <h4 class="mb-0"><i class="bi bi-cart4"></i> Thông tin đơn hàng</h4>
                </div>
                <div class="card-body p-5 fs-5">
                    <p><strong>Ngày tạo:</strong> <?= !empty($orderInfo['ngay_tao']) ? date('d/m/Y - H:i:s', strtotime($orderInfo['ngay_tao'])) : '—' ?></p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($orderInfo['tong_tien'] ?? 0) ?> đ</p>
                    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($orderInfo['trang_thai_thanh_toan'] ?? '—') ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($orderInfo['ten_thanh_toan'] ?? 'Chưa chọn') ?></p>
                    <p><strong>Vận chuyển:</strong> <?= htmlspecialchars($orderInfo['ten_van_chuyen'] ?? '—') ?></p>
                    <p><strong>Phí ship:</strong> <?= number_format($orderInfo['phi_van_chuyen'] ?? 0) ?> đ</p>
                    <p><strong>Mã giảm giá:</strong> <?= htmlspecialchars($orderInfo['ma_giam'] ?? '—') ?></p>
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="col-xxl-4">
            <div class="card card-shadow-custom h-100">
                <div class="card-header bg-gradient bg-info text-white py-4">
                    <h4 class="mb-0"><i class="bi bi-person-circle"></i> Khách hàng</h4>
                </div>
                <div class="card-body p-5 fs-5">
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($orderInfo['ho_ten'] ?? 'Khách lẻ') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($orderInfo['email'] ?? '—') ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($orderInfo['so_dien_thoai'] ?? '—') ?></p>
                    <p><strong>Địa chỉ giao:</strong> <?= htmlspecialchars($orderInfo['dia_chi'] ?? '—') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm -->
    <div class="card card-shadow-custom">
        <div class="card-header bg-gradient bg-dark text-white py-4">
            <h4 class="mb-0"><i class="bi bi-box-seam"></i> Sản phẩm trong đơn hàng</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary fw-bold">
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($order as $item): ?>
                            <?php $lineTotal = ($item['gia'] ?? 0) * ($item['so_luong'] ?? 0); $total += $lineTotal; ?>
                            <tr>
                                <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                                <td><?= number_format($item['gia'] ?? 0) ?> đ</td>
                                <td><?= $item['so_luong'] ?? 0 ?></td>
                                <td><?= number_format($lineTotal) ?> đ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="3" class="text-end fw-bold">TỔNG CỘNG</td>
                            <td class="fw-bold"><?= number_format($total) ?> đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="index_admin.php?page=order_list" class="btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow">
            Quay lại danh sách
        </a>
        <a href="index_admin.php?page=order_edit_form&id=<?= $orderInfo['don_hang_id'] ?? '' ?>" 
           class="btn btn-warning btn-lg px-5 py-3 rounded-pill shadow ms-3">
            Sửa trạng thái thanh toán
        </a>
    </div>

</div>
<?php include 'footer.php'; ?>
