<?php
// 1. Bật hiển thị lỗi PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Định nghĩa hằng số đường dẫn
define('BASE_URL_SITE', 'http://localhost/CANIFA/'); 
define('BASE_URL', 'http://localhost/CANIFA/public/Shop/');

// 3. Lấy tham số ctrl và act từ URL
$ctrl = $_GET['ctrl'] ?? 'home';
$act  = $_GET['act'] ?? 'index';

// Các Action chắc chắn thuộc về UserController (Submit Form/Xử lý dữ liệu)
$userPostActions = [
    'submitLogin', 'postRegister', 'logout', 
    'postUpdateProfile', 'forgotPassword', 'resetPassword'
];

// 4. Định tuyến Controller
switch ($ctrl) {

    case 'home':
        // Nếu là Submit Checkout (POST) -> Đẩy vào UserController để tạo URL VNPAY
        if ($act === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once "./app/Controller/UserController.php";
            $controller = new UserController();
        } 
        // Các xử lý dữ liệu User khác
        elseif (in_array($act, $userPostActions)) {
            require_once "./app/Controller/UserController.php";
            $controller = new UserController();
        } 
        // Hiển thị giao diện (bao gồm cả Hiển thị trang Checkout khi dùng GET request)
        else {
            require_once "./app/Controller/HomeController.php";
            $controller = new HomeController();
        }
        break;

    case 'product':
    case 'Products':
        require_once "./app/Controller/ProductsController.php";
        $controller = new ProductsController();
        break;

    case 'cart':
        require_once "./app/Controller/CartController.php";
        $controller = new CartController();
        break;

    case 'user':
        require_once "./app/Controller/UserController.php";
        $controller = new UserController();
        break;

    default:
        die("Controller không tồn tại.");
}

// 5. Kiểm tra tính tồn tại của phương thức
if (!method_exists($controller, $act)) {
    die("Action '$act' không tồn tại trong controller " . get_class($controller) . ".");
}

// 6. Thực thi Action
$controller->$act();