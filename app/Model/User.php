<?php
require_once __DIR__ . '/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Kiểm tra email đã tồn tại hay chưa
    public function checkEmail($email) {
        $sql = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký tài khoản mới
    public function register($name, $email, $password, $phone = null, $role = 'user') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, vai_tro) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$name, $email, $passwordHash, $phone, $role]);
    }

    // Đăng nhập hệ thống
    public function login($email, $password) {
        $sql = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $storedPassword = $user['mat_khau'];
        $isValid = false;

        // Kiểm tra đa chuẩn mã hóa
        if (password_verify($password, $storedPassword)) {
            $isValid = true;
        } elseif ($storedPassword === $password) {
            $isValid = true;
        } elseif (ctype_xdigit($storedPassword) && strlen($storedPassword) === 64 && hash('sha256', $password) === $storedPassword) {
            $isValid = true;
        } elseif (md5($password) === $storedPassword) {
            $isValid = true;
        }

        // Tự động nâng cấp mật khẩu sang password_hash nếu là chuẩn cũ
        if ($isValid) {
            if (!password_needs_rehash($storedPassword, PASSWORD_DEFAULT) || $storedPassword === $password || md5($password) === $storedPassword || (ctype_xdigit($storedPassword) && strlen($storedPassword) === 64)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $update = $this->conn->prepare("UPDATE nguoi_dung SET mat_khau = ? WHERE id = ?");
                $update->execute([$newHash, $user['id']]);
            }
            return $user;
        }

        return false;
    }

    // Lấy tất cả người dùng (Cho trang Admin)
    public function getAllUsers() {
        $sql = "SELECT id, ho_ten, email, so_dien_thoai, vai_tro FROM nguoi_dung ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin tài khoản người dùng
    public function updateUser($id, $name, $email, $address, $phone, $role = 'khach_hang') {
        $sql = "UPDATE nguoi_dung 
                SET ho_ten = ?, email = ?, dia_chi = ?, so_dien_thoai = ?, vai_tro = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $address, $phone, $role, $id]);
    }

    // ==========================================
    // CÁC HÀM XỬ LÝ QUÊN MẬT KHẨU (RESET PASSWORD)
    // ==========================================

    // Tạo Token reset mật khẩu (Hạn 15 phút)
    public function createResetToken($email) {
        $user = $this->checkEmail($email);
        if (!$user) {
            return false;
        }

        $token  = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $sql  = "UPDATE nguoi_dung SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $success = $stmt->execute([$token, $expiry, $email]);

        return $success ? $token : false;
    }

    // Kiểm tra Token reset còn hạn không
    public function verifyResetToken($token) {
        $sql  = "SELECT * FROM nguoi_dung WHERE reset_token = ? AND reset_token_expiry > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đổi mật khẩu mới bằng Token
    public function resetPasswordWithToken($token, $newPassword) {
        $user = $this->verifyResetToken($token);
        if (!$user) {
            return false;
        }

        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql  = "UPDATE nguoi_dung SET mat_khau = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$passwordHash, $user['id']]);
    }

    // Đổi mật khẩu trực tiếp bằng Email
    public function updatePassword($email, $newPassword) {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql  = "UPDATE nguoi_dung SET mat_khau = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$passwordHash, $email]);
    }
}