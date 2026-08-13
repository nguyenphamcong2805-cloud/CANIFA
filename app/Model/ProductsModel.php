<?php

require_once __DIR__ . '/Database.php';

class ProductsModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $sql = "SELECT sp.*,
                       dm.ten_danh_muc,
                       MIN(bt.gia) AS gia_min
                FROM san_pham sp
                LEFT JOIN danh_muc dm
                    ON sp.danh_muc_id = dm.id
                LEFT JOIN bien_the_san_pham bt
                    ON bt.san_pham_id = sp.id
                GROUP BY sp.id
                ORDER BY sp.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT * FROM san_pham WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy biến thể
    public function getVariants($productId)
    {
        $sql = "SELECT * FROM bien_the_san_pham
                WHERE san_pham_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Danh sách áo
    public function getShirts($limit = 12)
    {
        $sql = "SELECT * FROM san_pham
                WHERE danh_muc_id = 1
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Danh sách quần
    public function getPants($limit = 12)
    {
        $sql = "SELECT * FROM san_pham
                WHERE danh_muc_id = 2
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Bán chạy
    public function getBestSeller($limit = 4)
    {
        $sql = "SELECT *
                FROM san_pham
                ORDER BY da_ban DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm
    public function search($keyword)
    {
        $sql = "SELECT *
                FROM san_pham
                WHERE ten_san_pham LIKE :keyword";

        $stmt = $this->conn->prepare($sql);

        $search = "%" . $keyword . "%";

        $stmt->bindValue(':keyword', $search);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lọc theo danh mục
    public function getByCategory($categoryId)
    {
        $sql = "SELECT *
                FROM san_pham
                WHERE danh_muc_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}