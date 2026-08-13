<?php include "header.php"; ?>
<div class="container">
    <?php if (empty($product)): ?>
        <div class="alert alert-danger">Sản phẩm không tồn tại.</div>
    <?php else: ?>
        <h2>Sửa Sản Phẩm</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="form-admin">
            <label for="ten_san_pham">Tên sản phẩm:</label>
            <input type="text" name="ten_san_pham" id="ten_san_pham" value="<?= htmlspecialchars($product['ten_san_pham'] ?? '') ?>" required>

            <label for="danh_muc_id">Danh mục:</label>
            <select name="danh_muc_id" id="danh_muc_id" required>
                <option value="1" <?= (isset($product['danh_muc_id']) && $product['danh_muc_id']==1) ? 'selected' : '' ?>>Áo</option>
                <option value="2" <?= (isset($product['danh_muc_id']) && $product['danh_muc_id']==2) ? 'selected' : '' ?>>Quần</option>
            </select>

            <label for="mo_ta">Mô tả:</label>
        <textarea name="mo_ta" id="mo_ta" required><?= htmlspecialchars($product['mo_ta']) ?></textarea>

        <label for="hinh_anh">Hình ảnh hiện tại:</label>
        <div><img src="<?= BASE_URL ?>img/<?= htmlspecialchars($product['hinh_anh']) ?>" width="120"></div>

        <label for="hinh_anh">Thay đổi hình ảnh:</label>
        <input type="file" name="hinh_anh" id="hinh_anh">

        <button type="submit">Cập nhật sản phẩm</button>
    </form>
    <?php endif; ?>
</div>
<?php include "footer.php"; ?>
