<?php

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/Products.php';
require_once __DIR__ . '/../Model/Review.php';

class ProductsController
{
    private $db;
    private $productModel;
    private $reviewModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

        // Kiểm tra đúng tên class trong Model của bạn (Products hoặc Product)
        if (class_exists('Products')) {
            $this->productModel = new Products($this->db);
        } else {
            $this->productModel = new Product($this->db);
        }
        $this->reviewModel = new Review($this->db);
    }

    /**
     * Danh sách tất cả sản phẩm
     */
    public function index()
    {
        $products = $this->productModel->getAllProducts();

        // Sửa thành products.php (có chữ s)
        require_once __DIR__ . '/../View/View_shop/products.php';
    }

    /**
     * Chi tiết sản phẩm
     */
    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            die("ID sản phẩm không hợp lệ.");
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            die("Không tìm thấy sản phẩm.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!session_id()) {
                session_start();
            }
            $authorName = trim($_POST['author_name'] ?? ($_SESSION['name'] ?? 'Khách'));
            $rating = intval($_POST['rating'] ?? 0);
            $comment = trim($_POST['comment'] ?? '');
            $userId = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : null;

            if ($rating >= 1 && $rating <= 5 && $comment !== '') {
                $this->reviewModel->addReview($id, $authorName ?: 'Khách', $rating, $comment, $userId);
                $_SESSION['review_message'] = 'Cảm ơn bạn đã gửi đánh giá!';
                header('Location: index_shop.php?ctrl=product&act=detail&id=' . $id);
                exit();
            } else {
                $_SESSION['review_message'] = 'Vui lòng chọn đánh giá sao và nhập bình luận.';
                header('Location: index_shop.php?ctrl=product&act=detail&id=' . $id);
                exit();
            }
        }

        $variants = method_exists($this->productModel, 'getVariants') 
            ? $this->productModel->getVariants($id) 
            : [];
        $reviews = $this->reviewModel->getReviewsByProductId($id);
        $averageRating = $this->reviewModel->getAverageRating($id);
        $reviewCount = $this->reviewModel->getReviewCount($id);

        require_once __DIR__ . '/../View/View_shop/productdetail.php';
    }

    /**
     * Lọc theo danh mục
     * URL: ?ctrl=product&act=category&id=1
     */
    public function category()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            $products = $this->productModel->getAllProducts();
        } else {
            $products = $this->productModel->getProductsByCategory($id);
        }

        // Sửa thành products.php (có chữ s)
        require_once __DIR__ . '/../View/View_shop/products.php';
    }

    /**
     * Tìm kiếm sản phẩm
     * URL: ?ctrl=product&act=search&keyword=ao
     */
    public function search()
    {
        $keyword = trim($_GET['keyword'] ?? '');

        if (empty($keyword)) {
            $products = $this->productModel->getAllProducts();
        } else {
            $products = $this->productModel->searchProducts($keyword);
        }

        // Sửa thành products.php (có chữ s)
        require_once __DIR__ . '/../View/View_shop/products.php';
    }

    /**
     * Trang riêng cho Quần
     */
    public function pants()
    {
        $products = $this->productModel->getProductsByCategory(2);
        require_once __DIR__ . '/../View/View_shop/products.php';
    }
}