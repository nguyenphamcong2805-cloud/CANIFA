<?php 
require_once __DIR__ . '/header.php';

$productCountByCategory = isset($productCountByCategory) && is_array($productCountByCategory) ? $productCountByCategory : [];
$topSellingProducts = isset($topSellingProducts) && is_array($topSellingProducts) ? $topSellingProducts : [];
?>

<style>
    .admin-dashboard {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
        font-family: Arial, sans-serif;
    }

    /* Grid Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    /* Thẻ Card */
    .dashboard-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #eef2f5;
        display: flex;
        flex-direction: column;
    }

    .dashboard-card h2 {
        font-size: 16px;
        font-weight: 700;
        color: #333333;
        margin-top: 0;
        margin-bottom: 15px;
        border-bottom: 2px solid #f0f3f6;
        padding-bottom: 10px;
    }

    /* ĐIỀU CHỈNH KÍCH THƯỚC KHUNG CHỨA CANVAS CHART */
    .chart-box {
        position: relative;
        width: 100%;
        height: 260px; /* Cố định chiều cao vừa vặn */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Thẻ Tổng sản phẩm */
    .stat-card {
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #ffffff;
    }

    .stat-card h2 {
        color: #ffffff;
        border-bottom-color: rgba(255, 255, 255, 0.2);
        width: 100%;
    }

    .stat-number {
        font-size: 48px;
        font-weight: 800;
        margin: 10px 0 0 0;
    }

    /* Card Quản lý nhanh */
    .manage-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .btn-link {
        display: inline-block;
        padding: 8px 14px;
        background-color: #f8f9fc;
        color: #4e73df !important;
        border: 1px solid #e3e6f0;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
    }

    .btn-link:hover {
        background-color: #4e73df;
        color: #ffffff !important;
        border-color: #4e73df;
    }
</style>

<div class="admin-dashboard">
    <!-- HÀNG 1: THỐNG KÊ & BIỂU ĐỒ -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h2>Thống kê sản phẩm theo danh mục</h2>
            <div class="chart-box">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card">
            <h2>Top sản phẩm bán chạy</h2>
            <div class="chart-box">
                <canvas id="topProductChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card stat-card">
            <h2>Tổng sản phẩm</h2>
            <p class="stat-number"><?= array_sum(array_column($productCountByCategory, 'count')) ?></p>
        </div>
    </div>

    <!-- HÀNG 2: PHÍM TẮT QUẢN LÝ -->
    <div class="dashboard-grid">
        <div class="dashboard-card manage-card">
            <h2>Quản lý sản phẩm</h2>
            <p>Thêm, sửa, xóa sản phẩm trong hệ thống</p>
            <p><a href="index_admin.php?page=product" class="btn-link">Mở quản lý sản phẩm &rarr;</a></p>
        </div>

        <div class="dashboard-card manage-card">
            <h2>Trạng thái đơn hàng</h2>
            <p>Xem trạng thái và chi tiết đơn hàng</p>
            <p><a href="index_admin.php?page=order_list" class="btn-link">Mở quản lý đơn hàng &rarr;</a></p>
        </div>

        <div class="dashboard-card manage-card">
            <h2>Quản lý khách hàng</h2>
            <p>Danh sách người dùng và phân quyền</p>
            <p><a href="index_admin.php?page=users" class="btn-link">Mở quản lý người dùng &rarr;</a></p>
        </div>

        <div class="dashboard-card manage-card">
            <h2>Báo cáo nhanh</h2>
            <p>Doanh thu, tổng số đơn hàng & sản phẩm</p>
            <p><span class="btn-link" style="opacity: 0.6; cursor: default;">Hệ thống tự động</span></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categoryLabels = <?= json_encode(array_column($productCountByCategory ?? [], 'category')) ?>;
    const categoryData = <?= json_encode(array_map('intval', array_column($productCountByCategory ?? [], 'count'))) ?>;
    const topProductLabels = <?= json_encode(array_column($topSellingProducts ?? [], 'ten_san_pham')) ?>;
    const topProductData = <?= json_encode(array_map(function($item) { return (int)$item['sold']; }, $topSellingProducts ?? [])) ?>;

    // 1. Biểu đồ tròn Danh mục
    const categoryChartCanvas = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryChartCanvas, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Số lượng sản phẩm',
                data: categoryData,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Bắt buộc false để đi theo height của .chart-box
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 15, font: { size: 12 } }
                }
            }
        }
    });

    // 2. Biểu đồ cột Top Sản Phẩm
    const topProductChartCanvas = document.getElementById('topProductChart').getContext('2d');
    new Chart(topProductChartCanvas, {
        type: 'bar',
        data: {
            labels: topProductLabels,
            datasets: [{
                label: 'Số lượng đã bán',
                data: topProductData,
                backgroundColor: 'rgba(78, 115, 223, 0.85)',
                borderColor: '#4e73df',
                borderWidth: 1,
                borderRadius: 4,
                maxBarThickness: 35 // Giới hạn độ rộng tối đa của cột không bị tràn
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Bắt buộc false để đi theo height của .chart-box
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 }
                },
                x: {
                    ticks: {
                        font: { size: 11 },
                        callback: function(val, index) {
                            // Cắt ngắn tên sản phẩm quá dài trên trục X
                            let label = this.getLabelForValue(val);
                            return label.length > 12 ? label.substr(0, 12) + '...' : label;
                        }
                    }
                }
            }
        }
    });
</script>

<?php 
require_once __DIR__ . '/footer.php';
?>