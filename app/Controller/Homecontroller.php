<?php

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/Products.php';
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Model/Review.php';

class HomeController
{
    private $db;
    private $productsModel;
    private $orderModel;
    private $reviewModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();

        // Đảm bảo tên Class khớp với file Model/Products.php
        $this->productsModel = new Product($this->db);
        $this->orderModel = new Order();
        $this->reviewModel = new Review($this->db);
    }

    // Trang chủ
    public function index()
    {
        $bestsellerShirts = $this->productsModel->getBestsellerShirts(4);
        $shirts           = $this->productsModel->getShirts(4);
        $pants            = $this->productsModel->getPants(4);

        require_once __DIR__ . '/../View/View_shop/home.php';
    }

    // Chi tiết sản phẩm
    public function productDetail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            header("Location: index.php");
            exit();
        }

        $product = $this->productsModel->getProductById($id);
        if (!$product) {
            header("Location: index.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authorName = trim($_POST['author_name'] ?? ($_SESSION['name'] ?? 'Khách'));
            $rating = intval($_POST['rating'] ?? 0);
            $comment = trim($_POST['comment'] ?? '');
            $userId = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : null;

            if ($rating >= 1 && $rating <= 5 && $comment !== '') {
                $this->reviewModel->addReview($id, $authorName ?: 'Khách', $rating, $comment, $userId);
                $_SESSION['review_message'] = 'Cảm ơn bạn đã gửi đánh giá!';
                header('Location: index_shop.php?ctrl=home&act=productDetail&id=' . $id);
                exit();
            } else {
                $_SESSION['review_message'] = 'Vui lòng chọn đánh giá sao và nhập bình luận.';
                header('Location: index_shop.php?ctrl=home&act=productDetail&id=' . $id);
                exit();
            }
        }

        $variants = $this->productsModel->getVariants($id);
        $reviews = $this->reviewModel->getReviewsByProductId($id);
        $averageRating = $this->reviewModel->getAverageRating($id);
        $reviewCount = $this->reviewModel->getReviewCount($id);

        require_once __DIR__ . '/../View/View_shop/productdetail.php';
    }

    // Đăng nhập
    public function login()
    {
        require_once __DIR__ . '/../View/View_shop/login.php';
    }

    // Đăng ký
    public function register()
    {
        require_once __DIR__ . '/../View/View_shop/register.php';
    }

    // Trang quản trị
    public function admin()
    {
        // Kiểm tra quyền truy cập Admin trước khi require view
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit();
        }

        require_once __DIR__ . '/../View/View_admin/home.php';
    }

    public function checkout()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user']['id'])) {
            $_SESSION['info'] = "Bạn cần đăng nhập để đặt hàng.";
            header("Location: index_shop.php?ctrl=home&act=login");
            exit();
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['info'] = "Giỏ hàng trống.";
            header("Location: index_shop.php?ctrl=cart&act=index");
            exit();
        }

        $userId = (int)$_SESSION['user']['id'];
        $total = 0;
        foreach ($cart as $item) {
            $total += (float)($item['gia'] ?? 0) * (int)($item['so_luong'] ?? 0);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['payment_method'] ?? 'COD';
            $shippingMethod = $_POST['shipping_method'] ?? 'Giao hàng tiêu chuẩn';
            $status = 'Đang xử lý';

            $orderId = $this->orderModel->createOrder($userId, $total, $status);
            if ($orderId && $this->orderModel->createOrderItems($orderId, $cart)) {
                unset($_SESSION['cart']);
                $_SESSION['last_order_id'] = $orderId;
                header("Location: index_shop.php?ctrl=home&act=orderSuccess&id={$orderId}");
                exit();
            }

            $_SESSION['info'] = "Đặt hàng thất bại. Vui lòng thử lại.";
            header("Location: index_shop.php?ctrl=cart&act=index");
            exit();
        }

        $shippingOptions = [
            'Giao hàng tiêu chuẩn',
            'Giao hàng nhanh',
        ];
        $paymentOptions = [
            'COD',
            'Chuyển khoản ngân hàng',
            'Thanh toán online',
        ];

        require_once __DIR__ . '/../View/View_shop/checkout.php';
    }

    public function orderSuccess()
    {
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $orderId = $orderId > 0 ? $orderId : ($_SESSION['last_order_id'] ?? 0);

        if ($orderId <= 0) {
            header("Location: index_shop.php?ctrl=home&act=index");
            exit();
        }

        $orderInfo = [
            'id' => $orderId,
            'message' => 'Đặt hàng thành công',
        ];

        require_once __DIR__ . '/../View/View_shop/order_success.php';
    }

    public function orderDetail()
    {
        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($orderId <= 0) {
            header("Location: index_shop.php?ctrl=home&act=index");
            exit();
        }

        $orderRows = $this->orderModel->getById($orderId);
        if (empty($orderRows)) {
            header("Location: index_shop.php?ctrl=home&act=index");
            exit();
        }

        $orderInfo = $orderRows[0];
        $items = $this->orderModel->getOrderItems($orderId);

        require_once __DIR__ . '/../View/View_shop/order_detail.php';
    }
}