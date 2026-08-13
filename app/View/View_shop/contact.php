<?php require_once 'header.php'; ?>
<div class="container" style="padding:60px 20px; max-width:700px; margin:0 auto;">
    <h2 style="font-size:26px; margin-bottom:24px; text-transform:uppercase;">Liên hệ</h2>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px;">
        <div>
            <h4 style="margin-bottom:10px;">Thông tin liên hệ</h4>
            <p style="color:#555; line-height:2;">
                📞 Hotline: <strong>1900 1080</strong><br>
                ✉️ Email: <strong>support@canifa.com</strong><br>
                🕐 8:30 - 19:00 tất cả các ngày<br>
                📍 48 Tố Hữu, Nam Từ Liêm, Hà Nội
            </p>
        </div>
        <div>
            <h4 style="margin-bottom:10px;">Gửi tin nhắn</h4>
            <form style="display:flex; flex-direction:column; gap:10px;">
                <input type="text" placeholder="Họ tên" style="padding:10px; border:1px solid #ddd; border-radius:6px;">
                <input type="email" placeholder="Email" style="padding:10px; border:1px solid #ddd; border-radius:6px;">
                <textarea placeholder="Nội dung..." rows="4" style="padding:10px; border:1px solid #ddd; border-radius:6px; resize:vertical;"></textarea>
                <button type="button" style="padding:12px; background:#222; color:#fff; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">Gửi</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
