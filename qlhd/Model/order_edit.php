<style>
.main-container {
    margin-left: 250px;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Nhãn của bảng */
.table-label {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
    margin: 20px 0 10px;
}

/* Box chứa label + table */
.table-box {
    margin-bottom: 30px;
}

/* Bảng */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

th {
    background: #f5f5f5;
    font-weight: bold;
    text-align: left;
}

.product-table tbody tr:hover {
    background: #f0f7ff;
}

/* Form cập nhật trạng thái */
.status-update-box {
    justify-content: left;
    margin-top: 20px;
}

.status-inner {
    background: white;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
}

.status-inner select {
    padding: 8px 12px;
    font-size: 16px;
    margin-top: 10px;
}

.status-inner button {
    margin-top: 15px;
    padding: 10px 18px;
    background: #007bff;
    border: none;
    color: white;
    font-size: 15px;
    border-radius: 6px;
    cursor: pointer;
}

.status-inner button:hover {
    background: #0056c7;
}

.back-link {
    margin-top: 25px;
    display: inline-block;
}
</style>


<?php 
$trangThai = [
    "Chờ xác nhận" => 1,
    "Đã xác nhận" => 2,
    "Đang giao" => 3,
    "Đã hủy" => 4,
    "Hoàn thành" => 4
];
$currentStatus = $order[0]['trang_thai_thanh_toan'];
?>

<div class="main-container">

    <div class="order-layout">

        <!-- BÊN TRÁI -->
        <div class="table-box">
            <div class="table-label">Thông tin đơn hàng</div>
            <table class="info-table">
                <tr><th>Khách hàng</th><td><?= $order[0]['ho_ten']; ?></td></tr>
                <tr><th>Địa chỉ</th><td><?= $order[0]['dia_chi']; ?></td></tr>
                <tr><th>Ngày tạo</th><td><?= $order[0]['ngay_tao']; ?></td></tr>
                <tr><th>Trạng thái</th><td><?= $order[0]['trang_thai_thanh_toan']; ?></td></tr>
                <tr><th>Tổng đơn</th><td><?= number_format($order[0]['tong_tien']); ?> đ</td></tr>
            </table>
        </div>

        <!-- BÊN PHẢI -->
        <div class="table-box">
            <div class="table-label">Danh sách sản phẩm</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order as $item): ?>
                    <tr>
                        <td><?= $item['ten_san_pham']; ?></td>
                        <td><?= number_format($item['gia']); ?> đ</td>
                        <td><?= $item['so_luong']; ?></td>
                        <td><?= number_format($item['gia'] * $item['so_luong']); ?> đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

 <div class="status-update-box">
 <form method="POST" action="index_admin.php?page=order_update" class="status-inner">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <select name="trang_thai_thanh_toan">
        <?php 
        $currentStatus = $order[0]['trang_thai_thanh_toan'];
        $currentLevel = $trangThai[$currentStatus];
        foreach ($trangThai as $status => $level): 
            if ($currentStatus === "Hoàn thành" && $status === "Đã hủy") continue;
            if ($currentStatus === "Đã hủy" && $status === "Hoàn thành") continue;


            if ($level >= $currentLevel):
        ?>
            <option value="<?= $status ?>" <?= $status === $currentStatus ? "selected" : "" ?>>
                <?= $status ?>
            </option>
        <?php endif; endforeach; ?>
    </select>

    <br><button type="submit">Cập nhật</button>
</form>

</div>


    <a href="index_admin.php?page=order_list" class="back-link">Quay lại danh sách</a>

</div>
