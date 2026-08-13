<?php
session_start();
require_once 'config_vnpay.php';

$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
$inputData = array();

foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

unset($inputData['vnp_SecureHash']);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Kiểm tra tính hợp lệ của chữ ký
if ($secureHash === $vnp_SecureHash) {
    $order_id          = $_GET['vnp_TxnRef'];
    $vnp_ResponseCode  = $_GET['vnp_ResponseCode'];
    $vnp_TransactionNo = $_GET['vnp_TransactionNo']; // Mã giao dịch của VNPAY

    if ($vnp_ResponseCode == '00') {
        // Thanh toán thành công
        // TODO: Cập nhật trạng thái đơn hàng $order_id trong DB sang "Đã thanh toán"
        
        unset($_SESSION['cart']);
        $_SESSION['info'] = "Thanh toán VNPAY thành công cho đơn hàng #" . htmlspecialchars($order_id);
        header('Location: ' . BASE_URL_SITE . 'index_shop.php?ctrl=cart&act=success');
        exit();
    } else {
        // Thanh toán không thành công hoặc bị hủy
        $_SESSION['info'] = "Thanh toán VNPAY thất bại hoặc đã bị hủy (Mã lỗi: " . htmlspecialchars($vnp_ResponseCode) . ")";
        header('Location: ' . BASE_URL_SITE . 'index_shop.php?ctrl=home&act=checkout');
        exit();
    }
} else {
    $_SESSION['info'] = "Lỗi xác thực chữ ký bảo mật từ VNPAY!";
    header('Location: ' . BASE_URL_SITE . 'index_shop.php?ctrl=home&act=checkout');
    exit();
}