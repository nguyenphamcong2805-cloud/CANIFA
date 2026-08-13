<?php
require_once __DIR__ . '/Database.php';

class Order {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAll($sort = 'newest', $status = null) {
        $sql = "SELECT * FROM don_hang";
        $params = [];

        if (!empty($status)) {
            $sql .= " WHERE trang_thai_thanh_toan = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY ngay_tao " . ($sort === 'oldest' ? 'ASC' : 'DESC');

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getById($id) {
        $sql = "SELECT dh.id AS don_hang_id, dh.nguoi_dung_id, dh.phuong_thuc_van_chuyen_id, dh.phuong_thuc_thanh_toan_id, dh.ma_giam_gia_id, dh.trang_thai_thanh_toan, dh.tong_tien, dh.ngay_tao,
                    nd.ho_ten, nd.email, nd.so_dien_thoai, nd.dia_chi, ptvc.ten_phuong_thuc AS ten_van_chuyen, ptvc.phi_van_chuyen AS phi_van_chuyen,
                    pttt.ten_phuong_thuc AS ten_thanh_toan,
                    mg.ma AS ma_giam,
                    sp.ten_san_pham,
                    ctdh.so_luong, ctdh.gia
                FROM don_hang dh
                LEFT JOIN nguoi_dung nd ON dh.nguoi_dung_id = nd.id
                LEFT JOIN phuong_thuc_van_chuyen ptvc ON dh.phuong_thuc_van_chuyen_id = ptvc.id
                LEFT JOIN phuong_thuc_thanh_toan pttt ON dh.phuong_thuc_thanh_toan_id = pttt.id
                LEFT JOIN ma_giam_gia mg ON dh.ma_giam_gia_id = mg.id
                LEFT JOIN chi_tiet_don_hang ctdh ON dh.id = ctdh.don_hang_id
                LEFT JOIN san_pham sp ON ctdh.san_pham_id = sp.id
                WHERE dh.id = :id
                ORDER BY ctdh.id";  

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($don_hang_id) {
        $sql = "SELECT 
                    ct.*,
                    sp.ten_san_pham,
                    sp.hinh_anh
                FROM chi_tiet_don_hang ct
                JOIN san_pham sp ON ct.san_pham_id = sp.id
                WHERE ct.don_hang_id = :don_hang_id
                ORDER BY ct.id";    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':don_hang_id', $don_hang_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $trang_thai_thanh_toan) {
        $sql = "UPDATE don_hang 
                SET trang_thai_thanh_toan = :trang_thai 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':trang_thai', $trang_thai_thanh_toan);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createOrder($userId, $total, $status = 'Chưa thanh toán') {
        $sql = "INSERT INTO don_hang (tong_tien, trang_thai_thanh_toan, nguoi_dung_id, ngay_tao)
                VALUES (:tong_tien, :trang_thai, :nguoi_dung_id, NOW())";

        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([
            ':tong_tien' => $total,
            ':trang_thai' => $status,
            ':nguoi_dung_id' => $userId,
        ]);

        if ($success) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    // ĐÃ SỬA LẠI HÀM NÀY ĐỂ TRÁNH LỖI DÒNG 83
    public function createOrderItems($orderId, $cartItems) {
        $sql = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, bien_the_id, mau_sac_id, so_luong, gia)
                VALUES (:don_hang_id, :san_pham_id, :bien_the_id, :mau_sac_id, :so_luong, :gia)";

        $stmt = $this->conn->prepare($sql);
        foreach ($cartItems as $item) {
            // Kiểm tra và lấy product_id (chấp nhận cả 'product_id' hoặc 'id' hoặc 'san_pham_id')
            $productId = $item['product_id'] ?? $item['san_pham_id'] ?? $item['id'] ?? 0;
            $bienTheId = isset($item['bien_the_id']) && $item['bien_the_id'] > 0 ? $item['bien_the_id'] : null;
            $mauSacId = isset($item['mau_sac_id']) && $item['mau_sac_id'] > 0 ? $item['mau_sac_id'] : null;
            $gia = isset($item['gia']) ? $item['gia'] : 0;
            $soLuong = isset($item['so_luong']) ? $item['so_luong'] : (isset($item['quantity']) ? $item['quantity'] : 1);

            $success = $stmt->execute([
                ':don_hang_id' => $orderId,
                ':san_pham_id' => $productId,
                ':bien_the_id' => $bienTheId,
                ':mau_sac_id'  => $mauSacId,
                ':so_luong'    => $soLuong,
                ':gia'         => $gia,
            ]);

            if (!$success) {
                return false;
            }
        }

        return true;
    }

    public function delete($id) {
        $this->conn->beginTransaction();
        try {
            $detailSql = "DELETE FROM chi_tiet_don_hang WHERE don_hang_id = :id";
            $detailStmt = $this->conn->prepare($detailSql);
            $detailStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $detailStmt->execute();

            $sql = "DELETE FROM don_hang WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}
?>