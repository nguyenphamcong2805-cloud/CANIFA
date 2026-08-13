<?php

class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // ==========================
    // LẤY TOÀN BỘ SẢN PHẨM
    // ==========================
   public function getAllProducts()
{
    $sql = "SELECT
                sp.id,
                sp.ten_san_pham,
                sp.hinh_anh,
                sp.trang_thai,
                sp.mo_ta,
                dm.ten_danh_muc,
                MIN(bt.gia) AS gia
            FROM san_pham sp
            LEFT JOIN danh_muc dm ON dm.id = sp.danh_muc_id
            LEFT JOIN bien_the_san_pham bt ON bt.san_pham_id = sp.id
            GROUP BY sp.id
            ORDER BY sp.id DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getProductCountByCategory()
    {
        $sql = "SELECT dm.ten_danh_muc AS category, COUNT(sp.id) AS count
                FROM san_pham sp
                LEFT JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                GROUP BY dm.id, dm.ten_danh_muc
                ORDER BY count DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopSellingProducts($limit = 6)
    {
        $sql = "SELECT sp.ten_san_pham, IFNULL(SUM(ct.so_luong), 0) AS sold
                FROM san_pham sp
                LEFT JOIN chi_tiet_don_hang ct ON ct.san_pham_id = sp.id
                GROUP BY sp.id
                ORDER BY sold DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // LẤY SẢN PHẨM THEO ID
    // ==========================
    public function getProductById($id)
    {
        $sql = "SELECT 
                    sp.*, 
                    dm.ten_danh_muc, 
                    MIN(bt.gia) AS gia 
                FROM san_pham sp
                LEFT JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                LEFT JOIN bien_the_san_pham bt ON bt.san_pham_id = sp.id
                WHERE sp.id = :id
                GROUP BY sp.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================
    // BIẾN THỂ
    // ==========================
    public function getVariants($id)
    {
        $sql = "SELECT *
                FROM bien_the_san_pham
                WHERE san_pham_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // BÁN CHẠY
    // ==========================
    public function getBestsellerShirts($limit = 4)
    {
        $sql = "SELECT *
                FROM san_pham
                ORDER BY da_ban DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // ÁO
    // ==========================
    public function getShirts($limit = 4)
    {
        $sql = "SELECT *
                FROM san_pham
                WHERE danh_muc_id = 1
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // QUẦN
    // ==========================
    public function getPants($limit = 4)
    {
        $sql = "SELECT *
                FROM san_pham
                WHERE danh_muc_id = 2
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // DANH MỤC
    // ==========================
    public function getAllCategories()
    {
        $sql = "SELECT *
                FROM danh_muc
                ORDER BY ten_danh_muc ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // LẤY 1 DANH MỤC
    // ==========================
    public function getCategoryById($id)
    {
        $sql = "SELECT *
                FROM danh_muc
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================
    // LỌC DANH MỤC
    // ==========================
    public function getProductsByCategory($id)
    {
        $sql = "SELECT
                    sp.*,
                    dm.ten_danh_muc,
                    MIN(bt.gia) AS gia
                FROM san_pham sp
                LEFT JOIN danh_muc dm ON dm.id = sp.danh_muc_id
                LEFT JOIN bien_the_san_pham bt ON bt.san_pham_id = sp.id
                WHERE sp.danh_muc_id = :id
                GROUP BY sp.id
                ORDER BY sp.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // TÌM KIẾM
    // ==========================
    public function searchProducts($keyword)
    {
        $sql = "SELECT
                    sp.*,
                    MIN(bt.gia) AS gia
                FROM san_pham sp
                LEFT JOIN bien_the_san_pham bt ON bt.san_pham_id = sp.id
                WHERE sp.ten_san_pham LIKE :keyword
                GROUP BY sp.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":keyword", "%" . $keyword . "%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($data)
    {
        $sql = "INSERT INTO san_pham (ten_san_pham, mo_ta, hinh_anh, danh_muc_id, trang_thai, da_ban)
                VALUES (:ten_san_pham, :mo_ta, :hinh_anh, :danh_muc_id, 'active', 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ten_san_pham' => $data['ten_san_pham'],
            ':mo_ta' => $data['mo_ta'],
            ':hinh_anh' => $data['hinh_anh'],
            ':danh_muc_id' => $data['danh_muc_id'] ?? 1,
        ]);

        $productId = $this->conn->lastInsertId();
        if (!empty($data['gia'])) {
            $variantSql = "INSERT INTO bien_the_san_pham (kich_co, gia, so_luong_ton, san_pham_id)
                           VALUES ('default', :gia, 0, :san_pham_id)";
            $variantStmt = $this->conn->prepare($variantSql);
            $variantStmt->execute([
                ':gia' => $data['gia'],
                ':san_pham_id' => $productId,
            ]);
        }

        return $productId;
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE san_pham SET ten_san_pham = :ten_san_pham, mo_ta = :mo_ta, hinh_anh = :hinh_anh, danh_muc_id = :danh_muc_id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ten_san_pham' => $data['ten_san_pham'],
            ':mo_ta' => $data['mo_ta'],
            ':hinh_anh' => $data['hinh_anh'],
            ':danh_muc_id' => $data['danh_muc_id'] ?? 1,
            ':id' => $id,
        ]);

        if (isset($data['gia'])) {
            $variantSql = "UPDATE bien_the_san_pham SET gia = :gia WHERE san_pham_id = :san_pham_id";
            $variantStmt = $this->conn->prepare($variantSql);
            $variantStmt->execute([
                ':gia' => $data['gia'],
                ':san_pham_id' => $id,
            ]);
        }

        return $stmt->rowCount();
    }

    public function deleteProduct($id)
    {
        $variantSql = "DELETE FROM bien_the_san_pham WHERE san_pham_id = :id";
        $variantStmt = $this->conn->prepare($variantSql);
        $variantStmt->execute([':id' => $id]);

        $sql = "DELETE FROM san_pham WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount();
    }
}
