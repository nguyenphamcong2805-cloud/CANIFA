<?php
// Tải phần Header
include_once __DIR__ . '/header.php';

require_once __DIR__ . '/../../Model/Database.php';
require_once __DIR__ . '/../../Model/Products.php';

// Lấy ID sản phẩm an toàn từ URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$product = $productModel->getProductById($productId);

if (!$product) {
    header('Location: ' . BASE_URL_SITE . 'index_shop.php?ctrl=home&act=index');
    exit;
}

$categoryId = isset($product['danh_muc_id']) ? (int)$product['danh_muc_id'] : 0;
$relatedProducts = [];
if ($categoryId > 0) {
    $relatedProducts = $productModel->getProductsByCategory($categoryId);
    $relatedProducts = array_filter($relatedProducts, function ($item) use ($productId) {
        return (int)$item['id'] !== $productId;
    });
    $relatedProducts = array_slice($relatedProducts, 0, 4);
}

function getImageUrl($filename) {
    $filename = trim((string)$filename);
    if ($filename === '') {
        return BASE_URL . 'img/banner1.jpg';
    }
    if (filter_var($filename, FILTER_VALIDATE_URL)) {
        return $filename;
    }
    if (strpos($filename, '/') === 0) {
        return BASE_URL . ltrim($filename, '/');
    }
    return BASE_URL . 'img/' . ltrim($filename, '/');
}
?>

<style>
    /* LAYOUT CHÍNH CHI TIẾT SẢN PHẨM */
    .product-detail-container {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 40px;
        margin-top: 20px;
        margin-bottom: 40px;
        align-items: start;
    }

    .product-gallery {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 120px;
        gap: 18px;
        align-items: start;
    }

    .main-image {
        width: 100%;
        height: 580px;
        background: #f8f8f8;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        border: 1px solid #e8e8e8;
    }

    .main-image img {
        width: auto;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .thumbnail-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .thumbnail {
        width: 100%;
        height: 120px;
        background: #f5f5f5;
        cursor: pointer;
        border: 2px solid transparent;
        transition: 0.3s;
        border-radius: 16px;
        overflow: hidden;
    }

    .thumbnail.active { border-color: #333; }
    .thumbnail img { width: 100%; height: 100%; object-fit: cover; }

    .product-info-detail h1 {
        font-size: 32px;
        margin-bottom: 12px;
        color: #171717;
        line-height: 1.2;
    }

    .product-info-detail .sku {
        color: #777;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .price-wrap {
        margin-bottom: 25px;
        display: flex;
        align-items: baseline;
        gap: 16px;
        flex-wrap: wrap;
    }

    .price-wrap .current-price {
        font-size: 32px;
        font-weight: 800;
        color: #d32f2f;
    }

    .price-wrap .old-price {
        font-size: 18px;
        color: #999;
        text-decoration: line-through;
    }

    .price-wrap .sale-badge {
        background: #d32f2f;
        color: white;
        padding: 4px 10px;
        font-size: 13px;
        border-radius: 4px;
        font-weight: bold;
    }

    .option-group { margin-bottom: 25px; }
    .option-title { font-weight: bold; margin-bottom: 10px; display: block; font-size: 15px; }
    .size-list { display: flex; gap: 10px; }

    .size-btn {
        width: 48px;
        height: 48px;
        border: 1px solid #ddd;
        background: #fff;
        cursor: pointer;
        font-size: 16px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .size-btn.active {
        background: #333;
        color: white;
        border-color: #333;
    }

    .quantity-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: fit-content;
        height: 45px;
        overflow: hidden;
    }

    .qty-btn {
        width: 40px;
        height: 100%;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
    }

    .qty-input {
        width: 50px;
        height: 100%;
        border: none;
        text-align: center;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        font-size: 16px;
        font-weight: bold;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        margin-bottom: 30px;
    }

    .btn-add-cart, .btn-buy-now {
        flex: 1;
        height: 50px;
        padding: 0 20px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        text-transform: uppercase;
        border-radius: 10px;
    }

    .btn-add-cart {
        background: #fff;
        color: #333;
        border: 1.5px solid #333;
    }

    .btn-add-cart:hover { background: #f5f5f5; }

    .btn-buy-now {
        background: #d32f2f;
        color: #fff;
        border: 1.5px solid #d32f2f;
    }

    .btn-buy-now:hover { background: #b71c1c; }

    .product-description {
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .product-description h3 { margin-bottom: 12px; font-size: 18px; }
    .product-description p, .product-description ul { color: #555; font-size: 15px; line-height: 1.6; margin-left: 20px; }

    /* =================================================== */
    /* KHỐI ĐÁNH GIÁ SẢN PHẨM (BỰ & RỘNG RÃI TOÀN KHUNG)   */
    /* =================================================== */
    .review-section {
        width: 100%;
        margin-top: 50px;
        padding: 35px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        box-sizing: border-box;
    }

    .review-section h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #111;
    }

    .review-summary {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .average-stars { display: flex; gap: 6px; font-size: 28px; }
    .average-stars .star { color: #e0e0e0; }
    .average-stars .star.filled { color: #f9a825; }

    .average-rating { font-size: 22px; font-weight: 800; color: #d32f2f; }
    .review-count { color: #666; font-size: 15px; }

    /* Ô nhập liệu Form Đánh Giá Bự */
    .review-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .review-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 16px;
        color: #222;
    }

    .review-form select,
    .review-form textarea,
    .review-form input {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #ccc;
        border-radius: 12px;
        font-size: 15px;
        background-color: #fafafa;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .review-form select:focus,
    .review-form textarea:focus,
    .review-form input:focus {
        outline: none;
        border-color: #d32f2f;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
    }

    .review-form textarea { min-height: 120px; resize: vertical; }

    .btn-submit-review {
        width: fit-content;
        min-width: 180px;
        padding: 14px 28px;
        background: #d32f2f;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        text-transform: uppercase;
        transition: background 0.2s;
    }

    .btn-submit-review:hover { background: #b71c1c; }

    /* Danh sách bình luận */
    .review-list { display: flex; flex-direction: column; gap: 16px; }

    .review-item {
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 20px 24px;
        background: #fcfcfc;
    }

    .review-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .review-stars .star.filled { color: #f9a825; }
    .review-text { color: #444; font-size: 15px; line-height: 1.6; margin-bottom: 8px; }
    .review-date { color: #888; font-size: 13px; }

    /* =================================================== */
    /* KHỐI SẢN PHẨM TƯƠNG TỰ                              */
    /* =================================================== */
    .related-products {
        margin-top: 60px;
        margin-bottom: 60px;
        text-align: center;
    }

    .related-products h3 {
        display: inline-block;
        position: relative;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 35px;
        color: #171717;
        padding: 0 25px;
        background: #fff;
    }

    .related-products h3::before,
    .related-products h3::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 120px;
        height: 1px;
        background: #ddd;
    }

    .related-products h3::before { left: -140px; }
    .related-products h3::after { right: -140px; }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .related-card {
        border: 1px solid #eee;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
        text-align: left;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .related-card a { text-decoration: none; }

    .related-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        background: #f8f8f8;
    }

    .related-card-body { padding: 16px; }

    .related-name {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.4;
        height: 42px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .related-price {
        font-size: 16px;
        font-weight: 700;
        color: #d32f2f;
    }

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .product-detail-container { grid-template-columns: 1fr; }
        .main-image { height: 420px; }
        .related-grid { grid-template-columns: repeat(2, 1fr); }
        .related-products h3::before, .related-products h3::after { display: none; }
    }

    @media (max-width: 576px) {
        .product-gallery { grid-template-columns: 1fr; }
        .thumbnail-list { flex-direction: row; }
        .thumbnail { height: 80px; }
        .related-grid { grid-template-columns: 1fr; }
        .review-section { padding: 20px; }
    }
</style>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index">Trang chủ</a> |
        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=product&act=index">Áo</a> |
        <span id="breadcrumbProductName"><?= htmlspecialchars($product['ten_san_pham']) ?></span>
    </div>

    <!-- 1. MAIN CONTENT (Cột trái Ảnh - Cột phải Thông tin) -->
    <div class="product-detail-container">
        
        <!-- Cột trái: Ảnh sản phẩm -->
        <div class="product-gallery">
            <div class="main-image">
                <img id="mainImage" src="<?= htmlspecialchars(getImageUrl($product['hinh_anh'] ?? '')) ?>" alt="Sản phẩm">
            </div>
            <div class="thumbnail-list" id="thumbnailList"></div>
        </div>

        <!-- Cột phải: Thông tin sản phẩm -->
        <div class="product-info-detail">
            <h1 id="productTitle"><?= htmlspecialchars($product['ten_san_pham'] ?? 'Đang tải...') ?></h1>
            <p class="sku" id="productSku">Mã SP: <?= htmlspecialchars($product['ma_san_pham'] ?? 'SP-' . $productId) ?> | Tình trạng: Còn hàng</p>

            <div class="price-wrap">
                <span class="current-price" id="currentPrice"><?= number_format($product['gia'] ?? 0) ?> ₫</span>
                <span class="old-price" id="oldPrice"><?= isset($product['gia_cu']) && $product['gia_cu'] > $product['gia'] ? number_format($product['gia_cu']) . ' ₫' : '' ?></span>
                <span class="sale-badge" id="saleBadge" style="display: <?= isset($product['gia_cu']) && $product['gia_cu'] > $product['gia'] ? 'inline-block' : 'none' ?>;">-<?= intval($product['giam_gia'] ?? 0) ?>%</span>
            </div>

            <!-- Chọn Size -->
            <div class="option-group">
                <span class="option-title">Kích cỡ: <span id="sizeSelected">M</span></span>
                <div class="size-list">
                    <button class="size-btn active" onclick="selectSize(this, 'M')">M</button>
                    <button class="size-btn" onclick="selectSize(this, 'L')">L</button>
                    <button class="size-btn" onclick="selectSize(this, 'XL')">XL</button>
                    <button class="size-btn" onclick="selectSize(this, 'XXL')">XXL</button>
                </div>
            </div>

            <!-- Chọn số lượng -->
            <div class="option-group">
                <span class="option-title">Số lượng:</span>
                <div class="quantity-wrap">
                    <button class="qty-btn" onclick="decreaseQty()">-</button>
                    <input type="text" id="qtyInput" class="qty-input" value="1" readonly>
                    <button class="qty-btn" onclick="increaseQty()">+</button>
                </div>
            </div>

            <!-- Nút mua hàng -->
            <form id="addToCartForm" action="<?= BASE_URL_SITE ?>index_shop.php?ctrl=cart&act=add" method="POST">
                <input type="hidden" name="id" value="<?= $productId ?>">
                <input type="hidden" name="quantity" id="cartQuantity" value="1">
                <input type="hidden" name="size" id="cartSize" value="M">
                <div class="action-buttons">
                    <button type="submit" class="btn-add-cart">THÊM VÀO GIỎ</button>
                    <button type="button" class="btn-buy-now" onclick="buyNow()">MUA NGAY</button>
                </div>
            </form>

            <!-- Mô tả sản phẩm -->
            <div class="product-description">
                <h3>Mô tả sản phẩm</h3>
                <p><?= nl2br(htmlspecialchars($product['mo_ta'] ?? 'Áo sơ mi nam phom dáng Slim-Fit ôm vừa vặn, tôn dáng người mặc.')) ?></p>
                <ul>
                    <li>Chất liệu: <?= htmlspecialchars($product['chat_lieu'] ?? '50% Bamboo, 50% Microfiber') ?></li>
                    <li>Kiểu dáng: <?= htmlspecialchars($product['kieu_dang'] ?? 'Slim Fit / Regular Fit') ?></li>
                    <li>Họa tiết: <?= htmlspecialchars($product['hoa_tiet'] ?? 'Trơn cơ bản lịch sự') ?></li>
                    <li>Sản xuất tại: <?= htmlspecialchars($product['xuat_xu'] ?? 'Việt Nam') ?></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2. KHỐI ĐÁNH GIÁ SẢN PHẨM (RỘNG TOÀN MAN HÌNH CONTAINER) -->
    <div class="review-section">
        <h3>Đánh giá sản phẩm</h3>
        
        <?php if (!empty($_SESSION['review_message'])): ?>
            <div class="review-message" style="margin-bottom:15px; padding:12px; background:#e8f5e9; color:#2e7d32; border-radius:8px;"><?= htmlspecialchars($_SESSION['review_message']) ?></div>
            <?php unset($_SESSION['review_message']); ?>
        <?php endif; ?>

        <div class="review-summary">
            <div class="average-stars" aria-label="Đánh giá trung bình">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="star <?= $i <= round($averageRating ?? 0) ? 'filled' : '' ?>">★</span>
                <?php endfor; ?>
            </div>
            <div class="review-info">
                <span class="average-rating"><?= htmlspecialchars($averageRating ?? 0) ?> / 5</span>
                <span class="review-count">(<?= htmlspecialchars($reviewCount ?? 0) ?> đánh giá)</span>
            </div>
        </div>

        <!-- Form Đánh Giá Bự -->
        <form class="review-form" method="POST" action="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=productDetail&id=<?= $productId ?>">
            <input type="hidden" name="product_id" value="<?= $productId ?>">
            
            <div class="rating-input">
                <label>Chọn số sao:</label>
                <select name="rating" required>
                    <option value="">-- Chọn đánh giá --</option>
                    <option value="5">5 sao - Rất tốt</option>
                    <option value="4">4 sao - Tốt</option>
                    <option value="3">3 sao - Bình thường</option>
                    <option value="2">2 sao - Kém</option>
                    <option value="1">1 sao - Rất kém</option>
                </select>
            </div>

            <div class="comment-input">
                <label>Nhận xét của bạn:</label>
                <textarea name="comment" rows="4" placeholder="Hãy chia sẻ cảm nhận của bạn về sản phẩm này..." required></textarea>
            </div>

            <div class="comment-input">
                <label>Tên hiển thị:</label>
                <input type="text" name="author_name" value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>" placeholder="Nhập tên của bạn">
            </div>

            <button type="submit" class="btn-submit-review">GỬI ĐÁNH GIÁ</button>
        </form>

        <!-- Danh sách đánh giá -->
        <div class="review-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <div class="review-item-header">
                            <strong><?= htmlspecialchars($review['author_name'] ?: 'Khách hàng') ?></strong>
                            <span class="review-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= intval($review['rating']) ? 'filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </span>
                        </div>
                        <div class="review-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
                        <div class="review-date"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($review['created_at']))) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#777; font-style:italic;">Chưa có đánh giá nào. Hãy là người đầu tiên nhận xét!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- 3. KHỐI SẢN PHẨM TƯƠNG TỰ -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="related-products">
            <h3>Sản phẩm tương tự</h3>
            <div class="related-grid">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="related-card">
                        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=productDetail&id=<?= (int)$related['id'] ?>">
                            <img src="<?= htmlspecialchars(getImageUrl($related['hinh_anh'] ?? '')) ?>" alt="<?= htmlspecialchars($related['ten_san_pham']) ?>" onerror="this.onerror=null; this.src='<?= BASE_URL ?>img/banner1.jpg';">
                            <div class="related-card-body">
                                <div class="related-name"><?= htmlspecialchars($related['ten_san_pham']) ?></div>
                                <div class="related-price"><?= number_format($related['gia']) ?> ₫</div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    const BASE_URL = '<?= BASE_URL ?>';
    const product = {
        id: <?= json_encode($product['id']) ?>,
        name: <?= json_encode($product['ten_san_pham']) ?>,
        sku: <?= json_encode($product['ma_san_pham'] ?? 'SP-' . $productId) ?>,
        price: <?= json_encode((float)$product['gia']) ?>,
        oldPrice: <?= json_encode(isset($product['gia_cu']) ? (float)$product['gia_cu'] : null) ?>,
        discountPercent: <?= json_encode(isset($product['giam_gia']) ? (int)$product['giam_gia'] : 0) ?>,
        image: <?= json_encode(getImageUrl($product['hinh_anh'] ?? '')) ?>
    };

    function initProductDetail() {
        document.getElementById('breadcrumbProductName').innerText = product.name;
        document.getElementById('productTitle').innerText = product.name;
        document.getElementById('productSku').innerText = 'Mã SP: ' + product.sku + ' | Tình trạng: Còn hàng';
        document.getElementById('currentPrice').innerText = product.price.toLocaleString('vi-VN') + ' ₫';

        if (product.oldPrice && product.oldPrice > product.price) {
            document.getElementById('oldPrice').innerText = product.oldPrice.toLocaleString('vi-VN') + ' ₫';
            document.getElementById('saleBadge').style.display = 'inline-block';
            document.getElementById('saleBadge').innerText = `-${product.discountPercent}%`;
        } else {
            document.getElementById('oldPrice').innerText = '';
            document.getElementById('saleBadge').style.display = 'none';
        }

        const mainImg = document.getElementById('mainImage');
        mainImg.src = product.image;
        mainImg.onerror = function() {
            this.src = BASE_URL + 'img/banner1.jpg';
        };

        const thumbContainer = document.getElementById('thumbnailList');
        thumbContainer.innerHTML = '';
        for (let i = 1; i <= 3; i++) {
            const thumbDiv = document.createElement('div');
            thumbDiv.className = `thumbnail ${i === 1 ? 'active' : ''}`;
            const thumbImgSrc = product.image;
            thumbDiv.innerHTML = `<img src="${thumbImgSrc}" onerror="this.src='${BASE_URL}img/banner1.jpg';" alt="Thumb ${i}">`;
            thumbDiv.addEventListener('click', function() {
                document.querySelectorAll('.thumbnail').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                mainImg.src = thumbImgSrc;
            });
            thumbContainer.appendChild(thumbDiv);
        }
    }

    function selectSize(element, size) {
        document.getElementById('sizeSelected').innerText = size;
        document.getElementById('cartSize').value = size;
        document.querySelectorAll('.size-btn').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function decreaseQty() {
        let input = document.getElementById('qtyInput');
        let current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
        document.getElementById('cartQuantity').value = input.value;
    }

    function increaseQty() {
        let input = document.getElementById('qtyInput');
        input.value = parseInt(input.value) + 1;
        document.getElementById('cartQuantity').value = input.value;
    }

    function buyNow() {
        const form = document.getElementById('addToCartForm');
        const hiddenRedirect = document.createElement('input');
        hiddenRedirect.type = 'hidden';
        hiddenRedirect.name = 'redirect';
        hiddenRedirect.value = 'checkout';
        form.appendChild(hiddenRedirect);
        form.submit();
    }

    initProductDetail();
</script>

<?php
// Tải phần Footer
include_once __DIR__ . '/footer.php';
?>