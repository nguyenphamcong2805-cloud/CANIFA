<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - CANIFA</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Arial,sans-serif;background:#f5f5f5;color:#333;}
.admin-wrap{display:flex;min-height:100vh;}
.sidebar{width:240px;background:#1a1d2e;color:#fff;padding:20px 0;position:fixed;height:100vh;overflow-y:auto;z-index:100;}
.sidebar-logo{display:flex;align-items:center;gap:12px;padding:0 20px 28px;}
.sidebar-logo .logo-icon{width:38px;height:38px;background:#5b5fc7;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:bold;}
.sidebar-logo .logo-text{font-size:18px;font-weight:600;}
.sidebar nav a{display:flex;align-items:center;gap:12px;padding:11px 20px;margin:2px 10px;border-radius:8px;color:#ccc;text-decoration:none;font-size:14px;transition:background .2s,color .2s;}
.sidebar nav a:hover,.sidebar nav a.active{background:#5b5fc7;color:#fff;}
.sidebar nav a svg{width:18px;height:18px;fill:currentColor;flex-shrink:0;}
.sidebar-divider{border:none;border-top:1px solid rgba(255,255,255,0.1);margin:12px 20px;}
.admin-main{flex:1;margin-left:240px;padding:28px 36px;min-height:100vh;}
.admin-topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;background:#fff;padding:14px 20px;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.07);}
.admin-topbar .welcome{font-size:15px;color:#555;}
.admin-topbar .welcome b{color:#222;}
.btn-logout{padding:8px 18px;background:#e53935;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;text-decoration:none;}
.btn-logout:hover{background:#b71c1c;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:28px;}
.stat-card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.07);display:flex;justify-content:space-between;align-items:center;}
.stat-card .stat-val{font-size:24px;font-weight:700;margin-bottom:4px;}
.stat-card .stat-lbl{font-size:13px;color:#777;}
.card{background:#fff;padding:24px;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.07);margin-bottom:20px;}
.card h2{font-size:16px;margin-bottom:16px;}
table{width:100%;border-collapse:collapse;font-size:14px;}
table th{background:#f5f5f5;padding:11px 14px;text-align:left;font-size:12px;text-transform:uppercase;color:#555;}
table td{padding:11px 14px;border-bottom:1px solid #f0f0f0;vertical-align:middle;}
.btn-sm{padding:6px 14px;border-radius:5px;font-size:12px;font-weight:600;text-decoration:none;cursor:pointer;border:none;display:inline-block;margin:2px;}
.btn-edit{background:#e3f2fd;color:#1565c0;}
.btn-del{background:#fce4ec;color:#c62828;}
.btn-add{background:#5b5fc7;color:#fff;padding:9px 20px;border-radius:7px;text-decoration:none;font-size:13px;font-weight:600;display:inline-block;}
.form-admin label{display:block;margin-bottom:5px;font-weight:600;font-size:14px;}
.form-admin input,.form-admin select,.form-admin textarea{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:7px;font-size:14px;margin-bottom:16px;background:#fafafa;}
.form-admin textarea{min-height:100px;resize:vertical;}
.form-admin button[type=submit]{background:#5b5fc7;color:#fff;border:none;padding:11px 28px;border-radius:7px;font-size:15px;font-weight:700;cursor:pointer;}
.badge{padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;}
.badge-success{background:#e8f5e9;color:#2e7d32;}
.badge-info{background:#e3f2fd;color:#1565c0;}
.badge-warning{background:#fff3e0;color:#e65100;}
.badge-danger{background:#fce4ec;color:#c62828;}
.badge-secondary{background:#f5f5f5;color:#555;}
.order-container{padding:0;}
.filter-box{background:#fff;padding:18px 20px;border-radius:10px;margin-bottom:20px;}
.filter-grid{display:flex;gap:16px;flex-wrap:wrap;align-items:flex-end;}
.filter-group label{display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:5px;}
.filter-group select{padding:8px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px;}
.filter-buttons{display:flex;gap:8px;}
.btn-filter{padding:8px 18px;background:#5b5fc7;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;}
.btn-reset{padding:8px 18px;background:#eee;color:#333;border-radius:6px;text-decoration:none;font-size:13px;}
.table-container{background:#fff;border-radius:10px;overflow:hidden;}
.order-table{width:100%;border-collapse:collapse;font-size:14px;}
.order-table th{background:#f5f5f5;padding:12px 14px;text-align:left;font-size:12px;text-transform:uppercase;color:#666;}
.order-table td{padding:12px 14px;border-bottom:1px solid #f5f5f5;}
.order-table td.center{text-align:center;}
.empty-text{text-align:center;padding:40px;color:#999;}
</style>
</head>
<body>
<div class="admin-wrap">
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">A</div>
        <div class="logo-text">Admin</div>
    </div>
    <nav>
        <a href="index_admin.php?page=home">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Tổng quan
        </a>
        <a href="index_admin.php?page=product">
            <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm11 15H4v-2h16v2zm0-5H4V8h5.08L7 10.83 8.62 12 11 8.76l1-1.36 1 1.36L15.38 12 17 10.83 14.92 8H20v6z"/></svg>
            Sản phẩm
        </a>
        <a href="index_admin.php?page=order_list">
            <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96C7 13.1 7.9 14 9 14h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 20 2H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            Đơn hàng    
        </a>
        <a href="index_admin.php?page=users">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Người dùng
        </a>
        <a href="index_admin.php?page=category">
            <svg viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zm0-10v2h14V7H7z"/></svg>
            Danh mục
        <hr class="sidebar-divider">
        <a href="index_shop.php?ctrl=home&act=index">
            <svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Về trang shop
        </a>
        
    </nav>
</aside>
<div class="admin-main">
    <div class="admin-topbar">
        <div class="welcome">Xin chao, <b><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin'); ?></b></div>
        <a class="btn-logout" href="index_shop.php?ctrl=user&act=logout">Đăng Xuất</a>
    </div>