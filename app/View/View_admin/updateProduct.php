<?php 
require_once __DIR__ . '/Database.php'; 
include "header.php"; 

$db = new Database();
$conn = $db->getConnection();

// 1. Lấy thông tin sản phẩm cần sửa theo ID
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='container'><p style='color:red;'>Không tìm thấy ID sản phẩm!</p></div>";
    include "footer.php";
    exit;
}

// Lấy dữ liệu sản phẩm hiện tại
$stmt = $conn->prepare("SELECT * FROM san_pham WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<div class='container'><p style='color:red;'>Sản phẩm không tồn tại!</p></div>";
    include "footer.php";
    exit;
}

// 2. Xử lý khi người dùng nhấn "Cập nhật"
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_san_pham = trim($_POST['ten_san_pham']);
    $gia = trim($_POST['gia']);
    $mo_ta = trim($_POST['mo_ta']);
    $trang_thai = (int)$_POST['trang_thai']; // Lấy trạng thái: 1 (Còn hàng) hoặc 0 (Hết hàng)
    
    // Giữ lại tên ảnh cũ mặc định
    $hinh_anh = $product['hinh_anh'];

    // Kiểm tra nếu người dùng chọn upload ảnh mới
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['hinh_anh']['tmp_name'];
        $fileName = $_FILES['hinh_anh']['name'];
        
        $newFileName = time() . '_' . $fileName;
        $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/FPL/DEV/public/Shop/img/';
        
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $hinh_anh = $newFileName;
        } else {
            $error = "Có lỗi xảy ra khi tải ảnh mới lên.";
        }
    }

    if (empty($error)) {
        // Cập nhật bao gồm cả cột trang_thai vào Cơ sở dữ liệu
        $updateSql = "UPDATE san_pham SET ten_san_pham = ?, gia = ?, mo_ta = ?, hinh_anh = ?, trang_thai = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $result = $updateStmt->execute([$ten_san_pham, $gia, $mo_ta, $hinh_anh, $trang_thai, $id]);

        if ($result) {
            $success = "Cập nhật sản phẩm thành công!";
            // Load lại dữ liệu mới nhất
            $product['ten_san_pham'] = $ten_san_pham;
            $product['gia'] = $gia;
            $product['mo_ta'] = $mo_ta;
            $product['hinh_anh'] = $hinh_anh;
            $product['trang_thai'] = $trang_thai;
        } else {
            $error = "Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}
?>

<div class="container">
    <h2>Sửa Sản Phẩm</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="ten_san_pham" value="<?= htmlspecialchars($product['ten_san_pham'] ?? '') ?>" required><br><br>

        <label>Giá:</label><br>
        <input type="number" name="gia" value="<?= htmlspecialchars($product['gia'] ?? 0) ?>" required><br><br>

        <label>Trạng thái sản phẩm:</label><br>
        <select name="trang_thai" style="padding: 5px; width: 200px;">
            <option value="1" <?= (isset($product['trang_thai']) && $product['trang_thai'] == 1) ? 'selected' : '' ?>>Còn hàng</option>
            <option value="0" <?= (isset($product['trang_thai']) && $product['trang_thai'] == 0) ? 'selected' : '' ?>>Hết hàng</option>
        </select><br><br>

        <label>Mô tả:</label><br>
        <textarea name="mo_ta" rows="4" cols="50"><?= htmlspecialchars($product['mo_ta'] ?? '') ?></textarea><br><br>

        <label>Hình ảnh hiện tại:</label><br>
        <?php if (!empty($product['hinh_anh'])): ?>
            <img src="/FPL/DEV/public/Shop/img/<?= htmlspecialchars($product['hinh_anh']) ?>" width="100" style="margin-bottom: 10px;"><br>
        <?php endif; ?>
        <input type="file" name="hinh_anh" accept="image/*"><br><br>

        <input type="submit" value="Cập nhật">
    </form>
</div>

<?php include "footer.php"; ?>