<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/Products.php';
require_once __DIR__ . '/../Model/Coupon.php';

class CartController
{
    private $db;
    private $productsModel;
    private $couponModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productsModel = new Product($this->db);
        $this->couponModel = new Coupon();
    }

    // Hiển thị giao diện Giỏ hàng
    public function index()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        require_once __DIR__ . '/../View/View_shop/cart.php';
    }

    // Thêm sản phẩm vào giỏ hàng (Tự động truy vấn Database để lấy thông tin sản phẩm chuẩn)
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id       = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            $size     = isset($_POST['size']) ? trim($_POST['size']) : 'M';

            if ($id > 0 && $quantity > 0) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $product = $this->productsModel->getProductById($id);
                if ($product) {
                    $key   = $id . ':' . $size;
                    $price = (float)($product['gia'] ?? 0);
                    $image = $product['hinh_anh'] ?? '';

                    if (isset($_SESSION['cart'][$key])) {
                        $_SESSION['cart'][$key]['so_luong'] += $quantity;
                    } else {
                        $_SESSION['cart'][$key] = [
                            'product_id' => $id,
                            'ten'        => $product['ten_san_pham'] ?? $product['ten'] ?? 'Sản phẩm',
                            'gia'        => $price,
                            'hinh_anh'   => $image,
                            'size'       => $size,
                            'so_luong'   => $quantity,
                        ];
                    }
                }
            }
        }

        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        if (!empty($_POST['redirect']) && $_POST['redirect'] === 'checkout') {
            $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=home&act=checkout';
        }

        header('Location: ' . $redirect);
        exit();
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key      = $_POST['key'] ?? '';
            $quantity = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 0;

            if ($key !== '' && isset($_SESSION['cart'][$key])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$key]['so_luong'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$key]);
                }
            }
        }

        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        header('Location: ' . $redirect);
        exit();
    }

    // Xóa một sản phẩm khỏi giỏ hàng
    public function remove()
    {
        $key = $_GET['key'] ?? '';
        if ($key === '' && isset($_GET['id'])) {
            $key = $_GET['id'];
        }

        if ($key !== '' && isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }

        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        header('Location: ' . $redirect);
        exit();
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        
        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        header('Location: ' . $redirect);
        exit();
    }

    // Áp dụng mã giảm giá
    public function applyCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = strtoupper(trim($_POST['coupon_code'] ?? ''));

            if (empty($code)) {
                $_SESSION['coupon_msg'] = ['type' => 'error', 'text' => 'Vui lòng nhập mã giảm giá.'];
            } else {
                // Tính tổng tiền giỏ hàng hiện tại để kiểm tra điều kiện
                $subtotal = 0;
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $subtotal += ($item['gia'] ?? 0) * ($item['so_luong'] ?? 1);
                    }
                }

                $coupon = $this->couponModel->validateCode($code, $subtotal);

                if (!$coupon) {
                    $_SESSION['coupon_msg'] = ['type' => 'error', 'text' => 'Mã giảm giá không hợp lệ, đã hết hạn hoặc chưa đủ hạn mức tối thiểu.'];
                } else {
                    $_SESSION['coupon'] = $coupon;
                    $_SESSION['coupon_msg'] = ['type' => 'success', 'text' => 'Áp dụng mã giảm giá thành công!'];
                }
            }
        }

        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        header('Location: ' . $redirect);
        exit();
    }

    // Xóa mã giảm giá đang chọn
    public function removeCoupon()
    {
        unset($_SESSION['coupon']);
        unset($_SESSION['coupon_msg']);

        $redirect = BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=index';
        header('Location: ' . $redirect);
        exit();
    }

    // Hiển thị màn hình báo đặt hàng/thanh toán VNPAY thành công
    public function success()
    {
        $viewPath = __DIR__ . '/../View/View_shop/success.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            $infoMsg = $_SESSION['info'] ?? 'Cảm ơn bạn đã mua sắm tại CANIFA. Đơn hàng của bạn đã được tiếp nhận thành công!';
            unset($_SESSION['info']);

           
        }
    }
}