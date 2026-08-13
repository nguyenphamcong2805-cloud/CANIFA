<?php

$bestsellerShirts = $bestsellerShirts ?? [];
$shirts = $shirts ?? [];
$pants = $pants ?? [];
require_once "./app/Controller/HomeController.php";
require_once __DIR__ . '/header.php';

/**
 * Hàm hiển thị danh sách sản phẩm
 */
function renderProducts($title, $products)
{
?>
<main class="bestseller-section">
    <div class="bestseller-container">

        <div class="bestseller-header">
            <div class="bestseller-line"></div>
            <h1 class="bestseller-title"><?= htmlspecialchars($title) ?></h1>
            <div class="bestseller-line"></div>
        </div>

        <div class="bestseller-grid">

            <?php if (!empty($products)): ?>

                <?php foreach ($products as $sp): ?>

                    <div class="bestseller-card">

                        <div class="bestseller-image-box">
                            <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=productDetail&id=<?= (int)$sp['id'] ?>">
                                <img
                                    src="./public/Shop/img/<?= htmlspecialchars($sp['hinh_anh'], ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($sp['ten_san_pham'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="bestseller-img">
                            </a>
                        </div>

                        <div class="bestseller-label">
                            <?= htmlspecialchars($sp['ten_san_pham'], ENT_QUOTES, 'UTF-8') ?>
                        </div>

                        <?php if (isset($sp['gia'])): ?>
                            <div class="bestseller-price">
                                <?= number_format($sp['gia']) ?> VNĐ
                            </div>
                        <?php endif; ?>

                        <?php if (isset($sp['da_ban'])): ?>
                            <div class="bestseller-price">
                                Đã bán <?= (int)$sp['da_ban'] ?> sản phẩm
                            </div>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p>Hiện chưa có sản phẩm.</p>

            <?php endif; ?>

        </div>

    </div>
</main>
<?php
}
?>

<div class="banner">
    CHANGE VIEW POINT - SEE NOW
</div>

<div class="hero-banner">
    <img src="./public/Shop/img/banner2.jpg" alt="Banner">
</div>

<div class="product-grid">
    <div class="product-card">
        <img src="./public/Shop/img/polo_tre_trung.png" alt="">
    </div>

    <div class="product-card">
        <img src="./public/Shop/img/quan_au_hien_dai.png" alt="">
    </div>

    <div class="product-card">
        <img src="./public/Shop/img/so_mi_lich_lam.png" alt="">
    </div>
</div>

<div class="fashion-slider">

    <div class="slider-container">

        <div class="slider-slide active">
            <img src="./public/Shop/img/slider1.png" alt="">
        </div>

        <div class="slider-slide">
            <img src="./public/Shop/img/slider2.png" alt="">
        </div>

        <button class="slider-arrow prev" onclick="changeSlide(-1)">←</button>
        <button class="slider-arrow next" onclick="changeSlide(1)">→</button>

    </div>

</div>

<?php
renderProducts("BÁN CHẠY NHẤT", $bestsellerShirts);

renderProducts("SƠ MI LỊCH LÃM", $shirts);

renderProducts("QUẦN ÂU HIỆN ĐẠI", $pants);
?>

<div class="newsletter-section">

    <div class="newsletter-image">
        <img src="./public/Shop/img/new.png" alt="">
    </div>

    <div class="newsletter-content">

        <h2>ĐĂNG KÝ NHẬN BẢNG TIN</h2>

        <p>
            Đừng bỏ lỡ hàng ngàn sản phẩm và chương trình
            <br>
            siêu hấp dẫn
        </p>

        <form class="newsletter-form" action="#" method="post">

            <input
                type="email"
                placeholder="Nhập email của bạn"
                required>

            <button type="submit">
                ĐĂNG KÝ
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<script>

const slides = document.querySelectorAll('.slider-slide');

if(slides.length){

    let currentSlide = 0;

    function showSlide(index){

        slides.forEach(slide => slide.classList.remove("active"));

        slides[index].classList.add("active");

    }

    function changeSlide(direction){

        currentSlide += direction;

        if(currentSlide >= slides.length){

            currentSlide = 0;

        }

        if(currentSlide < 0){

            currentSlide = slides.length - 1;

        }

        showSlide(currentSlide);

    }

    window.changeSlide = changeSlide;

    setInterval(function(){

        changeSlide(1);

    },5000);

}

</script>