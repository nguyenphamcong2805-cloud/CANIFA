<?php
require_once __DIR__ . '/Database.php';

class Coupon
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    /**
     * Kiểm tra mã giảm giá có hợp lệ không (Bổ sung kiểm tra hạn mức đơn & số lượt dùng)
     */
    public function validateCode($ma, $subtotal = 0)
    {
        $sql = "SELECT * FROM ma_giam_gia
                WHERE ma = :ma
                  AND trang_thai = 'hoat_dong'
                  AND ngay_bat_dau <= CURDATE()
                  AND ngay_ket_thuc >= CURDATE()
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':ma', $ma);
        $stmt->execute();
        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$coupon) {
            return false; // Mã không tồn tại hoặc đã hết hạn
        }

        // Kiểm tra xem đơn hàng đã đạt giá trị tối thiểu chưa
        $minOrder = (float)($coupon['don_hang_toi_thieu'] ?? 0);
        if ($subtotal > 0 && $subtotal < $minOrder) {
            return false; 
        }

        // Kiểm tra lượt sử dụng (nếu bảng của bạn có cột so_luong và da_dung)
        if (isset($coupon['so_luong']) && isset($coupon['da_dung'])) {
            if ($coupon['da_dung'] >= $coupon['so_luong']) {
                return false; // Đã hết lượt dùng
            }
        }

        return $coupon;
    }

    /**
     * Tính số tiền được giảm
     */
    public function calculateDiscount($coupon, $subtotal)
    {
        if (!$coupon) return 0;

        // Bỏ qua nếu đơn chưa đủ giá trị tối thiểu
        $minOrder = (float)($coupon['don_hang_toi_thieu'] ?? 0);
        if ($subtotal < $minOrder) {
            return 0;
        }
        
        $discount_percent = (float)($coupon['phan_tram_giam'] ?? 0);
        $discount_amount = 0;

        if ($discount_percent > 0) {
            $discount_amount = (int)($subtotal * $discount_percent / 100);
            
            // Nếu bảng có giới hạn giảm tối đa (giam_toi_da)
            if (isset($coupon['giam_toi_da']) && $coupon['giam_toi_da'] > 0) {
                if ($discount_amount > $coupon['giam_toi_da']) {
                    $discount_amount = (int)$coupon['giam_toi_da'];
                }
            }
        }
        
        return $discount_amount;
    }

    // Tăng số lần dùng khi đặt hàng thành công
    public function incrementUsage($ma)
    {
        $sql = "UPDATE ma_giam_gia SET da_dung = da_dung + 1 WHERE ma = :ma";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':ma', $ma);
        return $stmt->execute();
    }

    // Lấy tất cả mã (Cho trang Admin)
    public function getAll()
    {
        $sql = "SELECT * FROM ma_giam_gia ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm mã mới (Admin)
    public function add($data)
    {
        $sql = "INSERT INTO ma_giam_gia (ma, phan_tram_giam, don_hang_toi_thieu, ngay_bat_dau, ngay_ket_thuc, trang_thai)
                VALUES (:ma, :phan_tram_giam, :don_hang_toi_thieu, :ngay_bat_dau, :ngay_ket_thuc, :trang_thai)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':ma',                 $data['ma']);
        $stmt->bindValue(':phan_tram_giam',       $data['phan_tram_giam'] ?? 0);
        $stmt->bindValue(':don_hang_toi_thieu',   $data['don_hang_toi_thieu'] ?? 0);
        $stmt->bindValue(':ngay_bat_dau',         $data['ngay_bat_dau'] ?? date('Y-m-d'));
        $stmt->bindValue(':ngay_ket_thuc',        $data['ngay_ket_thuc'] ?? date('Y-m-d', strtotime('+1 year')));
        $stmt->bindValue(':trang_thai',           $data['trang_thai'] ?? 'hoat_dong');
        return $stmt->execute();
    }

    // Xóa mã
    public function delete($id)
    {
        $sql = "DELETE FROM ma_giam_gia WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}