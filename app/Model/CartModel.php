<?php

class CartModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy giỏ hàng của user
    public function getCartByUserId($userId)
    {
        $sql = "SELECT gh.id FROM gio_hang gh WHERE gh.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo giỏ hàng mới
    public function createCart($userId)
    {
        $sql = "INSERT INTO gio_hang (user_id) VALUES (:user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    // Thêm sản phẩm vào chi tiết giỏ hàng
    public function addToCart($cartId, $productId, $quantity)
    {
        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $sqlCheck = "SELECT id, so_luong FROM chi_tiet_gio_hang WHERE gio_hang_id = :cart_id AND san_pham_id = :product_id";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([':cart_id' => $cartId, ':product_id' => $productId]);
        $item = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Đã có -> Cộng dồn số lượng
            $newQuantity = $item['so_luong'] + $quantity;
            $sqlUpdate = "UPDATE chi_tiet_gio_hang SET so_luong = :quantity WHERE id = :id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            return $stmtUpdate->execute([':quantity' => $newQuantity, ':id' => $item['id']]);
        } else {
            // Chưa có -> Thêm mới
            $sqlInsert = "INSERT INTO chi_tiet_gio_hang (gio_hang_id, san_pham_id, so_luong) VALUES (:cart_id, :product_id, :quantity)";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            return $stmtInsert->execute([':cart_id' => $cartId, ':product_id' => $productId, ':quantity' => $quantity]);
        }
    }
}