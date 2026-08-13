<?php include "header.php"; ?>
<div class="container">
<h2>Danh Sách Sản Phẩm</h2>
<a href="?page=addProduct">Thêm Sản Phẩm Mới</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Hình</th>
            <th>Tên</th>
            <th>Trạng thái </th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id'] ?? '') ?></td>
            <td><img src="<?= BASE_URL ?>img/<?= htmlspecialchars($p['hinh_anh'] ?? 'default.png') ?>" width="80" alt="<?= htmlspecialchars($p['ten_san_pham'] ?? '') ?>"/></td>
            <td><?= htmlspecialchars($p['ten_san_pham'] ?? '') ?></td>

            <td><?= htmlspecialchars($p['trang_thai'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['mo_ta'] ?? '') ?></td>
            <td>
                <a href="?page=updateProduct&id=<?= $p['id'] ?>">Sửa</a> |
                <a href="?page=deleteProduct&id=<?= $p['id'] ?>" onclick="return confirm('Bạn có chắc?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include "footer.php"; ?>
