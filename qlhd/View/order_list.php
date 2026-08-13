<style>
.order-list-wrapper {
    margin-left: 250px; /* khoảng rộng menu bên trái */
    padding: 2rem;      /* khoảng cách nội dung */
    font-family: Arial, sans-serif;
    color: #333;
    box-sizing: border-box;
    width: 100%;
}

/* Header và form tìm kiếm */
.order-list-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    gap: 1rem;
}

.order-list-header h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}

.order-list-header form {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.order-list-header input[type="text"] {
    padding: 0.5rem 1rem;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.order-list-header button {
    padding: 0.5rem 1rem;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
}

/* Bảng chiếm full width phần nội dung bên phải */
.table-wrapper {
    width: calc(100% - 20%); /* 100% trừ menu bên trái */
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 0.75rem 1rem;
    text-align: left;
}

.table th {
    background-color: #f7f7f7;
    font-weight: 600;
    color: #555;
}

.table tbody tr:nth-child(even) {
    background-color: #fafafa;
}

.table tbody tr:hover {
    background-color: #f1f7ff;
}

/* Badge */
.badge {
    display: inline-block;
    padding: 0.35em 0.7em;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
}

.bg-success { background-color: #28a745; }
.bg-warning { background-color: #ffc107; color: #212529; }

/* Nút */
.btn {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
}

.btn-sm { font-size: 0.75rem; padding: 0.3rem 0.6rem; }

.btn-info { background-color: #17a2b8; color: #fff; }
.btn-info:hover { background-color: #117a8b; }

.btn-warning { background-color: #ffc107; color: #212529; }
.btn-warning:hover { background-color: #e0a800; }

.btn-danger { background-color: #dc3545; color: #fff; }
.btn-danger:hover { background-color: #a71d2a; }

/* Responsive */
@media (max-width: 768px) {
    .order-list-wrapper {
        margin-left: 0;
        padding: 1rem;
    }

    .order-list-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .order-list-header form {
        width: 100%;
    }

    .order-list-header button {
        width: 100%;
    }
}
</style>
<div class="order-list-wrapper">

    <div class="order-list-header">
        <h2>Danh sách hóa đơn</h2>
    </div>

    <div class="table-wrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tổng tiền</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= number_format($order['tong_tien']) ?>đ</td>
                        <td><?= date('d/m/Y H:i', strtotime($order['ngay_tao'])) ?></td>
                        <td>
                            <span class="badge <?= $order['trang_thai_thanh_toan'] === 'Đã thanh toán' ? 'bg-success' : 'bg-warning' ?>">
                                <?= $order['trang_thai_thanh_toan']?>
                            </span>
                        </td>
                        <td>
                            <a href="index_admin.php?page=order_detail&id=<?= $order['id'] ?>" class="btn btn-sm btn-info">Xem</a>
                            <a href="index_admin.php?page=order_edit_form&id=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="index_admin.php?page=order_delete&id=<?= $order['id'] ?>" 
                               onclick="return confirm('Xóa đơn hàng này?')" 
                               class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
