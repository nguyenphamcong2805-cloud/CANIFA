<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            color: #111827;
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 40px;
            padding: 48px 24px;
            min-height: 100vh;
        }

        .left {
            flex: 1;
            background: #fff;
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .left small {
            color: #6b7280;
            font-size: 13px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .left h1 {
            font-size: 30px;
            margin: 0 0 8px;
            text-transform: uppercase;
        }

        .left p {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 20px;
        }

        label {
            font-weight: 700;
            display: block;
            margin: 14px 0 8px;
        }

        input {
            width: 100%;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 13px 14px;
            font-size: 15px;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        input:focus {
            border-color: #2563eb;
        }

        .btn-black, .btn-gray {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .btn-black {
            background: #111827;
            color: #fff;
            margin-top: 24px;
        }

        .btn-gray {
            background: #e5e7eb;
            color: #111827;
            margin-top: 12px;
        }

        .btn-black:hover, .btn-gray:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        .text-link {
            display: block;
            text-align: center;
            margin-top: 14px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fecaca;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .right img {
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            object-fit: cover;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                padding: 24px 16px;
            }

            .left, .right {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <small>Trang chủ | Đăng nhập</small>
        <h1>Đăng nhập</h1>
        <p>Nếu bạn đã có tài khoản, hãy đăng nhập để tích lũy điểm thành viên và nhận được những ưu đãi tốt hơn.</p>

        <?php if (isset($_SESSION['info'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['info']); unset($_SESSION['info']); ?></p>
        <?php endif; ?>

        <form action="index_shop.php?ctrl=user&act=submitLogin" method="POST">
            <label for="email">Email hoặc số điện thoại *</label>
            <input id="email" type="text" name="email" placeholder="Email hoặc số điện thoại" required>

            <label for="password">Mật khẩu *</label>
            <input id="password" type="password" name="password" placeholder="Nhập mật khẩu" required>

            <button class="btn-black" type="submit">ĐĂNG NHẬP</button>
            <button class="btn-black" type="submit">Quên Mật Khẩu</button>

        <a class="text-link" href="index_shop.php?ctrl=home&act=register">Tạo tài khoản mới</a>
    </div>

    <div class="right">
        <img src="<?= BASE_URL ?>img/dangki.png" alt="Đăng nhập">
    </div>
</div>
</body>
</html>
