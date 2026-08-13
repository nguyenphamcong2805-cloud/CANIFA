<div class="order-container">

    <h2 class="page-title">Danh sách hóa đơn</h2>

    <!-- FORM LỌC -->
    <div class="filter-box">
        <form method="get" class="filter-form">
            <input type="hidden" name="page" value="order_list">
            <div class="filter-grid">
                <div class="filter-group">
                    <label>Sắp xếp theo ngày</label>
                    <select name="sort">
                        <option value="newest" <?= (!isset($_GET['sort']) || $_GET['sort'] !== 'oldest') ? 'selected' : '' ?>>
                            Mới nhất trước
                        </option>
                        <option value="oldest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : '' ?>>
                            Cũ nhất trước
                        </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Trạng thái thanh toán</label>
                    <select name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Chờ xử lý" <?= @$_GET['status'] === 'Chờ xử lý' ? 'selected' : '' ?>>Chờ xử lý</option>
                        <option value="Chờ xác nhận" <?= @$_GET['status'] === 'Chờ xác nhận' ? 'selected' : '' ?>>Chờ xác nhận</option>
                        <option value="Đang giao" <?= @$_GET['status'] === 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                        <option value="Đã xác nhận" <?= @$_GET['status'] === 'Đã xác nhận' ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="Hoàn thành" <?= @$_GET['status'] === 'Hoàn thành' ? 'selected' : '' ?>>Hoàn thành</option>
                        <option value="Đã thanh toán" <?= @$_GET['status'] === 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
                        <option value="Đã hủy" <?= @$_GET['status'] === 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn-filter">Lọc ngay</button>
                    <?php if (isset($_GET['sort']) || isset($_GET['status'])): ?>
                        <a href="?page=order_list" class="btn-reset">Xóa lọc</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- BẢNG ĐƠN HÀNG -->
    <div class="table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th width="80">STT</th>
                    <th width="100">Mã đơn</th>
                    <th width="180">Tổng tiền</th>
                    <th width="170">Ngày tạo</th>
                    <th width="150">Trạng thái</th>
                    <th width="300">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" class="empty-text">
                            <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i><br>
                            Chưa có đơn hàng nào
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $stt = 1; foreach ($orders as $order): ?>
                        <tr>
                            <td class="center"><?= $stt++ ?></td>
                            <td class="center"><strong>#<?= $order['id'] ?></strong></td>
                            <td class="price"><?= number_format($order['tong_tien']) ?> ₫</td>
                            <td class="center"><?= date('d/m/Y H:i', strtotime($order['ngay_tao'])) ?></td>
                            <td class="center">
                                <?php
                                $status = $order['trang_thai_thanh_toan'];
                                $badge = [
                                    'Hoàn thành' => 'success',
                                    'Đang giao'  => 'info',
                                    'Đã hủy'     => 'danger',
                                    'Chờ xử lý'  => 'warning'
                                ][$status] ?? 'secondary';
                                ?>
                                <span class="status-badge <?= $badge ?>"><?= $status ?></span>
                            </td>
                            <td class="actions">
                                <a href="index_admin.php?page=order_detail&id=<?= $order['id'] ?>" class="btn-small btn-view">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a href="index_admin.php?page=order_edit_form&id=<?= $order['id'] ?>" class="btn-small btn-edit">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="index_admin.php?page=order_delete&id=<?= $order['id'] ?>" 
                                   onclick="return confirm('Xóa vĩnh viễn đơn hàng #<?= $order['id'] ?>?')" 
                                   class="btn-small btn-delete">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>

<!-- STYLE ĐẸP, TO RÕ, KHÔNG BỊ ĐÈ SIDEBAR -->
<style>
.order-container {
    margin-left: 260px;        
    padding: 30px 40px;
    background: #f4f6f9;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    width: 100%;
}

.page-title {
    font-size: 28px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 4px solid #3498db;
    display: inline-block;
}

.filter-box {
    background: white;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.filter-grid {
    display: grid;
    grid-template-columns: 300px 320px 1fr;
    gap: 25px;
    align-items: end;
}

.filter-group label {
    display: block;
    font-weight: 600;
    color: #2d3436;
    margin-bottom: 10px;
    font-size: 15px;
}

.filter-group select {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #ddd;
    border-radius: 10px;
    font-size: 15px;
    background: white;
    transition: all 0.3s;
}

.filter-group select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
    outline: none;
}

.filter-buttons {
    text-align: right;
}

.btn-filter, .btn-reset {
    padding: 14px 32px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-block;
    text-decoration: none;
    line-height: 1;
}

.btn-filter {
    background: #3498db;
    color: white;
    margin-right: 12px;
}

.btn-filter:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

.btn-reset {
    background: #e74c3c;
    color: white;
}

.btn-reset:hover {
    background: #c0392b;
}

.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15.5px;
}

.order-table th {
    background: #2c3e50;
    color: white;
    padding: 20px 15px;
    text-align: center;
    font-weight: 600;
    font-size: 15px;
}

.order-table td {
    padding: 22px 15px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

.order-table tbody tr:hover {
    background-color: #f8fbff;
}

.order-table tbody tr:last-child td {
    border-bottom: none;
}

.center { text-align: center; }
.price { font-weight: 700; color: #e74c3c; font-size: 16.5px; }
.actions { white-space: nowrap; }

.btn-small {
    padding: 10px 16px;
    margin: 0 6px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    min-width: 80px;
    transition: all 0.2s;
}

.btn-view { background: #3498db; color: white; }
.btn-view:hover { background: #2980b9; }

.btn-edit { background: #f39c12; color: white; }
.btn-edit:hover { background: #e67e22; }

.btn-delete { background: #e74c3c; color: white; }
.btn-delete:hover { background: #c0392b; }

.status-badge {
    padding: 6px 16px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 13px;
}

.status-badge.success { background: #27ae60; color: white; }
.status-badge.info    { background: #2980b9; color: white; }
.status-badge.warning { background: #f39c12; color: white; }
.status-badge.danger  { background: #c0392b; color: white; }

.empty-text {
    padding: 80px 20px;
    color: #95a5a6;
    font-size: 18px;
}

/* Responsive */
@media (max-width: 1200px) {
    .filter-grid { grid-template-columns: 1fr; }
    .filter-buttons { text-align: left; margin-top: 15px; }
}

@media (max-width: 992px) {
    .order-container { margin-left: 0; padding: 20px 15px; }
}
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">