<?php
// Kiểm tra và gán biến an toàn để tránh lỗi Undefined variable $dsdm hoặc $dm_edit
if (isset($dm_edit) && is_array($dm_edit)) {
    $name = $dm_edit['ten_danh_muc'] ?? '';
    $editId = $dm_edit['id'] ?? 0;
} else {
    $name = '';
    $editId = 0;
}

$dsdm = isset($dsdm) && is_array($dsdm) ? $dsdm : [];
?>

<style>
    .category-section {
        padding: 20px 0;
        font-family: Arial, sans-serif;
    }

    .category-container {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .col-form {
        flex: 1;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #eef2f5;
    }

    .col-list {
        flex: 2;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border: 1px solid #eef2f5;
    }

    .category-section h2 {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f3f6;
    }

    .category-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .category-form input[type="text"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .category-form input[type="text"]:focus {
        outline: none;
        border-color: #4e73df;
    }

    .category-form input[type="submit"] {
        padding: 10px 20px;
        background: #4e73df;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .category-form input[type="submit"]:hover {
        background: #2e59d9;
    }

    .btn-cancel {
        display: inline-block;
        text-align: center;
        padding: 8px 15px;
        background: #858796;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        margin-top: 5px;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .category-table th, .category-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eef2f5;
        font-size: 14px;
    }

    .category-table th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: 700;
    }

    .action-icons a {
        display: inline-block;
        margin-right: 12px;
        font-size: 16px;
        text-decoration: none;
    }

    .action-icons .fa-edit { color: #4e73df; }
    .action-icons .fa-trash-alt { color: #e74a3b; }
    .action-icons a:hover { opacity: 0.8; }

    @media (max-width: 768px) {
        .category-container {
            flex-direction: column;
        }
    }
</style>

<section class="category-section">
    <div class="category-container">
        <!-- Cột Form Thêm / Sửa -->
        <div class="col-form">
            <h2><?= $editId ? 'Sửa danh mục' : 'Thêm mới danh mục' ?></h2>
            <form method="POST" action="" class="category-form">
                <input type="hidden" name="idedit" value="<?= $editId ?>">
                <div>
                    <label style="display:block; margin-bottom: 5px; font-weight: 600; font-size: 13px;">Tên danh mục:</label>
                    <input type="text" placeholder="Nhập tên danh mục..." name="catname" value="<?= htmlspecialchars($name) ?>" required>
                </div>
                <input type="submit" value="<?= $editId ? 'Cập nhật' : 'Thêm mới' ?>" name="add_cat">
                <?php if ($editId): ?>
                    <a href="index_admin.php?page=category" class="btn-cancel">Hủy chỉnh sửa</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Cột Danh Sách -->
        <div class="col-list">
            <h2>Danh Sách Danh Mục</h2>
            <table class="category-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">STT</th>
                        <th>Tên danh mục</th>
                        <th style="width: 120px; text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dsdm)): ?>
                        <?php 
                        $i = 0;
                        foreach ($dsdm as $dm): 
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><strong><?= htmlspecialchars($dm['ten_danh_muc']) ?></strong></td>
                            <td class="action-icons" style="text-align: center;">
                                <a href="index_admin.php?page=category&idedit=<?= $dm['id'] ?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                <a href="index_admin.php?page=category_delete&id=<?= $dm['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #888; font-style: italic;">Chưa có danh mục nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>x