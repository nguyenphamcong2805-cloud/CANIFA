<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            padding: 40px 20px;
        }

        /* LEFT FORM */
        .left {
            flex: 1;
            padding-right: 40px;
        }

        .left small {
            color: #777;
            font-size: 13px;
        }

        .left h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .left p {
            color: #444;
            font-size: 14px;
            margin-bottom: 20px;
            margin-top: 0;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            background: #f1f1f1;
            border: none;
            padding: 12px;
            font-size: 15px;
            border-radius: 4px;
            outline: none;
        }

        .btn-black {
            width: 100%;
            background: #000;
            color: white;
            padding: 14px;
            border: none;
            margin-top: 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-gray {
            width: 100%;
            background: #555;
            color: white;
            padding: 14px;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-black:hover { opacity: 0.9; }
        .btn-gray:hover { opacity: 0.9; }

        .error {
            color: red;
            margin-top: 10px;
        }

        /* RIGHT IMAGE */
        .right {
            flex: 1;
            position: relative;
        }

        .right img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .right-text {
            position: absolute;
            top: 40px;
            left: 30px;
            color: #000;
        }

        .right-text h2 {
            font-size: 32px;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .right-text p {
            color: #333;
            line-height: 1.4;
            font-size: 14px;
            max-width: 320px;
        }
    </style>

</head>
<body>

<div class="container">

    <!-- LEFT SIDE (FORM) -->
    <div class="left">

        <small>Trang chủ | Đăng nhập</small>

        <h1>ĐĂNG NHẬP</h1>
        <p>Nếu bạn đã có tài khoản, hãy đăng nhập để tích lũy điểm thành viên và nhận được những ưu đãi tốt hơn!</p>

        <?php if(isset($_SESSION['info'])): ?>
            <p class="error"><?= $_SESSION['info']; unset($_SESSION['info']); ?></p>
        <?php endif; ?>

        <form action="FPL/DEV/index_shop.php?ctrl=user&act=submitLogin" method="POST">

            <label>Email hoặc Số điện thoại *</label>
            <input type="text" name="email" placeholder="Email hoặc số điện thoại">

            <label>Mật khẩu *</label>
          
            <input type="password" name="password" placeholder="Nhập mật khẩu">

            <button class="btn-black" type="submit">ĐĂNG NHẬP</button>

            <a href="FPL/DEV/DEV/index_shop.php?ctrl=user&act=register">
                <button class="btn-gray" type="button">TẠO TÀI KHOẢN QUÊN MẬT KHẨU</button>
            </a>

        </form>
    </div>

    <!-- RIGHT SIDE (IMAGE + TEXT) -->
    <div class="right">
        <img src="https://picsum.photos/600/800" alt="Login Image">

        <div class="right-text">
            <h2>ĐĂNG KÝ<br>TÀI KHOẢN NGAY</h2>
            <p>
                Bằng cách cung cấp cho OVEN thông tin chi tiết của bạn,
                quá trình mua hàng tại Owen.vn sẽ là một trải nghiệm thú vị,
                chi tiết và nhanh chóng hơn!
            </p>
        </div>
    </div>

</div>

</body>
</html>
