<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/User.php';

class UserController {

    /* =========================================================
     * 1. ĐĂNG KÝ & ĐĂNG NHẬP & ĐĂNG XUẤT
     * ========================================================= */

    public function postRegister() {
        $email      = trim($_POST['email'] ?? '');
        $name       = trim($_POST['name'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $password   = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        if ($password !== $repassword) {
            $_SESSION['info'] = "Mật khẩu không khớp";
            header("Location: index_shop.php?ctrl=home&act=register");
            exit;
        }

        $userModel = new User();

        if ($userModel->checkEmail($email)) {
            $_SESSION['info'] = "Email đã tồn tại";
            header("Location: index_shop.php?ctrl=home&act=register");
            exit;
        }

        if ($userModel->register($name, $email, $password, $phone, 'khach_hang')) {
            $_SESSION['info'] = "Đăng ký thành công. Vui lòng đăng nhập.";
            header('Location: index_shop.php?ctrl=home&act=login');
            exit;
        } else {
            $_SESSION['info'] = "Đăng ký thất bại, vui lòng thử lại.";
            header("Location: index_shop.php?ctrl=home&act=register");
            exit;
        }
    }

    public function submitLogin() {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['info'] = "Vui lòng nhập đầy đủ email và mật khẩu.";
            header("Location: index_shop.php?ctrl=home&act=login");
            exit;
        }

        $userModel = new User();
        $user      = $userModel->login($email, $password);

        if ($user) {
            $_SESSION['user']         = $user;
            $_SESSION['user']['role'] = $user['vai_tro'] ?? $user['role'] ?? 'user';
            $_SESSION['login']        = true;
            $_SESSION['name']         = $user['ho_ten'] ?? $user['name'] ?? '';

            if ($_SESSION['user']['role'] === 'admin') {
                $_SESSION['info'] = "Chào Admin " . ($_SESSION['name'] ?: '');
                header("Location: index_admin.php?page=home");
                exit;
            } else {
                $_SESSION['info'] = "Đăng nhập thành công, chào " . ($_SESSION['name'] ?: '');
                header("Location: index_shop.php?ctrl=home&act=index");
                exit;
            }
        } else {
            $_SESSION['info'] = "Đăng nhập thất bại, vui lòng kiểm tra lại email hoặc mật khẩu.";
            header("Location: index_shop.php?ctrl=home&act=login");
            exit;
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['name']);
        $_SESSION['login'] = false;
        header("Location: ./index_shop.php?ctrl=home&act=index");
        exit;
    }

    /* =========================================================
     * 2. CẬP NHẬT THÔNG TIN CÁ NHÂN (PROFILE)
     * ========================================================= */

    public function postUpdateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id      = $_POST['id'] ?? ($_SESSION['user']['id'] ?? 0);
            $name    = trim($_POST['ho_ten'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $phone   = trim($_POST['so_dien_thoai'] ?? '');
            $address = trim($_POST['dia_chi'] ?? '');
            
            // Bảo mật: Người dùng thường không được phép tự sửa vai trò (Role)
            $role = ($_SESSION['user']['role'] === 'admin') 
                ? ($_POST['vai_tro'] ?? $_SESSION['user']['vai_tro'] ?? 'khach_hang')
                : ($_SESSION['user']['vai_tro'] ?? 'khach_hang');

            if (empty($id) || empty($name) || empty($email)) {
                $_SESSION['info'] = "Vui lòng nhập đầy đủ họ tên và email.";
                header("Location: index_shop.php?ctrl=home&act=profile");
                exit;
            }

            $userModel = new User();
            if ($userModel->updateUser($id, $name, $email, $address, $phone, $role)) {
                // Cập nhật lại Session mới ngay lập tức
                $_SESSION['user']['ho_ten']        = $name;
                $_SESSION['user']['email']         = $email;
                $_SESSION['user']['so_dien_thoai'] = $phone;
                $_SESSION['user']['dia_chi']       = $address;
                $_SESSION['name']                  = $name;

                $_SESSION['info'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['info'] = "Cập nhật thất bại, vui lòng thử lại!";
            }

            header("Location: index_shop.php?ctrl=home&act=profile");
            exit;
        }
    }

    /* =========================================================
     * 3. XỬ LÝ THANH TOÁN (CHECKOUT & VNPAY)
     * ========================================================= */

    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart  = $_SESSION['cart'] ?? [];
            $total = 0;

            foreach ($cart as $item) {
                $total += ($item['gia'] ?? 0) * ($item['so_luong'] ?? 1);
            }

            if (empty($cart)) {
                $_SESSION['info'] = "Giỏ hàng của bạn đang trống!";
                header('Location: index_shop.php?ctrl=cart&act=index');
                exit();
            }

            $ho_ten          = trim($_POST['ho_ten'] ?? '');
            $so_dien_thoai   = trim($_POST['so_dien_thoai'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $dia_chi         = trim($_POST['dia_chi'] ?? '');
            $ghi_chu         = trim($_POST['ghi_chu'] ?? '');
            $shipping_method = $_POST['shipping_method'] ?? 'Giao hàng tiêu chuẩn';
            $payment_method  = $_POST['payment_method'] ?? 'COD';

            $shipping_fee = ($shipping_method === 'Giao hàng hoả tốc') ? 30000 : 0;
            $grand_total  = $total + $shipping_fee;

            // Mã đơn hàng duy nhất
            $order_id = time(); 

            // TODO: Gọi hàm lưu đơn hàng vào Database nếu có
            // $orderModel = new Order();
            // $orderModel->createOrder($order_id, $ho_ten, $so_dien_thoai, $email, $dia_chi, $ghi_chu, $payment_method, $grand_total, $cart);

            if ($payment_method === 'VNPAY') {
                $vnpayUrl = $this->createVnpayUrl($order_id, $grand_total);
                header('Location: ' . $vnpayUrl);
                exit();
            }

            // Thanh toán COD hoặc Chuyển khoản thường
            unset($_SESSION['cart']);
            $_SESSION['info'] = "Đặt hàng thành công! Mã đơn hàng của bạn là #" . $order_id;
            header('Location: index_shop.php?ctrl=cart&act=success');
            exit();
        }
    }

    private function createVnpayUrl($order_id, $grand_total) {
    // 1. Thay bộ mã Test Sandbox chuẩn trực tiếp ở đây:
    $vnp_TmnCode    = "2QXA523E"; // Mã TMN test của VNPAY Sandbox
    $vnp_HashSecret = "QXA523EVNPAYSECRETKEY1234567890"; // Hash secret tương ứng
    $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl  = BASE_URL_SITE . "vnpay_return.php";

    // Nếu có file config_vnpay.php thì nạp đè lên
    $configFile = __DIR__ . '/../../config_vnpay.php';
    if (file_exists($configFile)) {
        require $configFile;
    }

    $vnp_TxnRef    = $order_id;
    $vnp_OrderInfo = 'Thanh toan don hang #' . $order_id;
    $vnp_OrderType = 'billpayment';
    $vnp_Amount    = $grand_total * 100;
    $vnp_Locale    = 'vn';
    $vnp_IpAddr    = $_SERVER['REMOTE_ADDR'];

    $inputData = array(
        "vnp_Version"    => "2.1.0",
        "vnp_TmnCode"    => $vnp_TmnCode,
        "vnp_Amount"     => $vnp_Amount,
        "vnp_Command"    => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode"   => "VND",
        "vnp_IpAddr"     => $vnp_IpAddr,
        "vnp_Locale"     => $vnp_Locale,
        "vnp_OrderInfo"  => $vnp_OrderInfo,
        "vnp_OrderType"  => $vnp_OrderType,
        "vnp_ReturnUrl"  => $vnp_Returnurl,
        "vnp_TxnRef"     => $vnp_TxnRef
    );

    ksort($inputData);
    $query    = "";
    $i        = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    return $vnp_Url;
}
    /* =========================================================
     * 4. TÍNH NĂNG QUÊN MẬT KHẨU (FORGOT PASSWORD)
     * ========================================================= */

    public function forgotPassword() {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['info'] = "Vui lòng nhập email của bạn.";
            header("Location: index_shop.php?ctrl=home&act=forgot");
            exit;
        }

        $userModel = new User();
        if (!$userModel->checkEmail($email)) {
            $_SESSION['info'] = "Email này chưa được đăng ký trong hệ thống.";
            header("Location: index_shop.php?ctrl=home&act=forgot");
            exit;
        }

        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp']   = $otp;
        $_SESSION['otp_time']    = time();

        $_SESSION['info'] = "Mã xác thực (OTP) của bạn là: $otp (Lưu ý: Tính năng gửi mail tự động chưa bật)";

        header("Location: index_shop.php?ctrl=home&act=verify_otp");
        exit;
    }

    public function resetPassword() {
        $otp         = trim($_POST['otp'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $rePassword  = $_POST['re_password'] ?? '';

        if (empty($otp) || empty($newPassword) || empty($rePassword)) {
            $_SESSION['info'] = "Vui lòng nhập đầy đủ thông tin.";
            header("Location: index_shop.php?ctrl=home&act=verify_otp");
            exit;
        }

        if ($otp != ($_SESSION['reset_otp'] ?? '')) {
            $_SESSION['info'] = "Mã OTP không chính xác!";
            header("Location: index_shop.php?ctrl=home&act=verify_otp");
            exit;
        }

        // OTP hết hạn sau 5 phút (300s)
        if (time() - ($_SESSION['otp_time'] ?? 0) > 300) {
            $_SESSION['info'] = "Mã OTP đã hết hạn, vui lòng gửi lại yêu cầu!";
            header("Location: index_shop.php?ctrl=home&act=forgot");
            exit;
        }

        if ($newPassword !== $rePassword) {
            $_SESSION['info'] = "Mật khẩu nhập lại không khớp!";
            header("Location: index_shop.php?ctrl=home&act=verify_otp");
            exit;
        }

        $email     = $_SESSION['reset_email'];
        $userModel = new User();

        if (method_exists($userModel, 'updatePassword') && $userModel->updatePassword($email, $newPassword)) {
            unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_time']);
            $_SESSION['info'] = "Đặt lại mật khẩu thành công! Vui lòng đăng nhập.";
            header("Location: index_shop.php?ctrl=home&act=login");
            exit;
        } else {
            $_SESSION['info'] = "Đổi mật khẩu thất bại. Vui lòng thử lại!";
            header("Location: index_shop.php?ctrl=home&act=verify_otp");
            exit;
        }
    }
}