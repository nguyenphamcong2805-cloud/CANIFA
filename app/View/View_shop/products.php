<?php
// Tải phần Header
include_once 'header.php'; 
?>

<!-- Liên kết CSS chuẩn theo BASE_URL -->
<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">

<!-- Banner Section -->
<div class="banner-section">
    <div class="banner-strip">
        <span class="tick">✓</span>CHANGE VIEW POINT - SEE NOW
    </div>
    <div class="banner-content">
        <img src="<?= BASE_URL ?>img/banner1.jpg" alt="Banner Áo Sơ Mi Nam">
    </div>
</div>

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=home&act=index">Trang chủ</a> | <a href="<?= BASE_URL_SITE ?>index_shop.php?ctrl=product&act=index"><?= htmlspecialchars($pageTitle ?? 'Sản phẩm') ?></a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar -->
       <!-- Sidebar -->
<!-- Sidebar với thuộc tính data-name đầy đủ -->
<aside class="sidebar">
    <div class="sidebar-section">
        <h3 class="sidebar-title">HÀNG MỚI VỀ BỘ SƯU TẬP</h3>
        <ul class="sidebar-list">
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="IKIGAI"> IKIGAI</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="KAIZEN"> KAIZEN</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="BST BẠC HÀ"> BST BẠC HÀ</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="RENU"> RENU</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="JOY THE BEST"> JOY THE BEST</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="CHANGE VIEW POINT"> CHANGE VIEW POINT</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="BST RETRO"> BST RETRO</label></li>
        </ul>
    </div>

    <div class="sidebar-section">
        <h3 class="sidebar-title">GIÁ TỐT</h3>
        <ul class="sidebar-list">
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Polo tshirt"> Polo tshirt</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần giá tốt"> Quần giá tốt</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần short"> Quần short</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần Tây"> Quần Tây</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần Kaki"> Quần Kaki</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần Jean"> Quần Jean</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần Jokker"> Quần Jokker</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Quần Ni"> Quần Nỉ</label></li>
        </ul>
    </div>

    <div class="sidebar-section">
        <h3 class="sidebar-title">PHỤ KIỆN</h3>
        <ul class="sidebar-list">
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Đồ Lót"> Đồ Lót</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Tất"> Tất</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Dây Lưng"> Dây Lưng</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Ví"> Ví</label></li>
            <li><label class="sidebar-checkbox-label"><input type="checkbox" class="filter-cb" data-name="Cà Vạt"> Cà Vạt</label></li>
        </ul>
    </div>
</aside>
        <!-- Products Section -->
        <main class="products-section">
            <div class="products-header">
                <h2 class="products-title">HÀNG MỚI VỀ BỘ SƯU TẬP</h2>
                <div class="products-controls">
                    <span>Hiển thị</span>
                    <div class="view-toggle">
                        <button class="view-btn active">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <rect width="4" height="4"/>
                                <rect x="6" width="4" height="4"/>
                                <rect x="12" width="4" height="4"/>
                                <rect y="6" width="4" height="4"/>
                                <rect x="6" y="6" width="4" height="4"/>
                                <rect x="12" y="6" width="4" height="4"/>
                                <rect y="12" width="4" height="4"/>
                                <rect x="6" y="12" width="4" height="4"/>
                                <rect x="12" y="12" width="4" height="4"/>
                            </svg>
                        </button>
                    </div>
                    <select class="filter-select">
                        <option value="default">Bộ lọc</option>
                        <option value="asc">Giá tăng dần</option>
                        <option value="desc">Giá giảm dần</option>
                        <option value="newest">Mới nhất</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid"></div>

            <!-- Pagination -->
            <div class="pagination" id="pagination"></div>
        </main>
    </div>
</div>

<script>
    const BASE_URL = '<?= BASE_URL ?>';

    // 1. LẤY DỮ LIỆU TỪ DATABASE PHP CHUYỂN SANG JAVASCRIPT
    const dbProducts = <?= json_encode($products ?? []) ?>;

    // 2. CHUẨN HÓA DỮ LIỆU VÀ ĐÁNH GIÁ TÊN, GIÁ, ẢNH
    let products = dbProducts.map(p => {
        const id = p.id;
        // Bắt chính xác tên sản phẩm từ Database
        const name = p.ten_san_pham || p.ten || p.name || `Sản phẩm ${id}`;
        // Bắt chính xác giá từ Database (ép kiểu số)
        const price = p.gia ? parseFloat(p.gia) : 180000;
        
        // Đường dẫn hình ảnh
        let image = p.hinh_anh || p.anh;
        if (!image) {
            image = `${BASE_URL}img/ao_so_mi(${id}).webp`;
        } else if (!image.startsWith('http')) {
            image = `${BASE_URL}img/` + image;
        }

        return {
            id: id,
            name: name,
            price: price,
            oldPrice: p.gia_cu ? parseFloat(p.gia_cu) : null,
            discountPercent: p.giam_gia ? parseInt(p.giam_gia) : 0,
            image: image
        };
    });

    const productsPerPage = 9;
    let totalPages = Math.ceil(products.length / productsPerPage) || 1;
    let currentPage = 1;

    // 3. ĐỊNH DẠNG HIỂN THỊ TIỀN VIỆT NAM (VD: 250.000 vnd)
    function formatPrice(value) {
        if (!value || value === 0) return 'Liên hệ';
        return value.toLocaleString('vi-VN') + ' vnd';
    }

    // 4. HIỂN THỊ SẢN PHẨM RA MÀN HÌNH
    function renderProducts(page) {
        const grid = document.getElementById('productsGrid');
        if (!grid) return;

        grid.innerHTML = '';

        if (products.length === 0) {
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px 0; font-weight: bold; color: #666;">Không có sản phẩm nào trong Database!</p>';
            return;
        }

        const start = (page - 1) * productsPerPage;
        const end = start + productsPerPage;
        const pageProducts = products.slice(start, end);

        pageProducts.forEach((product) => {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.style.cursor = 'pointer';

            // HTML Giảm giá
            const badgeHTML = product.discountPercent > 0 
                ? `<div class="product-badge">-${product.discountPercent}%</div>` 
                : '';

            // HTML Giá cũ
            const oldPriceHTML = product.oldPrice 
                ? `<span class="product-price-old" style="text-decoration: line-through; color: #888; font-size: 13px; margin-left: 8px;">${formatPrice(product.oldPrice)}</span>` 
                : '';

            // Render khung HTML chứa TÊN và GIÁ
            card.innerHTML = `
                <div class="product-image">
                    ${badgeHTML}
                    <img src="${product.image}" 
                         alt="${product.name}"
                         onerror="this.onerror=null; this.src='${BASE_URL}img/banner1.jpg';">
                </div>
                <div class="product-info" style="padding: 12px 8px; text-align: left;">
                    <div class="product-name" style="font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #333; line-height: 1.4; height: 38px; overflow: hidden;">
                        ${product.name}
                    </div>
                    <div class="product-price ${product.discountPercent > 0 ? 'sale' : ''}" style="color: #d9534f; font-weight: bold; font-size: 15px;">
                        ${formatPrice(product.price)}
                        ${oldPriceHTML}
                    </div>
                </div>
            `;

            // CHUYỂN SANG TRANG CHI TIẾT SẢN PHẨM VỚI ID THẬT
            card.addEventListener('click', function() {
                window.location.href = '<?= BASE_URL_SITE ?>index_shop.php?ctrl=product&act=detail&id=' + product.id;
            });

            grid.appendChild(card);
        });
    }

    // 5. HIỂN THỊ PHÂN TRANG
    function renderPagination(page) {
        const container = document.getElementById('pagination');
        if (!container) return;

        container.innerHTML = '';
        totalPages = Math.ceil(products.length / productsPerPage) || 1;

        if (totalPages <= 1) return;

        const addButton = (label, targetPage, isActive = false, disabled = false) => {
            const button = document.createElement('button');
            button.textContent = label;
            if (isActive) button.classList.add('active');
            if (disabled) button.disabled = true;
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!disabled) {
                    goToPage(targetPage);
                }
            });
            container.appendChild(button);
        };

        addButton('←', page - 1, false, page === 1);

        for (let i = 1; i <= totalPages; i++) {
            addButton(i, i, i === page);
        }

        addButton('→', page + 1, false, page === totalPages);
    }

    function goToPage(page) {
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderProducts(currentPage);
        renderPagination(currentPage);
    }

    // 6. BỘ LỌC SẮP XẾP SẢN PHẨM
    const filterSelect = document.querySelector('.filter-select');
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            const value = this.value;
            if (value === 'asc') {
                products.sort((a, b) => a.price - b.price);
            } else if (value === 'desc') {
                products.sort((a, b) => b.price - a.price);
            } else if (value === 'newest') {
                products.sort((a, b) => b.id - a.id);
            }
            goToPage(1);
        });
    }

    // KHỞI TẠO HIỂN THỊ TRANG TRẦN ĐẦU TIÊN
    goToPage(1);
    function renderProducts(page) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;

    grid.innerHTML = '';

    if (products.length === 0) {
        grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px 0;">Không có sản phẩm nào trong Database!</p>';
        return;
    }

    const start = (page - 1) * productsPerPage;
    const end = start + productsPerPage;
    const pageProducts = products.slice(start, end);

    pageProducts.forEach((product) => {
        const card = document.createElement('div');
        card.className = 'product-card';
        // Khung card linh hoạt theo chiều cao ảnh
        card.style.cssText = 'display: flex; flex-direction: column; cursor: pointer; background: #fff; padding-bottom: 15px; border: 1px solid #eee; margin-bottom: 15px; transition: transform 0.2s;';

        const badgeHTML = product.discountPercent > 0 
            ? `<div class="product-badge">-${product.discountPercent}%</div>` 
            : '';

        const oldPriceHTML = product.oldPrice 
            ? `<span style="text-decoration: line-through; color: #888; font-size: 13px; margin-left: 6px;">${formatPrice(product.oldPrice)}</span>` 
            : '';

        card.innerHTML = `
            <div class="product-image" style="width: 100%; position: relative; background: #f9f9f9;">
                ${badgeHTML}
                <!-- object-fit: contain giúp hiển thị TRỌN VẸN 100% TẤM ẢNH không bị che cắt -->
                <img src="${product.image}" 
                     alt="${product.name}"
                     style="width: 100%; height: auto; display: block; object-fit: contain;"
                     onerror="this.onerror=null; this.src='${BASE_URL}img/banner1.jpg';">
            </div>
            <div class="product-info" style="padding: 12px 10px 0 10px;">
                <div class="product-name" style="font-weight: 600; font-size: 14px; color: #333; margin-bottom: 6px; text-align: left; line-height: 1.4;">
                    ${product.name}
                </div>
                <div class="product-price ${product.discountPercent > 0 ? 'sale' : ''}" style="color: #d9534f; font-weight: bold; font-size: 15px; text-align: left;">
                    ${formatPrice(product.price)} ${oldPriceHTML}
                </div>
            </div>
        `;

        // BẤM VÀO SẢN PHẨM SẼ CHUYỂN SANG TRANG CHI TIẾT
        card.addEventListener('click', function() {
            window.location.href = '<?= BASE_URL_SITE ?>index_shop.php?ctrl=product&act=detail&id=' + product.id;
        });

        grid.appendChild(card);
    });
    // Biến lưu trữ toàn bộ sản phẩm gốc từ CSDL
const allProducts = <?= json_encode($products ?? []) ?>;
let filteredProducts = [...allProducts];

// Hàm lọc sản phẩm khi tick/bỏ tick ô Checkbox
function filterProductsByCheckbox() {
    // Lấy tất cả các từ khóa từ những ô đang được TICK
    const selectedKeywords = Array.from(document.querySelectorAll('.filter-cb:checked'))
                                  .map(cb => cb.getAttribute('data-name').toLowerCase());

    if (selectedKeywords.length === 0) {
        // Nếu KHÔNG tích ô nào -> Hiển thị tất cả sản phẩm
        filteredProducts = [...allProducts];
    } else {
        // Nếu CÓ tích ô -> Lọc các sản phẩm có tên hoặc danh mục chứa từ khóa đó
        filteredProducts = allProducts.filter(item => {
            const productName = (item.ten_san_pham || item.ten || '').toLowerCase();
            const categoryName = (item.ten_danh_muc || '').toLowerCase();

            return selectedKeywords.some(key => productName.includes(key) || categoryName.includes(key));
        });
    }

    // Cập nhật lại mảng dữ liệu hiển thị và vẽ lại giao diện
    products = filteredProducts;
    goToPage(1); // Quay về trang 1
}

// Bắt sự kiện mỗi khi bấm TICK hoặc BỎ TICK ô checkbox bất kỳ
document.querySelectorAll('.filter-cb').forEach(checkbox => {
    checkbox.addEventListener('change', filterProductsByCheckbox);
});
}
</script>

<?php
// Tải phần Footer
include_once 'footer.php'; 
?>