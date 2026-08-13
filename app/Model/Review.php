<?php

class Review
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists()
    {
        $sql = "CREATE TABLE IF NOT EXISTS product_reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            user_id INT NULL,
            author_name VARCHAR(255) NOT NULL,
            rating TINYINT NOT NULL,
            comment TEXT NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_product_id (product_id),
            FOREIGN KEY (product_id) REFERENCES san_pham(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->conn->exec($sql);
    }

    /*
    CREATE TABLE IF NOT EXISTS product_reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        user_id INT NULL,
        author_name VARCHAR(255) NOT NULL,
        rating TINYINT NOT NULL,
        comment TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES san_pham(id) ON DELETE CASCADE
    );
    */

    public function getReviewsByProductId($productId)
    {
        $sql = "SELECT * FROM product_reviews WHERE product_id = :product_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating($productId)
    {
        $sql = "SELECT AVG(rating) AS avg_rating FROM product_reviews WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avg_rating'] ? round($result['avg_rating'], 1) : 0;
    }

    public function getReviewCount($productId)
    {
        $sql = "SELECT COUNT(*) AS total FROM product_reviews WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($result['total'] ?? 0);
    }

    public function addReview($productId, $authorName, $rating, $comment, $userId = null)
    {
        $sql = "INSERT INTO product_reviews (product_id, user_id, author_name, rating, comment, created_at)
                VALUES (:product_id, :user_id, :author_name, :rating, :comment, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':product_id' => $productId,
            ':user_id' => $userId,
            ':author_name' => $authorName,
            ':rating' => $rating,
            ':comment' => $comment,
        ]);
    }
}
