-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2026 at 08:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canifashop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bien_the_san_pham`
--

CREATE TABLE `bien_the_san_pham` (
  `id` int NOT NULL,
  `kich_co` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `gia` decimal(10,2) NOT NULL,
  `so_luong_ton` int NOT NULL DEFAULT '0',
  `san_pham_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `bien_the_san_pham`
--

INSERT INTO `bien_the_san_pham` (`id`, `kich_co`, `gia`, `so_luong_ton`, `san_pham_id`) VALUES
(1, 'S', 140000.00, 50, 1),
(2, 'M', 150000.00, 75, 1),
(3, 'L', 160000.00, 60, 1),
(4, 'S', 310000.00, 30, 2),
(5, 'M', 320000.00, 45, 2),
(6, 'L', 330000.00, 35, 2),
(7, 'S', 430000.00, 20, 3),
(8, 'M', 450000.00, 30, 3),
(9, 'L', 470000.00, 25, 3),
(10, 'S', 560000.00, 15, 4),
(11, 'M', 580000.00, 25, 4),
(12, 'L', 600000.00, 18, 4),
(13, 'S', 270000.00, 40, 5),
(14, 'M', 280000.00, 60, 5),
(15, 'L', 290000.00, 50, 5),
(16, 'S', 370000.00, 25, 6),
(17, 'M', 390000.00, 35, 6),
(18, 'L', 410000.00, 28, 6),
(19, 'S', 115000.00, 70, 7),
(20, 'M', 120000.00, 90, 7),
(21, 'L', 125000.00, 80, 7),
(22, 'S', 200000.00, 45, 8),
(23, 'M', 210000.00, 55, 8),
(24, 'L', 220000.00, 48, 8),
(25, 'S', 330000.00, 30, 9),
(26, 'M', 340000.00, 40, 9),
(27, 'L', 350000.00, 32, 9),
(28, 'S', 185000.00, 50, 10),
(29, 'M', 190000.00, 60, 10),
(30, 'L', 195000.00, 45, 10),
(31, 'S', 400000.00, 20, 11),
(32, 'M', 410000.00, 30, 11),
(33, 'L', 420000.00, 25, 11),
(34, 'S', 290000.00, 35, 12),
(35, 'M', 300000.00, 50, 12),
(36, 'L', 310000.00, 40, 12),
(37, 'S', 480000.00, 10, 13),
(38, 'M', 490000.00, 18, 13),
(39, 'L', 500000.00, 15, 13),
(40, 'S', 240000.00, 22, 14),
(41, 'M', 250000.00, 32, 14),
(42, 'L', 260000.00, 28, 14),
(43, 'M', 175000.00, 65, 15),
(44, 'L', 180000.00, 80, 15),
(45, 'XL', 185000.00, 70, 15),
(46, '28', 410000.00, 40, 16),
(47, '30', 420000.00, 55, 16),
(48, '32', 430000.00, 48, 16),
(49, '29', 370000.00, 35, 17),
(50, '31', 380000.00, 45, 17),
(51, '33', 390000.00, 38, 17),
(52, 'S', 155000.00, 60, 18),
(53, 'M', 160000.00, 80, 18),
(54, 'L', 165000.00, 70, 18),
(55, '30', 440000.00, 25, 19),
(56, '32', 450000.00, 35, 19),
(57, '34', 460000.00, 28, 19),
(58, 'S', 280000.00, 40, 20),
(59, 'M', 290000.00, 55, 20),
(60, 'L', 300000.00, 45, 20),
(61, '27', 400000.00, 30, 21),
(62, '29', 410000.00, 40, 21),
(63, '31', 420000.00, 35, 21),
(64, 'S', 215000.00, 50, 22),
(65, 'M', 220000.00, 70, 22),
(66, 'L', 225000.00, 60, 22),
(67, '30', 240000.00, 30, 23),
(68, '32', 250000.00, 40, 23),
(69, '34', 260000.00, 35, 23),
(70, 'S', 320000.00, 25, 24),
(71, 'M', 330000.00, 35, 24),
(72, 'L', 340000.00, 28, 24),
(73, '31', 470000.00, 20, 25),
(74, '33', 480000.00, 30, 25),
(75, '35', 490000.00, 22, 25),
(76, 'S', 185000.00, 50, 26),
(77, 'M', 190000.00, 65, 26),
(78, 'L', 195000.00, 55, 26),
(79, 'M', 350000.00, 30, 27),
(80, 'L', 360000.00, 40, 27),
(81, 'XL', 370000.00, 35, 27),
(82, '28', 420000.00, 25, 28),
(83, '30', 430000.00, 35, 28),
(84, '32', 440000.00, 28, 28),
(85, 'S', 300000.00, 40, 29),
(86, 'M', 310000.00, 50, 29),
(87, 'L', 320000.00, 45, 29),
(88, '29', 390000.00, 35, 30),
(89, '31', 400000.00, 45, 30),
(90, '33', 410000.00, 40, 30);

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id` int NOT NULL,
  `san_pham_id` int DEFAULT NULL,
  `nguoi_dung_id` int DEFAULT NULL,
  `noi_dung` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `binh_luan`
--

INSERT INTO `binh_luan` (`id`, `san_pham_id`, `nguoi_dung_id`, `noi_dung`, `ngay_tao`) VALUES
(1, 1, 2, 'Áo thun mặc rất mát, form đẹp, sẽ ủng hộ shop tiếp!', '2025-11-12 11:20:05'),
(2, 2, 3, 'Sơ mi vải dày dặn, đứng form, xứng đáng với giá tiền.', '2025-11-12 11:20:05'),
(3, 16, 4, 'Quần jeans mặc thoải mái, ống suông đúng ý, 5 sao!', '2025-11-12 11:20:05'),
(4, 5, 5, 'Áo polo mặc đi chơi hay đi làm đều được, chất liệu co giãn tốt.', '2025-11-12 11:20:05'),
(5, 19, 6, 'Quần âu mặc vào rất lịch sự, không bị nhăn, giao hàng nhanh.', '2025-11-12 11:20:05'),
(6, 22, 7, 'Quần legging tập gym cực kỳ ôm và nâng dáng, không bị lộ.', '2025-11-12 11:20:05'),
(7, 11, 8, 'Cardigan màu xinh, hợp với tiết trời se lạnh.', '2025-11-12 11:20:05'),
(8, 20, 9, 'Quần jogger mềm, mua về mặc ở nhà rất thích.', '2025-11-12 11:20:05'),
(9, 3, 10, 'Áo hoodie hơi mỏng so với mình tưởng tượng, nhưng màu đẹp.', '2025-11-12 11:20:05'),
(10, 4, 1, 'Khoác bomber form hơi rộng, nên lùi size.', '2025-11-12 11:20:05'),
(11, 17, 2, 'Quần kaki chất vải hơi cứng, giặt lần đầu thấy đỡ hơn.', '2025-11-12 11:20:05'),
(12, 28, 3, 'Jeans rách gối đẹp nhưng giao hàng hơi lâu.', '2025-11-12 11:20:05'),
(13, 6, 4, 'Áo len không lỗi gì, nhưng màu be hơi khác so với ảnh.', '2025-11-12 11:20:05'),
(14, 10, 5, 'Croptop khá ok, có điều đường may chưa thật sự tỉ mỉ.', '2025-11-12 11:20:05'),
(15, 14, 6, 'T-shirt local brand thiết kế độc đáo, nhưng giá hơi cao.', '2025-11-12 11:20:05'),
(16, 26, 7, 'Quần short đi biển màu sắc tươi tắn, nhưng chất liệu dễ nhăn.', '2025-11-12 11:20:05'),
(17, 1, 8, 'Mua lần thứ hai, vẫn rất hài lòng về chất lượng áo thun.', '2025-11-12 11:20:05'),
(18, 5, 9, 'Áo polo đúng size M, màu xanh lá rất đẹp.', '2025-11-12 11:20:05'),
(19, 16, 10, 'Jeans suông phối với áo thun rất chuẩn phong cách.', '2025-11-12 11:20:05'),
(20, 19, 1, 'Quần âu form slim fit, rất tôn dáng.', '2025-11-12 11:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int NOT NULL,
  `don_hang_id` int DEFAULT NULL,
  `san_pham_id` int DEFAULT NULL,
  `bien_the_id` int DEFAULT NULL,
  `mau_sac_id` int DEFAULT NULL,
  `so_luong` int NOT NULL,
  `gia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int NOT NULL,
  `san_pham_id` int DEFAULT NULL,
  `nguoi_dung_id` int DEFAULT NULL,
  `diem_danh_gia` int DEFAULT NULL,
  `noi_dung_danh_gia` text COLLATE utf8mb3_unicode_ci,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `danh_gia`
--

INSERT INTO `danh_gia` (`id`, `san_pham_id`, `nguoi_dung_id`, `diem_danh_gia`, `noi_dung_danh_gia`, `ngay_tao`) VALUES
(1, 1, 2, 5, 'Chất liệu áo thun tuyệt vời, giặt không bai xù. Rất hài lòng.', '2025-11-12 11:20:31'),
(2, 5, 3, 5, 'Áo polo mặc đi tập rất thoải mái, thấm hút mồ hôi nhanh.', '2025-11-12 11:20:31'),
(3, 16, 4, 5, 'Quần jeans form đẹp, đúng size, giao hàng đóng gói cẩn thận.', '2025-11-12 11:20:31'),
(4, 19, 5, 5, 'Quần âu mặc lên đứng dáng, không cần là ủi nhiều, tiện lợi.', '2025-11-12 11:20:31'),
(5, 22, 6, 5, 'Legging co giãn tốt, không bị tuột cạp khi tập yoga.', '2025-11-12 11:20:31'),
(6, 8, 7, 5, 'Áo thun họa tiết retro rất cá tính, màu sắc y hình.', '2025-11-12 11:20:31'),
(7, 1, 8, 4, 'Áo basic ổn, nhưng giao hàng hơi chậm hơn dự kiến 1 ngày.', '2025-11-12 11:20:31'),
(8, 2, 9, 4, 'Sơ mi ổn, nhưng phần cổ áo hơi cứng một chút.', '2025-11-12 11:20:31'),
(9, 17, 10, 4, 'Quần kaki chất lượng, nhưng đường may ở túi quần chưa hoàn hảo.', '2025-11-12 11:20:31'),
(10, 3, 1, 4, 'Áo hoodie đẹp, nhưng lớp nỉ bên trong chưa thật sự mềm mịn.', '2025-11-12 11:20:31'),
(11, 28, 2, 4, 'Jeans rách gối cá tính, nhưng nên có thêm màu khác.', '2025-11-12 11:20:31'),
(12, 4, 3, 3, 'Khoác bomber form hơi rộng so với mô tả, phải mang đi sửa.', '2025-11-12 11:20:31'),
(13, 10, 4, 3, 'Áo croptop mặc tạm được, nhưng vải hơi mỏng, không đáng với giá này.', '2025-11-12 11:20:31'),
(14, 6, 5, 2, 'Áo len bị xù lông nhẹ sau lần giặt đầu tiên, thất vọng.', '2025-11-12 11:20:31'),
(15, 13, 6, 1, 'Áo gió bị rách một đoạn nhỏ ở tay áo, cần kiểm tra kỹ hơn trước khi gửi.', '2025-11-12 11:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc`
--

CREATE TABLE `danh_muc` (
  `id` int NOT NULL,
  `ten_danh_muc` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `danh_muc`
--

INSERT INTO `danh_muc` (`id`, `ten_danh_muc`, `hinh_anh`, `mo_ta`) VALUES
(1, 'Áo', 'https://example.com/images/ao.jpg', 'Các loại áo thun, sơ mi, khoác.'),
(2, 'Quần', 'https://example.com/images/quan.jpg', 'Các loại quần jeans, kaki, short.');

-- --------------------------------------------------------

--
-- Table structure for table `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int NOT NULL,
  `tong_tien` decimal(10,2) NOT NULL,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP,
  `trang_thai_thanh_toan` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nguoi_dung_id` int DEFAULT NULL,
  `phuong_thuc_van_chuyen_id` int DEFAULT NULL,
  `phuong_thuc_thanh_toan_id` int DEFAULT NULL,
  `ma_giam_gia_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `don_hang`
--

INSERT INTO `don_hang` (`id`, `tong_tien`, `ngay_tao`, `trang_thai_thanh_toan`, `nguoi_dung_id`, `phuong_thuc_van_chuyen_id`, `phuong_thuc_thanh_toan_id`, `ma_giam_gia_id`) VALUES
(1, 780000.00, '2025-11-12 11:24:03', 'Đang giao', 2, 1, 3, 1),
(2, 550000.00, '2025-11-12 11:24:03', 'Chưa thanh toán', 3, 2, 1, NULL),
(3, 1200000.00, '2025-11-12 11:24:03', 'Đã thanh toán', 4, 3, 2, 4),
(4, 250000.00, '2025-11-12 11:24:03', 'Chưa thanh toán', 5, 1, 1, NULL),
(5, 980000.00, '2025-11-12 11:24:03', 'Đã thanh toán', 6, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mau_sac_san_pham`
--

CREATE TABLE `mau_sac_san_pham` (
  `id` int NOT NULL,
  `san_pham_id` int DEFAULT NULL,
  `ten_mau` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hinh_anh_mau` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `mau_sac_san_pham`
--

INSERT INTO `mau_sac_san_pham` (`id`, `san_pham_id`, `ten_mau`, `hinh_anh_mau`) VALUES
(1, 1, 'Trắng', 'https://example.com/color/sp1_trang.jpg'),
(2, 1, 'Đen', 'https://example.com/color/sp1_den.jpg'),
(3, 1, 'Xám', 'https://example.com/color/sp1_xam.jpg'),
(4, 2, 'Trắng', 'https://example.com/color/sp2_trang.jpg'),
(5, 2, 'Xanh Da Trời', 'https://example.com/color/sp2_xanh.jpg'),
(6, 3, 'Đen', 'https://example.com/color/sp3_den.jpg'),
(7, 3, 'Xám Tro', 'https://example.com/color/sp3_xam.jpg'),
(8, 4, 'Xanh Navy', 'https://example.com/color/sp4_navy.jpg'),
(9, 4, 'Đỏ Đô', 'https://example.com/color/sp4_do.jpg'),
(10, 5, 'Trắng', 'https://example.com/color/sp5_trang.jpg'),
(11, 5, 'Xanh Lá', 'https://example.com/color/sp5_xanhla.jpg'),
(12, 5, 'Đen', 'https://example.com/color/sp5_den.jpg'),
(13, 6, 'Be', 'https://example.com/color/sp6_be.jpg'),
(14, 6, 'Nâu', 'https://example.com/color/sp6_nau.jpg'),
(15, 7, 'Đen', 'https://example.com/color/sp7_den.jpg'),
(16, 7, 'Trắng', 'https://example.com/color/sp7_trang.jpg'),
(17, 8, 'Vàng Nhạt', 'https://example.com/color/sp8_vang.jpg'),
(18, 8, 'Xanh Mint', 'https://example.com/color/sp8_mint.jpg'),
(19, 9, 'Hồng Pastel', 'https://example.com/color/sp9_hong.jpg'),
(20, 9, 'Trắng Kem', 'https://example.com/color/sp9_trangkem.jpg'),
(21, 10, 'Đen', 'https://example.com/color/sp10_den.jpg'),
(22, 10, 'Trắng', 'https://example.com/color/sp10_trang.jpg'),
(23, 11, 'Xanh Rêu', 'https://example.com/color/sp11_reu.jpg'),
(24, 11, 'Ghi', 'https://example.com/color/sp11_ghi.jpg'),
(25, 12, 'Kẻ Xanh Trắng', 'https://example.com/color/sp12_kesoc.jpg'),
(26, 13, 'Xanh Đậm', 'https://example.com/color/sp13_xanhdam.jpg'),
(27, 13, 'Đen', 'https://example.com/color/sp13_den.jpg'),
(28, 14, 'Kem', 'https://example.com/color/sp14_kem.jpg'),
(29, 14, 'Đen', 'https://example.com/color/sp14_den.jpg'),
(30, 15, 'Xám', 'https://example.com/color/sp15_xam.jpg'),
(31, 15, 'Nâu Đất', 'https://example.com/color/sp15_nau.jpg'),
(32, 16, 'Xanh Nhạt', 'https://example.com/color/sp16_xnhan.jpg'),
(33, 17, 'Kem', 'https://example.com/color/sp17_kem.jpg'),
(34, 17, 'Be', 'https://example.com/color/sp17_be.jpg'),
(35, 18, 'Đen', 'https://example.com/color/sp18_den.jpg'),
(36, 18, 'Ghi Sáng', 'https://example.com/color/sp18_ghi.jpg'),
(37, 19, 'Đen', 'https://example.com/color/sp19_den.jpg'),
(38, 19, 'Xanh Than', 'https://example.com/color/sp19_xanhthan.jpg'),
(39, 20, 'Xám', 'https://example.com/color/sp20_xam.jpg'),
(40, 20, 'Đen', 'https://example.com/color/sp20_den.jpg'),
(41, 21, 'Đen', 'https://example.com/color/sp21_den.jpg'),
(42, 22, 'Tím Than', 'https://example.com/color/sp22_tim.jpg'),
(43, 22, 'Xám', 'https://example.com/color/sp22_xam.jpg'),
(44, 23, 'Xanh Lính', 'https://example.com/color/sp23_linh.jpg'),
(45, 23, 'Vàng Cát', 'https://example.com/color/sp23_cat.jpg'),
(46, 24, 'Nâu Socola', 'https://example.com/color/sp24_nau.jpg'),
(47, 24, 'Trắng', 'https://example.com/color/sp24_trang.jpg'),
(48, 25, 'Xám Caro', 'https://example.com/color/sp25_caro.jpg'),
(49, 26, 'Họa Tiết Cam', 'https://example.com/color/sp26_hoatiet.jpg'),
(50, 27, 'Xám Đậm', 'https://example.com/color/sp27_xam.jpg'),
(51, 27, 'Be', 'https://example.com/color/sp27_be.jpg'),
(52, 28, 'Xanh Đen', 'https://example.com/color/sp28_xden.jpg'),
(53, 29, 'Trắng Ngà', 'https://example.com/color/sp29_trang.jpg'),
(54, 29, 'Đen', 'https://example.com/color/sp29_den.jpg'),
(55, 30, 'Xanh Đậm', 'https://example.com/color/sp30_xanhdam.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ma_giam_gia`
--

CREATE TABLE `ma_giam_gia` (
  `id` int NOT NULL,
  `ma` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `phan_tram_giam` int DEFAULT NULL,
  `trang_thai` enum('hoat_dong','ngung_hoat_dong') COLLATE utf8mb3_unicode_ci DEFAULT 'hoat_dong',
  `don_hang_toi_thieu` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `ma_giam_gia`
--

INSERT INTO `ma_giam_gia` (`id`, `ma`, `ngay_bat_dau`, `ngay_ket_thuc`, `phan_tram_giam`, `trang_thai`, `don_hang_toi_thieu`) VALUES
(1, 'SALE15', '2025-11-01', '2025-12-31', 15, 'hoat_dong', 0.00),
(2, 'VIP20', '2025-11-10', '2025-11-30', 20, 'hoat_dong', 500000.00),
(3, 'OLDCOUPON', '2025-09-01', '2025-10-31', 10, 'ngung_hoat_dong', 100000.00),
(4, 'BIG30', '2025-11-12', '2025-12-12', 30, 'hoat_dong', 1000000.00),
(5, 'QUICK5', '2025-11-01', '2025-11-15', 5, 'hoat_dong', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mat_khau` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `dia_chi` text COLLATE utf8mb3_unicode_ci,
  `so_dien_thoai` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vai_tro` enum('admin','khach_hang') COLLATE utf8mb3_unicode_ci DEFAULT 'khach_hang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `dia_chi`, `so_dien_thoai`, `vai_tro`) VALUES
(1, 'Quản Trị Viên', 'admin@shop.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Hà Nội', '0901000111', 'admin'),
(2, 'Nguyễn Văn A', 'vana@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'TP Hồ Chí Minh', '0902000222', 'khach_hang'),
(3, 'Trần Thị B', 'thib@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Đà Nẵng', '0903000333', 'khach_hang'),
(4, 'Lê Hoàng C', 'hoangc@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Hải Phòng', '0904000444', 'khach_hang'),
(5, 'Phạm Thu D', 'thud@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Cần Thơ', '0905000555', 'khach_hang'),
(6, 'Võ Minh E', 'minhe@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Huế', '0906000666', 'khach_hang'),
(7, 'Đặng Quốc F', 'quocf@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Nha Trang', '0907000777', 'khach_hang'),
(8, 'Bùi Tố G', 'tog@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Biên Hòa', '0908000888', 'khach_hang'),
(9, 'Hồ Anh H', 'anhh@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Vũng Tàu', '0909000999', 'khach_hang'),
(10, 'Mai Kim I', 'kimi@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Bình Dương', '0910001000', 'khach_hang');

-- --------------------------------------------------------

--
-- Table structure for table `phuong_thuc_thanh_toan`
--

CREATE TABLE `phuong_thuc_thanh_toan` (
  `id` int NOT NULL,
  `ten_phuong_thuc` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `phuong_thuc_thanh_toan`
--

INSERT INTO `phuong_thuc_thanh_toan` (`id`, `ten_phuong_thuc`, `mo_ta`) VALUES
(1, 'Thanh Toán Khi Nhận Hàng (COD)', 'Thanh toán tiền mặt cho nhân viên giao hàng.'),
(2, 'Chuyển Khoản Ngân Hàng', 'Thanh toán qua tài khoản ngân hàng của cửa hàng.'),
(3, 'Ví Điện Tử', 'Thanh toán qua Momo, ZaloPay, hoặc VNPay.');

-- --------------------------------------------------------

--
-- Table structure for table `phuong_thuc_van_chuyen`
--

CREATE TABLE `phuong_thuc_van_chuyen` (
  `id` int NOT NULL,
  `ten_phuong_thuc` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phi_van_chuyen` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mo_ta` text COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `phuong_thuc_van_chuyen`
--

INSERT INTO `phuong_thuc_van_chuyen` (`id`, `ten_phuong_thuc`, `phi_van_chuyen`, `mo_ta`) VALUES
(1, 'Giao Hàng Tiêu Chuẩn', 30000.00, 'Thời gian giao hàng từ 3-5 ngày làm việc.'),
(2, 'Giao Hàng Nhanh', 55000.00, 'Thời gian giao hàng từ 1-2 ngày làm việc.'),
(3, 'Tự Lấy Hàng', 0.00, 'Khách hàng tự đến kho lấy hàng.');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int NOT NULL,
  `ten_san_pham` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb3_unicode_ci,
  `trang_thai` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `danh_muc_id` int DEFAULT NULL,
  `da_ban` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`id`, `ten_san_pham`, `hinh_anh`, `mo_ta`, `trang_thai`, `danh_muc_id`, `da_ban`) VALUES
(1, 'Áo Thun Cổ Tròn Basic', 'Áo Thun Cổ Tròn Basic.webp', 'Áo thun cotton 100%, thoáng mát, phù hợp hàng ngày.', 'còn hàng', 1, 50),
(2, 'Áo Sơ Mi Oxford Trắng', 'ao_so_mi(2).webp', 'Sơ mi dài tay vải Oxford cao cấp, lịch sự.', 'còn hàng', 1, 100),
(3, 'Áo Hoodie Nỉ Bông Đen', 'ao_so_mi(3).webp', 'Chất liệu nỉ bông dày dặn, giữ ấm tốt.', 'còn hàng', 1, 69),
(4, 'Áo Khoác Bomber Xanh Navy', 'ao_so_mi(4).webp', 'Khoác ngoài phong cách Bomber, chống gió nhẹ.', 'còn hàng', 1, 33),
(5, 'Áo Polo Thể Thao', 'ao_so_mi(5).webp', 'Áo Polo vải cá sấu co giãn 4 chiều.', 'còn hàng', 1, 41),
(6, 'Áo Len Cổ Lọ Màu Be', 'ao_so_mi(6).webp', 'Áo len dệt kim, phong cách Hàn Quốc.', 'còn hàng', 1, 95),
(7, 'Áo Ba Lỗ Tập Gym', 'ao_so_mi(7).webp', 'Chất liệu thun lạnh, siêu thấm hút mồ hôi.', 'còn hàng', 1, 71),
(8, 'Áo Thun In Họa Tiết Retro', 'ao_so_mi(8).webp', 'Áo thun in họa tiết đồ họa cổ điển.', 'còn hàng', 1, 60),
(9, 'Áo Blouse Nữ Công Sở', 'ao_so_mi(9).webp', 'Áo kiểu nữ tính, phù hợp môi trường công sở.', 'còn hàng', 1, 77),
(10, 'Áo Croptop Tay Dài', 'ao_so_mi(10).webp', 'Thiết kế trẻ trung, tôn dáng.', 'còn hàng', 1, 14),
(11, 'Áo Cardigan Dệt Kim', 'ao_so_mi(11).webp', 'Khoác ngoài nhẹ, chất liệu dệt kim mỏng.', 'còn hàng', 1, 10),
(12, 'Áo Sơ Mi Kẻ Sọc Xanh', 'ao_so_mi(12).webp', 'Sơ mi kẻ sọc thời trang, chất vải cotton.', 'còn hàng', 1, 92),
(13, 'Áo Gió Hai Lớp', 'ao_so_mi(13).webp', 'Áo khoác gió có mũ, chống nước nhẹ.', 'còn hàng', 1, 57),
(14, 'Áo T-shirt Local Brand XYZ', 'ao_so_mi(14).webp', 'Thiết kế độc quyền, phiên bản giới hạn.', 'còn hàng', 1, 90),
(15, 'Áo Thun Oversize Xám', 'ao_so_mi(15).webp', 'Form áo rộng rãi, phong cách street wear.', 'còn hàng', 1, 85),
(16, 'Quần Jeans Dáng Suông Xanh Nhạt', 'Quần Jeans Dáng Suông Xanh Nhạt.png', 'Jeans denim 100%, không co giãn, ống suông.', 'còn hàng', 2, 57),
(17, 'Quần Kaki Ống Đứng Màu Kem', 'Quần Kaki Ống Đứng Màu Kem.png', 'Chất liệu Kaki dày dặn, phong cách công sở.', 'còn hàng', 2, 21),
(18, 'Quần Short Thể Thao 2 Lớp', 'ao_so_mi(18).webp', 'Quần short tập luyện, có lớp lót bên trong.', 'còn hàng', 2, 16),
(19, 'Quần Âu Công Sở Đen', 'ao_so_mi(19).webp', 'Quần tây chất liệu cao cấp, chống nhăn.', 'còn hàng', 2, 98),
(20, 'Quần Jogger Thun Gân', 'ao_so_mi(20).webp', 'Quần jogger bo gấu, thoải mái vận động.', 'còn hàng', 2, 70),
(21, 'Quần Baggy Jeans Đen', 'ao_so_mi(21).webp', 'Kiểu dáng Baggy trẻ trung, dễ phối đồ.', 'còn hàng', 2, 47),
(22, 'Quần Legging Yoga Nữ', 'ao_so_mi(22).webp', 'Legging cạp cao, co giãn tối đa cho tập Yoga.', 'còn hàng', 2, 12),
(23, 'Quần Short Kaki Lính', 'ao_so_mi(23).webp', 'Quần short chất liệu kaki, phong cách quân đội.', 'còn hàng', 2, 95),
(24, 'Quần Culottes Vải Lụa', 'ao_so_mi(24).webp', 'Quần ống rộng lửng, chất vải lụa mềm mại.', 'còn hàng', 2, 64),
(25, 'Quần Tây Xám Caro', 'ao_so_mi(25).webp', 'Quần tây có họa tiết caro chìm, hiện đại.', 'còn hàng', 2, 25),
(26, 'Quần Short Đi Biển Họa Tiết', 'ao_so_mi(26).webp', 'Quần đùi đi biển, chất liệu nhanh khô, họa tiết nổi bật.', 'còn hàng', 2, 14),
(27, 'Quần Nỉ Bo Gấu Mùa Đông', 'ao_so_mi(27).webp', 'Quần chất liệu nỉ dày, giữ ấm tốt.', 'còn hàng', 2, 76),
(28, 'Quần Jeans Rách Gối Cá Tính', 'ao_so_mi(28).webp', 'Quần Jeans có chi tiết rách gối, phong cách đường phố.', 'còn hàng', 2, 58),
(29, 'Quần Ống Rộng Linen', 'ao_so_mi(29).webp', 'Quần vải Linen mát mẻ, ống rộng thoải mái.', 'còn hàng', 2, 52),
(30, 'Quần Jeans Ống Đứng Cổ Điển', 'ao_so_mi(30).webp', 'Jeans màu xanh đậm, form ống đứng cổ điển.', 'còn hàng', 2, 78);

-- --------------------------------------------------------

--
-- Table structure for table `san_pham_yeu_thich`
--

CREATE TABLE `san_pham_yeu_thich` (
  `san_pham_id` int NOT NULL,
  `nguoi_dung_id` int NOT NULL,
  `ngay_tao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `san_pham_yeu_thich`
--

INSERT INTO `san_pham_yeu_thich` (`san_pham_id`, `nguoi_dung_id`, `ngay_tao`) VALUES
(1, 2, '2025-11-12 11:22:02'),
(1, 5, '2025-11-12 11:22:02'),
(2, 8, '2025-11-12 11:22:02'),
(4, 9, '2025-11-12 11:22:02'),
(5, 3, '2025-11-12 11:22:02'),
(8, 6, '2025-11-12 11:22:02'),
(13, 10, '2025-11-12 11:22:02'),
(16, 2, '2025-11-12 11:22:02'),
(19, 7, '2025-11-12 11:22:02'),
(22, 4, '2025-11-12 11:22:02'),
(27, 9, '2025-11-12 11:22:02'),
(30, 5, '2025-11-12 11:22:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bien_the_san_pham`
--
ALTER TABLE `bien_the_san_pham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `san_pham_id` (`san_pham_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Indexes for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `don_hang_id` (`don_hang_id`),
  ADD KEY `bien_the_id` (`bien_the_id`);

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `san_pham_id` (`san_pham_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Indexes for table `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_hang_id` (`nguoi_dung_id`),
  ADD KEY `phuong_thuc_van_chuyen_id` (`phuong_thuc_van_chuyen_id`),
  ADD KEY `phuong_thuc_thanh_toan_id` (`phuong_thuc_thanh_toan_id`),
  ADD KEY `ma_giam_gia_id` (`ma_giam_gia_id`);

--
-- Indexes for table `mau_sac_san_pham`
--
ALTER TABLE `mau_sac_san_pham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Indexes for table `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma` (`ma`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `phuong_thuc_thanh_toan`
--
ALTER TABLE `phuong_thuc_thanh_toan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phuong_thuc_van_chuyen`
--
ALTER TABLE `phuong_thuc_van_chuyen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `danh_muc_id` (`danh_muc_id`);

--
-- Indexes for table `san_pham_yeu_thich`
--
ALTER TABLE `san_pham_yeu_thich`
  ADD PRIMARY KEY (`san_pham_id`,`nguoi_dung_id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bien_the_san_pham`
--
ALTER TABLE `bien_the_san_pham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mau_sac_san_pham`
--
ALTER TABLE `mau_sac_san_pham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `phuong_thuc_thanh_toan`
--
ALTER TABLE `phuong_thuc_thanh_toan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phuong_thuc_van_chuyen`
--
ALTER TABLE `phuong_thuc_van_chuyen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bien_the_san_pham`
--
ALTER TABLE `bien_the_san_pham`
  ADD CONSTRAINT `bien_the_san_pham_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`),
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`bien_the_id`) REFERENCES `bien_the_san_pham` (`id`);

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Constraints for table `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`phuong_thuc_van_chuyen_id`) REFERENCES `phuong_thuc_van_chuyen` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_3` FOREIGN KEY (`phuong_thuc_thanh_toan_id`) REFERENCES `phuong_thuc_thanh_toan` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_4` FOREIGN KEY (`ma_giam_gia_id`) REFERENCES `ma_giam_gia` (`id`);

--
-- Constraints for table `mau_sac_san_pham`
--
ALTER TABLE `mau_sac_san_pham`
  ADD CONSTRAINT `mau_sac_san_pham_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc` (`id`);

--
-- Constraints for table `san_pham_yeu_thich`
--
ALTER TABLE `san_pham_yeu_thich`
  ADD CONSTRAINT `san_pham_yeu_thich_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `san_pham_yeu_thich_ibfk_2` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
