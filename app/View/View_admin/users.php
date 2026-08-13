<?php include 'header.php'; ?>
<section>
    <div class="container">
        <?php if (!empty($_SESSION['info'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_SESSION['info']); unset($_SESSION['info']); ?></div>
        <?php endif; ?>

        <div class="col3">
            <h2>Thêm Mới</h2>
            <form method="POST" action="index_admin.php?page=users" class="form-admin">
                <input type="text" name="name" placeholder="Tên" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Số điện thoại">
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <select name="role">
                    <option value="khach_hang">Người dùng</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="submit" value="Thêm">
            </form>
        </div>
        <div class="col9">
            <h2>Danh Sách</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>SĐT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['ho_ten'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                                <td><?= htmlspecialchars($user['vai_tro'] ?? ($user['role'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($user['so_dien_thoai'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Không có người dùng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
