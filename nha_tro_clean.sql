-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- MÃ¡y chá»§: 127.0.0.1
-- Thá»i gian Ä‘Ã£ táº¡o: Th12 02, 2025 lÃºc 08:09 AM
-- PhiÃªn báº£n mÃ¡y phá»¥c vá»¥: 10.4.32-MariaDB
-- PhiÃªn báº£n PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- CÆ¡ sá»Ÿ dá»¯ liá»‡u: `nha_tro`
--

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `anh_bai_dang`
--

CREATE TABLE `anh_bai_dang` (
  `id` int(11) NOT NULL,
  `bai_dang_id` int(11) NOT NULL,
  `url` varchar(500) NOT NULL,
  `thu_tu` int(11) NOT NULL DEFAULT 0,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `anh_bai_dang`
--

INSERT INTO `anh_bai_dang` (`id`, `bai_dang_id`, `url`, `thu_tu`, `ngay_tao`) VALUES
(5, 4, 'bai_dang/1.jpg', 1, '2025-10-11 11:36:01'),
(17, 18, 'bai_dang/bai_dang_20251022_102739_68f8b19b5686a.jpg', 0, '2025-10-22 17:27:39'),
(25, 6, 'bai_dang/bai_dang_20251022_144734_68f8ee86729da.png', 0, '2025-10-22 21:47:34'),
(26, 3, 'bai_dang/bai_dang_20251022_150935_68f8f3afad90c.jpg', 0, '2025-10-22 22:09:35'),
(27, 2, 'bai_dang/bai_dang_20251022_152021_68f8f635f3621.png', 0, '2025-10-22 22:20:22'),
(28, 1, 'bai_dang/bai_dang_20251022_152052_68f8f65470783.png', 0, '2025-10-22 22:20:52'),
(29, 19, 'bai_dang/bai_dang_20251022_152235_68f8f6bb8e9f4.png', 0, '2025-10-22 22:22:35'),
(101, 101, 'bai_dang/1.jpg', 1, '2025-11-17 05:24:37'),
(102, 102, 'bai_dang/2.jpg', 1, '2025-11-17 05:24:37'),
(103, 103, 'bai_dang/3.jpg', 1, '2025-11-17 05:24:37'),
(104, 104, 'bai_dang/4.jpg', 1, '2025-11-17 05:24:37'),
(105, 105, 'bai_dang/5.jpg', 1, '2025-11-17 05:24:37'),
(106, 106, 'bai_dang/6.jpg', 1, '2025-11-17 05:24:37'),
(107, 107, 'bai_dang/7.jpg', 1, '2025-11-17 05:24:37'),
(108, 108, 'bai_dang/8.jpg', 1, '2025-11-17 05:24:37'),
(109, 109, 'bai_dang/9.jpg', 1, '2025-11-17 05:24:37'),
(110, 110, 'bai_dang/10.jpg', 1, '2025-11-17 05:24:37'),
(111, 111, 'bai_dang/11.jpg', 1, '2025-11-17 05:24:37'),
(112, 112, 'bai_dang/12.jpg', 1, '2025-11-17 05:24:37'),
(113, 113, 'bai_dang/13.jpg', 1, '2025-11-17 05:24:37'),
(114, 114, 'bai_dang/14.jpg', 1, '2025-11-17 05:24:37'),
(115, 115, 'bai_dang/15.jpg', 1, '2025-11-17 05:24:37'),
(116, 116, 'bai_dang/16.jpg', 1, '2025-11-17 05:24:37'),
(117, 117, 'bai_dang/17.jpg', 1, '2025-11-17 05:24:37'),
(118, 118, 'bai_dang/18.jpg', 1, '2025-11-17 05:24:37'),
(119, 119, 'bai_dang/19.jpg', 1, '2025-11-17 05:24:37'),
(120, 120, 'bai_dang/20.jpg', 1, '2025-11-17 05:24:37'),
(121, 121, 'bai_dang/21.jpg', 1, '2025-11-17 05:24:37'),
(122, 122, 'bai_dang/22.jpg', 1, '2025-11-17 05:24:37'),
(123, 123, 'bai_dang/23.jpg', 1, '2025-11-17 05:24:37'),
(124, 124, 'bai_dang/24.jpg', 1, '2025-11-17 05:24:37'),
(125, 125, 'bai_dang/25.jpg', 1, '2025-11-17 05:24:37'),
(126, 126, 'bai_dang/26.jpg', 1, '2025-11-17 05:24:37'),
(127, 127, 'bai_dang/27.jpg', 1, '2025-11-17 05:24:37'),
(128, 128, 'bai_dang/28.jpg', 1, '2025-11-17 05:24:37'),
(129, 129, 'bai_dang/29.jpg', 1, '2025-11-17 05:24:37'),
(130, 130, 'bai_dang/30.jpg', 1, '2025-11-17 05:24:37'),
(131, 131, 'bai_dang/31.jpg', 1, '2025-11-17 05:24:37'),
(132, 132, 'bai_dang/32.jpg', 1, '2025-11-17 05:24:37'),
(133, 133, 'bai_dang/33.jpg', 1, '2025-11-17 05:24:37'),
(134, 134, 'bai_dang/34.jpg', 1, '2025-11-17 05:24:37'),
(135, 135, 'bai_dang/35.jpg', 1, '2025-11-17 05:24:37'),
(136, 136, 'bai_dang/36.jpg', 1, '2025-11-17 05:24:37'),
(137, 137, 'bai_dang/37.jpg', 1, '2025-11-17 05:24:37'),
(138, 138, 'bai_dang/38.jpg', 1, '2025-11-17 05:24:37'),
(139, 139, 'bai_dang/39.jpg', 1, '2025-11-17 05:24:37'),
(140, 140, 'bai_dang/40.jpg', 1, '2025-11-17 05:24:37'),
(141, 141, 'bai_dang/41.jpg', 1, '2025-11-17 05:24:37'),
(142, 142, 'bai_dang/42.jpg', 1, '2025-11-17 05:24:37'),
(143, 143, 'bai_dang/43.jpg', 1, '2025-11-17 05:24:37'),
(144, 144, 'bai_dang/44.jpg', 1, '2025-11-17 05:24:37'),
(145, 145, 'bai_dang/45.jpg', 1, '2025-11-17 05:24:37'),
(146, 146, 'bai_dang/46.jpg', 1, '2025-11-17 05:24:37'),
(147, 147, 'bai_dang/47.jpg', 1, '2025-11-17 05:24:37'),
(148, 148, 'bai_dang/48.jpg', 1, '2025-11-17 05:24:37'),
(149, 149, 'bai_dang/49.jpg', 1, '2025-11-17 05:24:37'),
(150, 149, 'bai_dang/50.jpg', 2, '2025-11-17 05:24:37'),
(151, 150, 'bai_dang/bai_dang_20251119_132508_691dc534667be.jpg', 0, '2025-11-19 20:25:09'),
(153, 152, 'bai_dang/bai_dang_20251202_065839_692e8e1f199e0.png', 0, '2025-12-02 13:58:39');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `bai_dang`
--

CREATE TABLE `bai_dang` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `phong_id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `mo_ta` text NOT NULL,
  `gia_niem_yet` decimal(12,2) NOT NULL,
  `trang_thai` enum('nhap','cho_duyet','dang','an','tu_choi') NOT NULL DEFAULT 'cho_duyet',
  `ngay_duyet` timestamp NULL DEFAULT NULL,
  `ly_do_tu_choi` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `bai_dang`
--

INSERT INTO `bai_dang` (`id`, `nguoi_dung_id`, `phong_id`, `tieu_de`, `dia_chi`, `mo_ta`, `gia_niem_yet`, `trang_thai`, `ngay_duyet`, `ly_do_tu_choi`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 2, 1, 'PhÃ²ng trá» tiá»‡n nghi A101', 'PhÆ°á»ng SÃ i GÃ²n', 'Gáº§n trung tÃ¢m, Ä‘áº§y Ä‘á»§ tiá»‡n nghi.', 2500000.00, 'dang', NULL, NULL, '2025-10-11 11:36:01', '2025-12-02 14:08:43'),
(2, 2, 2, 'PhÃ²ng trá» rá»™ng rÃ£i A102', 'PhÆ°á»ng SÃ i GÃ²n', 'PhÃ¹ há»£p sinh viÃªn vÃ  gia Ä‘Ã¬nh nhá».', 2800000.00, 'dang', NULL, NULL, '2025-10-11 11:36:01', '2025-12-02 14:08:43'),
(3, 2, 3, 'PhÃ²ng B201 giÃ¡ há»£p lÃ½', 'PhÆ°á»ng TÃ¢n Äá»‹nh', 'An ninh tá»‘t, cÃ³ chá»— Ä‘á»ƒ xe.', 3000000.00, 'dang', NULL, NULL, '2025-10-11 11:36:01', '2025-12-02 14:08:43'),
(4, 3, 4, 'PhÃ²ng C101 sáº¡ch sáº½', 'PhÆ°á»ng Báº¿n ThÃ nh', 'Gáº§n chá»£, thuáº­n tiá»‡n Ä‘i láº¡i.', 3200000.00, 'dang', NULL, NULL, '2025-10-11 11:36:01', '2025-12-02 14:08:43'),
(5, 3, 5, 'PhÃ²ng D301 cao cáº¥p', 'PhÆ°á»ng Cáº§u Ã”ng LÃ£nh', 'PhÃ²ng rá»™ng, ban cÃ´ng thoÃ¡ng mÃ¡t.', 3500000.00, 'dang', NULL, NULL, '2025-10-11 11:36:01', '2025-12-02 14:08:43'),
(6, 2, 1, 'PhÃ²ng trá» 20mÂ² Ä‘áº§y Ä‘á»§ tiá»‡n nghi - Gáº§n Äáº¡i há»c SÆ° Pháº¡m', 'PhÆ°á»ng SÃ i GÃ²n', 'PhÃ²ng rá»™ng 20mÂ², cÃ³ cá»­a sá»• thoÃ¡ng mÃ¡t, gÃ¡c lá»­ng, wifi miá»…n phÃ­.\r\nCÃ³ chá»— Ä‘á»ƒ xe, khu vá»±c an ninh, gáº§n siÃªu thá»‹ vÃ  báº¿n xe.\r\nBÃ© tÃ­', 3000000.00, 'dang', NULL, NULL, '2025-10-11 13:17:35', '2025-12-02 14:08:43'),
(18, 2, 2, 'Full ná»™i tháº¥t', 'PhÆ°á»ng SÃ i GÃ²n', 'cc', 3200000.00, 'dang', NULL, NULL, '2025-10-22 17:27:39', '2025-12-02 14:08:43'),
(19, 2, 11, 'PhÃ²ng khÃ´ng ná»™i tháº¥t', 'PhÆ°á»ng BÃ n Cá»', 'PhÃ²ng nÃ y chá»©a Ä‘Æ°á»£c con voi vÃ  cÃ¡ máº­p', 3100000.00, 'dang', NULL, NULL, '2025-10-22 22:22:35', '2025-12-02 14:08:43'),
(101, 101, 14, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 1', 'PhÆ°á»ng XuÃ¢n HÃ²a', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(102, 101, 15, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 2', 'PhÆ°á»ng XuÃ¢n HÃ²a', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(103, 101, 16, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 3', 'PhÆ°á»ng NhiÃªu Lá»™c', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(104, 101, 17, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 4', 'PhÆ°á»ng NhiÃªu Lá»™c', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(105, 101, 18, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 5', 'PhÆ°á»ng XÃ³m Chiáº¿u', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(106, 101, 19, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 6', 'PhÆ°á»ng XÃ³m Chiáº¿u', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(107, 101, 20, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 7', 'PhÆ°á»ng KhÃ¡nh Há»™i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(108, 101, 21, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 8', 'PhÆ°á»ng KhÃ¡nh Há»™i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(109, 101, 22, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 9', 'PhÆ°á»ng VÄ©nh Há»™i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(110, 101, 23, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 10', 'PhÆ°á»ng VÄ©nh Há»™i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-11-25 17:28:46'),
(111, 102, 24, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 11', 'PhÆ°á»ng Chá»£ QuÃ¡n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-11-25 17:28:46'),
(112, 102, 25, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 12', 'PhÆ°á»ng Chá»£ QuÃ¡n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(113, 102, 26, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh TÃ¢n', 'PhÆ°á»ng An ÄÃ´ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(114, 102, 27, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh Tháº¡nh', 'PhÆ°á»ng An ÄÃ´ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(115, 102, 28, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n GÃ² Váº¥p', 'PhÆ°á»ng Chá»£ Lá»›n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(116, 102, 29, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n PhÃº Nhuáº­n', 'PhÆ°á»ng Chá»£ Lá»›n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(117, 102, 30, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n TÃ¢n BÃ¬nh', 'PhÆ°á»ng BÃ¬nh TÃ¢y', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(118, 102, 31, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n TÃ¢n PhÃº', 'PhÆ°á»ng BÃ¬nh TÃ¢y', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(119, 102, 32, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh ChÃ¡nh', 'PhÆ°á»ng BÃ¬nh TiÃªn', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(120, 102, 33, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n Cáº§n Giá»', 'PhÆ°á»ng BÃ¬nh TiÃªn', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(121, 103, 34, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n Cá»§ Chi', 'PhÆ°á»ng BÃ¬nh PhÃº', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(122, 103, 35, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n HÃ³c MÃ´n', 'PhÆ°á»ng BÃ¬nh PhÃº', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(123, 103, 36, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 1', 'PhÆ°á»ng PhÃº LÃ¢m', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(124, 103, 37, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 2', 'PhÆ°á»ng PhÃº LÃ¢m', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(125, 103, 38, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 3', 'PhÆ°á»ng TÃ¢n Thuáº­n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(126, 103, 39, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 4', 'PhÆ°á»ng TÃ¢n Thuáº­n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(127, 103, 40, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 5', 'PhÆ°á»ng PhÃº Thuáº­n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(128, 103, 41, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 6', 'PhÆ°á»ng PhÃº Thuáº­n', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(129, 103, 42, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 7', 'PhÆ°á»ng TÃ¢n Má»¹', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(130, 103, 43, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 8', 'PhÆ°á»ng TÃ¢n Má»¹', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(131, 104, 44, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 9', 'PhÆ°á»ng TÃ¢n HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(132, 104, 45, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 10', 'PhÆ°á»ng TÃ¢n HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(133, 104, 46, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 11', 'PhÆ°á»ng ChÃ¡nh HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(134, 104, 47, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 12', 'PhÆ°á»ng ChÃ¡nh HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(135, 104, 48, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh TÃ¢n', 'PhÆ°á»ng PhÃº Äá»‹nh', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(136, 104, 49, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh Tháº¡nh', 'PhÆ°á»ng PhÃº Äá»‹nh', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(137, 104, 50, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n GÃ² Váº¥p', 'PhÆ°á»ng BÃ¬nh ÄÃ´ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(138, 104, 51, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n PhÃº Nhuáº­n', 'PhÆ°á»ng BÃ¬nh ÄÃ´ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(139, 104, 52, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n TÃ¢n BÃ¬nh', 'PhÆ°á»ng DiÃªn Há»“ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(140, 104, 53, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n TÃ¢n PhÃº', 'PhÆ°á»ng DiÃªn Há»“ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(141, 105, 54, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n BÃ¬nh ChÃ¡nh', 'PhÆ°á»ng VÆ°Æ¡Ì€n LaÌ€i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(142, 105, 55, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n Cáº§n Giá»', 'PhÆ°á»ng VÆ°Æ¡Ì€n LaÌ€i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(143, 105, 56, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n Cá»§ Chi', 'PhÆ°á»ng HoÌ€a HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(144, 105, 57, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n HÃ³c MÃ´n', 'PhÆ°á»ng HoÌ€a HÆ°ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2700000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(145, 105, 58, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 1', 'PhÆ°á»ng Minh Phá»¥ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2900000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(146, 105, 59, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 2', 'PhÆ°á»ng Minh Phá»¥ng', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3100000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(147, 105, 60, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 3', 'PhÆ°á»ng BÃ¬nh Thá»›i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3300000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(148, 105, 61, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 4', 'PhÆ°á»ng BÃ¬nh Thá»›i', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 3500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(149, 105, 62, 'PhÃ²ng trá» giÃ¡ ráº» táº¡i Quáº­n 5', 'PhÆ°á»ng HÃ²a BÃ¬nh', 'PhÃ²ng sáº¡ch sáº½, thoÃ¡ng mÃ¡t, an ninh tá»‘t, gáº§n chá»£ vÃ  trÆ°á»ng há»c.', 2500000.00, 'dang', NULL, NULL, '2025-11-17 05:24:37', '2025-12-02 14:08:43'),
(150, 2, 63, 'PhÃ²ng khÃ´ng ná»™i tháº¥t', 'PhÆ°á»ng BÃ n Cá»', 'Tro má»›i nÃ¨', 3000000.00, 'cho_duyet', NULL, NULL, '2025-11-19 20:25:08', '2025-12-02 14:08:43'),
(152, 3, 64, 'PhÃ²ng khÃ´ng ná»™i tháº¥t', 'PhÆ°á»ng Báº¿n ThÃ nh', 'Vip', 2500000.00, 'cho_duyet', NULL, NULL, '2025-12-02 13:58:39', '2025-12-02 13:58:39');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `chi_so`
--

CREATE TABLE `chi_so` (
  `id` int(11) NOT NULL,
  `dong_ho_id` int(11) NOT NULL,
  `thoi_gian` datetime NOT NULL,
  `gia_tri` decimal(12,2) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_nhap_id` int(11) DEFAULT NULL,
  `nguoi_sua_id` int(11) DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `chi_so`
--

INSERT INTO `chi_so` (`id`, `dong_ho_id`, `thoi_gian`, `gia_tri`, `ghi_chu`, `nguoi_nhap_id`, `nguoi_sua_id`, `ngay_tao`, `updated_at`) VALUES
(1, 1, '2025-01-01 00:00:00', 100.00, 'Chá»‰ sá»‘ Ä‘áº§u', NULL, NULL, '2025-10-11 11:36:01', NULL),
(2, 2, '2025-01-01 00:00:00', 50.00, 'Chá»‰ sá»‘ Ä‘áº§u', NULL, NULL, '2025-10-11 11:36:01', NULL),
(3, 3, '2025-01-01 00:00:00', 200.00, 'Chá»‰ sá»‘ Ä‘áº§u', NULL, NULL, '2025-10-11 11:36:01', NULL),
(4, 4, '2025-01-01 00:00:00', 120.00, 'Chá»‰ sá»‘ Ä‘áº§u', NULL, NULL, '2025-10-11 11:36:01', NULL),
(5, 5, '2025-01-01 00:00:00', 80.00, 'Chá»‰ sá»‘ Ä‘áº§u', NULL, NULL, '2025-10-11 11:36:01', NULL),
(6, 1, '2025-10-08 00:00:00', 112.00, 'chá»‰ sá»‘ má»›i', NULL, NULL, '2025-10-23 12:56:39', NULL),
(7, 2, '2025-10-23 00:00:00', 69.00, 'má»›i nÃ¨', 2, NULL, '2025-10-23 14:38:30', NULL),
(8, 3, '2025-10-22 00:00:00', 155.00, 'má»›i nÃ¨', 2, 2, '2025-10-23 15:39:39', '2025-10-23 08:39:51'),
(9, 1, '2025-10-24 00:00:00', 110.00, 'má»›i má»›i', 2, 2, '2025-10-24 11:32:46', '2025-10-24 06:14:15'),
(10, 1, '2025-10-24 00:00:00', 111.00, 'chá»‰ sá»‘ má»›i', 2, NULL, '2025-10-24 12:25:20', NULL),
(11, 2, '2025-10-24 00:00:00', 70.00, 'chá»‰ sá»‘ má»›i', 2, 2, '2025-10-24 12:27:45', '2025-10-24 06:16:50'),
(12, 3, '2025-11-22 00:00:00', 160.00, 'moimoi', 2, 2, '2025-10-24 12:55:18', '2025-10-24 07:18:30'),
(13, 6, '2025-10-26 20:22:40', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 2, NULL, '2025-10-26 20:22:40', NULL),
(14, 7, '2025-10-26 20:22:40', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 2, NULL, '2025-10-26 20:22:40', NULL),
(15, 8, '2025-11-19 20:24:33', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 2, NULL, '2025-11-19 20:24:33', NULL),
(16, 9, '2025-11-19 20:24:33', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 2, NULL, '2025-11-19 20:24:33', NULL),
(17, 10, '2025-11-30 10:51:50', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 3, NULL, '2025-11-30 10:51:50', NULL),
(18, 11, '2025-11-30 10:51:50', 0.00, 'Chá»‰ sá»‘ Ä‘áº§u', 3, NULL, '2025-11-30 10:51:50', NULL);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `chi_tiet_dich_vu`
--

CREATE TABLE `chi_tiet_dich_vu` (
  `id` int(11) NOT NULL,
  `hoa_don_id` int(11) NOT NULL,
  `dich_vu_id` int(11) NOT NULL,
  `so_luong` decimal(10,2) NOT NULL DEFAULT 1.00,
  `don_gia` decimal(12,2) NOT NULL,
  `thanh_tien` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `chi_tiet_dich_vu`
--

INSERT INTO `chi_tiet_dich_vu` (`id`, `hoa_don_id`, `dich_vu_id`, `so_luong`, `don_gia`, `thanh_tien`) VALUES
(1, 1, 3, 1.00, 50000.00, 50000.00),
(2, 1, 4, 1.00, 100000.00, 100000.00),
(3, 2, 3, 1.00, 50000.00, 50000.00),
(4, 2, 4, 1.00, 100000.00, 100000.00),
(5, 3, 5, 1.00, 150000.00, 150000.00),
(11, 10, 3, 1.00, 50000.00, 50000.00),
(12, 10, 4, 1.00, 100000.00, 100000.00),
(33, 21, 3, 1.00, 50000.00, 50000.00),
(34, 21, 1, 1.00, 0.00, 0.00),
(35, 21, 2, 1.00, 0.00, 0.00),
(38, 24, 4, 1.00, 100000.00, 100000.00),
(39, 24, 5, 1.00, 50000.00, 50000.00),
(40, 24, 3, 1.00, 2500000.00, 2500000.00),
(41, 25, 3, 1.00, 50000.00, 50000.00),
(42, 25, 1, 1.00, 0.00, 0.00),
(43, 25, 2, 1.00, 0.00, 0.00),
(44, 26, 4, 1.00, 100000.00, 100000.00),
(45, 26, 5, 1.00, 50000.00, 50000.00),
(46, 26, 3, 1.00, 2500000.00, 2500000.00),
(63, 35, 4, 1.00, 100000.00, 100000.00),
(64, 35, 5, 1.00, 150000.00, 150000.00),
(75, 41, 4, 1.00, 100000.00, 100000.00),
(76, 41, 5, 1.00, 50000.00, 50000.00),
(77, 41, 3, 1.00, 2500000.00, 2500000.00),
(88, 47, 4, 1.00, 100000.00, 100000.00),
(89, 47, 5, 1.00, 150000.00, 150000.00);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `chi_tiet_dong_ho`
--

CREATE TABLE `chi_tiet_dong_ho` (
  `id` int(11) NOT NULL,
  `hoa_don_id` int(11) NOT NULL,
  `dong_ho_id` int(11) NOT NULL,
  `dich_vu_id` int(11) NOT NULL,
  `chi_so_cu` decimal(12,2) NOT NULL,
  `chi_so_moi` decimal(12,2) NOT NULL,
  `san_luong` decimal(12,2) NOT NULL,
  `don_gia` decimal(12,2) NOT NULL,
  `thanh_tien` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `chi_tiet_dong_ho`
--

INSERT INTO `chi_tiet_dong_ho` (`id`, `hoa_don_id`, `dong_ho_id`, `dich_vu_id`, `chi_so_cu`, `chi_so_moi`, `san_luong`, `don_gia`, `thanh_tien`) VALUES
(1, 1, 1, 1, 100.00, 150.00, 50.00, 3500.00, 175000.00),
(2, 1, 2, 2, 50.00, 70.00, 20.00, 15000.00, 300000.00),
(3, 2, 1, 1, 150.00, 180.00, 30.00, 3500.00, 105000.00),
(4, 3, 4, 1, 120.00, 150.00, 30.00, 3500.00, 105000.00),
(5, 3, 5, 2, 80.00, 100.00, 20.00, 15000.00, 300000.00),
(10, 21, 3, 1, 155.00, 160.00, 5.00, 3500.00, 17500.00);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `chu_tro`
--

CREATE TABLE `chu_tro` (
  `id` int(11) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `account_no` varchar(30) DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `chu_tro`
--

INSERT INTO `chu_tro` (`id`, `dia_chi`, `bank_code`, `account_no`, `account_name`) VALUES
(2, '123 ÄÆ°á»ng LÃª Lá»£i, Q1', 'MB', '16688668068', 'TRAN DUY BAO'),
(3, '456 ÄÆ°á»ng Tráº§n HÆ°ng Äáº¡o, Q5', 'MB', '4309112005', 'TRAN THI CAM LY'),
(101, '12 ÄÆ°á»ng Hoa Lan, Quáº­n PhÃº Nhuáº­n', 'VCB', '101000000001', 'NGUYEN VAN HAI'),
(102, '23 ÄÆ°á»ng LÃª Duáº©n, Quáº­n 1', 'ACB', '101000000002', 'TRAN HOANG DUY'),
(103, '45 ÄÆ°á»ng Ba ThÃ¡ng Hai, Quáº­n 10', 'MB', '101000000003', 'LE MINH TAM'),
(104, '67 ÄÆ°á»ng Phan ÄÃ¬nh PhÃ¹ng, Quáº­n PhÃº Nhuáº­n', 'TCB', '101000000004', 'PHAM QUOC BAO'),
(105, '89 ÄÆ°á»ng Nguyá»…n Thá»‹ Minh Khai, Quáº­n 3', 'VPB', '101000000005', 'VO THANH PHONG');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int(11) NOT NULL,
  `hop_dong_id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `diem_so` tinyint(4) NOT NULL COMMENT '1..5',
  `binh_luan` text NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `danh_gia`
--

INSERT INTO `danh_gia` (`id`, `hop_dong_id`, `khach_thue_id`, `diem_so`, `binh_luan`, `ngay_tao`) VALUES
(1, 1, 4, 5, 'PhÃ²ng Ä‘áº¹p, chá»§ trá» thÃ¢n thiá»‡n.', '2025-10-11 11:36:01'),
(2, 2, 4, 4, 'GiÃ¡ cáº£ há»£p lÃ½.', '2025-10-11 11:36:01'),
(3, 3, 5, 5, 'Ráº¥t hÃ i lÃ²ng.', '2025-10-11 11:36:01'),
(4, 4, 5, 3, 'Cáº§n cáº£i thiá»‡n vá»‡ sinh.', '2025-10-11 11:36:01'),
(5, 5, 4, 4, 'View Ä‘áº¹p.', '2025-10-11 11:36:01');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `day_tro`
--

CREATE TABLE `day_tro` (
  `id` int(11) NOT NULL,
  `chu_tro_id` int(11) NOT NULL,
  `ten_day_tro` varchar(255) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `so_phong` int(11) DEFAULT NULL,
  `so_phong_trong` int(11) DEFAULT 0,
  `so_phong_da_thue` int(11) DEFAULT 0,
  `so_phong_bao_tri` int(11) DEFAULT 0,
  `dien_tich_tb` decimal(6,2) DEFAULT NULL,
  `gia_trung_binh` decimal(12,2) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `tien_ich` text DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `day_tro`
--

INSERT INTO `day_tro` (`id`, `chu_tro_id`, `ten_day_tro`, `dia_chi`, `so_phong`, `so_phong_trong`, `so_phong_da_thue`, `so_phong_bao_tri`, `dien_tich_tb`, `gia_trung_binh`, `mo_ta`, `tien_ich`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 2, 'DÃ£y A', 'PhÆ°á»ng SÃ i GÃ²n', 3, 0, 2, 0, 15.00, 3500000.00, 'PhÃ²ng rá»™ng thoÃ¡ng mÃ¡t', 'Wifi, ban cÃ´ng', '2025-10-11 11:36:01', '2025-11-25 17:19:28'),
(2, 2, 'DÃ£y B', 'PhÆ°á»ng TÃ¢n Äá»‹nh', 4, 1, 1, 0, 13.00, 3100000.00, 'PhÃ²ng thoÃ¡ng mÃ¡t cÃ³ thá»ƒ chá»©a nhiá»u Ä‘á»“', 'wifi, chá»— Ä‘áº­u xe, ban cÃ´ng', '2025-10-11 11:36:01', '2025-11-25 17:19:28'),
(3, 3, 'DÃ£y C', 'PhÆ°á»ng Báº¿n ThÃ nh', 5, 1, 1, 0, 16.00, 3400000.00, 'PhÃ²ng rá»™ng cÃ³ thá»ƒ 3 ngÆ°á»i á»Ÿ', 'wifi, rÃ¡c, mÃ¡y giáº·t', '2025-10-11 11:36:01', '2025-11-30 10:51:50'),
(4, 3, 'DÃ£y D', 'PhÆ°á»ng Cáº§u Ã”ng LÃ£nh', 2, 0, 1, 0, 20.00, 4000000.00, 'PhÃ²ng cÃ³ sá»©c chá»©a 3 ngÆ°á»i vÃ  nhiá»u Ä‘á»“', 'full tiá»‡n Ã­ch', '2025-10-11 11:36:01', '2025-11-25 17:19:28'),
(5, 2, 'DÃ£y E', 'PhÆ°á»ng BÃ n Cá»', 9, 3, 1, 0, 19.00, 4000000.00, 'PhÃ²ng gáº§n cÆ¡ sá»Ÿ, chá»£, trÆ°á»ng, rá»™ng thoÃ¡ng mÃ¡t', 'full tiá»‡n Ã­ch', '2025-10-11 11:36:01', '2025-11-25 17:19:28'),
(6, 101, 'DÃ£y A', 'PhÆ°á»ng XuÃ¢n HÃ²a', 17, 5, 12, 0, 14.00, 3200000.00, 'DÃ£y trá» sáº¡ch sáº½, an ninh.', 'Wifi, camera, giá»¯ xe', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(7, 101, 'DÃ£y B', 'PhÆ°á»ng NhiÃªu Lá»™c', 20, 6, 14, 0, 16.00, 3500000.00, 'Gáº§n Ä‘Æ°á»ng lá»›n, tiá»‡n Ä‘i láº¡i.', 'Wifi, sÃ¢n phÆ¡i, báº¿p chung', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(8, 101, 'DÃ£y C', 'PhÆ°á»ng XÃ³m Chiáº¿u', 14, 4, 10, 0, 13.00, 3000000.00, 'Khu trung tÃ¢m, tiá»‡n Ã­ch Ä‘áº§y Ä‘á»§.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(9, 101, 'DÃ£y D', 'PhÆ°á»ng KhÃ¡nh Há»™i', 22, 7, 15, 0, 18.00, 3800000.00, 'PhÃ²ng cÃ³ cá»­a sá»• thoÃ¡ng.', 'Wifi, mÃ¡y giáº·t dÃ¹ng chung', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(10, 101, 'DÃ£y E', 'PhÆ°á»ng VÄ©nh Há»™i', 16, 5, 11, 0, 15.00, 3300000.00, 'Khu dÃ¢n cÆ° yÃªn tÄ©nh.', 'Wifi, bÃ£i xe', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(11, 102, 'DÃ£y A', 'PhÆ°á»ng Chá»£ QuÃ¡n', 12, 4, 8, 0, 12.00, 2800000.00, 'PhÃ²ng ráº», phÃ¹ há»£p sinh viÃªn.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(12, 102, 'DÃ£y B', 'PhÆ°á»ng An ÄÃ´ng', 18, 6, 12, 0, 17.00, 3600000.00, 'CÃ³ gÃ¡c, phÃ²ng rá»™ng.', 'Wifi, bÃ£i xe', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(13, 102, 'DÃ£y C', 'PhÆ°á»ng Chá»£ Lá»›n', 13, 4, 9, 0, 13.00, 3100000.00, 'Gáº§n chá»£, thuáº­n tiá»‡n.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(14, 102, 'DÃ£y D', 'PhÆ°á»ng BÃ¬nh TÃ¢y', 20, 6, 14, 0, 16.50, 3400000.00, 'PhÃ²ng má»›i xÃ¢y Ä‘áº¹p.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(15, 102, 'DÃ£y E', 'PhÆ°á»ng BÃ¬nh TiÃªn', 16, 5, 11, 0, 15.00, 3300000.00, 'Khu vá»±c an ninh.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(16, 103, 'DÃ£y A', 'PhÆ°á»ng BÃ¬nh PhÃº', 15, 4, 11, 0, 14.00, 3000000.00, 'YÃªn tÄ©nh, sáº¡ch Ä‘áº¹p.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(17, 103, 'DÃ£y B', 'PhÆ°á»ng PhÃº LÃ¢m', 19, 6, 13, 0, 16.00, 3200000.00, 'CÃ³ gÃ¡c lá»­ng.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(18, 103, 'DÃ£y C', 'PhÆ°á»ng TÃ¢n Thuáº­n', 22, 8, 14, 0, 18.00, 3700000.00, 'NhÃ  má»›i xÃ¢y.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 17:19:28'),
(19, 103, 'DÃ£y D', 'PhÆ°á»ng PhÃº Thuáº­n', 12, 3, 9, 0, 12.00, 2900000.00, 'Gáº§n trÆ°á»ng há»c.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(20, 103, 'DÃ£y E', 'PhÆ°á»ng TÃ¢n Má»¹', 14, 5, 9, 0, 13.50, 3100000.00, 'Khu dÃ¢n cÆ°.', 'Wifi, sÃ¢n phÆ¡i', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(21, 103, 'DÃ£y F', 'PhÆ°á»ng TÃ¢n HÆ°ng', 17, 5, 12, 0, 14.00, 3500000.00, 'Gáº§n trung tÃ¢m.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(22, 103, 'DÃ£y G', 'PhÆ°á»ng ChÃ¡nh HÆ°ng', 21, 7, 14, 0, 16.00, 3600000.00, 'NhÃ  lá»›n, lá»‘i Ä‘i rá»™ng.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(23, 104, 'DÃ£y A', 'PhÆ°á»ng PhÃº Äá»‹nh', 16, 5, 11, 0, 15.00, 3200000.00, 'PhÃ²ng rá»™ng.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(24, 104, 'DÃ£y B', 'PhÆ°á»ng BÃ¬nh ÄÃ´ng', 20, 6, 14, 0, 17.00, 3300000.00, 'Gáº§n báº¿n xe.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(25, 104, 'DÃ£y C', 'PhÆ°á»ng DiÃªn Há»“ng', 12, 4, 8, 0, 12.00, 2500000.00, 'KhÃ´ng gian thoÃ¡ng mÃ¡t.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 17:19:29'),
(26, 104, 'DÃ£y D', 'PhÆ°á»ng VÆ°Æ¡Ì€n LaÌ€i', 13, 4, 9, 0, 13.00, 2600000.00, 'An ninh tá»‘t.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 18:01:22'),
(27, 104, 'DÃ£y E', 'PhÆ°á»ng HoÌ€a HÆ°ng', 18, 5, 13, 0, 16.00, 3000000.00, 'Gáº§n siÃªu thá»‹.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(28, 104, 'DÃ£y F', 'PhÆ°á»ng Minh Phá»¥ng', 14, 4, 10, 0, 14.00, 2800000.00, 'KhÃ´ng gian yÃªn tÄ©nh.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(29, 105, 'DÃ£y A', 'PhÆ°á»ng BÃ¬nh Thá»›i', 14, 4, 10, 0, 14.00, 3100000.00, 'DÃ£y trá» nhá» gá»n.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(30, 105, 'DÃ£y B', 'PhÆ°á»ng HÃ²a BÃ¬nh', 17, 5, 12, 0, 16.00, 3500000.00, 'PhÃ²ng Ä‘áº¹p.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(31, 105, 'DÃ£y C', 'PhÆ°á»ng PhÃº Thá»', 18, 5, 13, 0, 17.00, 3600000.00, 'Gáº§n trung tÃ¢m.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(32, 105, 'DÃ£y D', 'PhÆ°á»ng ÄÃ´ng HÆ°ng Thuáº­n', 14, 3, 11, 0, 15.00, 3300000.00, 'NhÃ  má»›i.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(33, 105, 'DÃ£y E', 'PhÆ°á»ng Trung Má»¹ TÃ¢y', 11, 2, 9, 0, 13.00, 2900000.00, 'GiÃ¡ tá»‘t.', 'Wifi', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(34, 105, 'DÃ£y F', 'PhÆ°á»ng TÃ¢n Thá»›i Hiá»‡p', 19, 5, 14, 0, 17.50, 3400000.00, 'Nhiá»u tiá»‡n Ã­ch.', 'Wifi, camera', '2025-11-17 05:40:15', '2025-11-25 18:03:04'),
(35, 105, 'DÃ£y G', 'PhÆ°á»ng Thá»›i An', 20, 6, 14, 0, 18.00, 3800000.00, 'Gáº§n mall.', 'Wifi, mÃ¡y giáº·t', '2025-11-17 05:40:15', '2025-11-25 18:03:04');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `dia_chi`
--

CREATE TABLE `dia_chi` (
  `id` int(11) NOT NULL,
  `ten_dia_chi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `dia_chi`
--

INSERT INTO `dia_chi` (`id`, `ten_dia_chi`) VALUES
(1, 'PhÆ°á»ng SÃ i GÃ²n'),
(2, 'PhÆ°á»ng TÃ¢n Äá»‹nh'),
(3, 'PhÆ°á»ng Báº¿n ThÃ nh'),
(4, 'PhÆ°á»ng Cáº§u Ã”ng LÃ£nh'),
(5, 'PhÆ°á»ng BaÌ€n CÆ¡Ì€'),
(6, 'PhÆ°á»ng XuÃ¢n HÃ²a'),
(7, 'PhÆ°á»ng NhiÃªu Lá»™c'),
(8, 'PhÆ°á»ng XÃ³m Chiáº¿u'),
(9, 'PhÆ°á»ng KhÃ¡nh Há»™i'),
(10, 'PhÆ°á»ng VÄ©nh Há»™i'),
(11, 'PhÆ°á»ng Chá»£ QuÃ¡n'),
(12, 'PhÆ°á»ng An ÄÃ´ng'),
(13, 'PhÆ°á»ng Chá»£ Lá»›n'),
(14, 'PhÆ°á»ng BÃ¬nh TÃ¢y'),
(15, 'PhÆ°á»ng BÃ¬nh TiÃªn'),
(16, 'PhÆ°á»ng BÃ¬nh PhÃº'),
(17, 'PhÆ°á»ng PhÃº LÃ¢m'),
(18, 'PhÆ°á»ng TÃ¢n Thuáº­n'),
(19, 'PhÆ°á»ng PhÃº Thuáº­n'),
(20, 'PhÆ°á»ng TÃ¢n Má»¹'),
(21, 'PhÆ°á»ng TÃ¢n HÆ°ng'),
(22, 'PhÆ°á»ng ChÃ¡nh HÆ°ng'),
(23, 'PhÆ°á»ng PhÃº Äá»‹nh'),
(24, 'PhÆ°á»ng BÃ¬nh ÄÃ´ng'),
(25, 'PhÆ°á»ng DiÃªn Há»“ng'),
(26, 'PhÆ°á»ng VÆ°Æ¡Ì£t LÃ i'),
(27, 'PhÆ°á»ng HÃ²a HÆ°ng'),
(28, 'PhÆ°á»ng Minh Phá»¥ng'),
(29, 'PhÆ°á»ng BÃ¬nh Thá»›i'),
(30, 'PhÆ°á»ng HÃ²a BÃ¬nh'),
(31, 'PhÆ°á»ng PhÃº Thá»'),
(32, 'PhÆ°á»ng ÄÃ´ng HÆ°ng Thuáº­n'),
(33, 'PhÆ°á»ng Trung Má»¹ TÃ¢y'),
(34, 'PhÆ°á»ng TÃ¢n Thá»›i Hiá»‡p'),
(35, 'PhÆ°á»ng Thá»›i An'),
(36, 'PhÆ°á»ng An PhÃº ÄÃ´ng'),
(37, 'PhÆ°á»ng ÄÃ´ng HÆ°ng Thuáº­n'),
(38, 'PhÆ°á»ng BÃ¬nh TÃ¢n'),
(39, 'PhÆ°á»ng TÃ¢n Táº¡o'),
(40, 'PhÆ°á»ng BÃ¬nh Trá»‹ ÄÃ´ng'),
(41, 'PhÆ°á»ng TÃ¢n Táº¡o A'),
(42, 'PhÆ°á»ng BÃ¬nh Trá»‹ ÄÃ´ng A'),
(43, 'PhÆ°á»ng BÃ¬nh Trá»‹ ÄÃ´ng B'),
(44, 'PhÆ°á»ng An Láº¡c'),
(45, 'PhÆ°á»ng An Láº¡c A'),
(46, 'PhÆ°á»ng BÃ¬nh HÆ°ng HÃ²a'),
(47, 'PhÆ°á»ng BÃ¬nh HÆ°ng HÃ²a A'),
(48, 'PhÆ°á»ng BÃ¬nh HÆ°ng HÃ²a B'),
(49, 'PhÆ°á»ng TÃ¢n Thá»›i Nháº¥t'),
(50, 'PhÆ°á»ng TÃ¢n ChÃ¡nh Hiá»‡p'),
(51, 'PhÆ°á»ng Hiá»‡p ThÃ nh'),
(52, 'PhÆ°á»ng Thá»›i An'),
(53, 'PhÆ°á»ng Trung Má»¹ TÃ¢y'),
(54, 'PhÆ°á»ng TÃ¢n HÆ°ng Thuáº­n'),
(55, 'PhÆ°á»ng ÄÃ´ng HÆ°ng Thuáº­n'),
(56, 'PhÆ°á»ng TÃ¢n BÃ¬nh'),
(57, 'PhÆ°á»ng TÃ¢y Tháº¡nh'),
(58, 'PhÆ°á»ng SÆ¡n Ká»³'),
(59, 'PhÆ°á»ng TÃ¢n SÆ¡n NhÃ¬'),
(60, 'PhÆ°á»ng TÃ¢n ThÃ nh'),
(61, 'PhÆ°á»ng PhÃº Thá» HÃ²a'),
(62, 'PhÆ°á»ng PhÃº Trung'),
(63, 'PhÆ°á»ng HÃ²a Tháº¡nh'),
(64, 'PhÆ°á»ng Hiá»‡p TÃ¢n'),
(65, 'PhÆ°á»ng TÃ¢n QuÃ½'),
(66, 'PhÆ°á»ng TÃ¢n Thá»›i HÃ²a'),
(67, 'PhÆ°á»ng PhÃº Tháº¡nh'),
(68, 'PhÆ°á»ng TÃ¢y Tháº¡nh'),
(69, 'PhÆ°á»ng TÃ¢n QuÃ½ ÄÃ´ng'),
(70, 'PhÆ°á»ng Long PhÆ°á»›c'),
(71, 'PhÆ°á»ng PhÃº Há»¯u'),
(72, 'PhÆ°á»ng Long TrÆ°á»ng'),
(73, 'PhÆ°á»ng TrÆ°á»ng Tháº¡nh'),
(74, 'PhÆ°á»ng TÄƒng NhÆ¡n PhÃº A'),
(75, 'PhÆ°á»ng TÄƒng NhÆ¡n PhÃº B'),
(76, 'PhÆ°á»ng PhÆ°á»›c Long A'),
(77, 'PhÆ°á»ng PhÆ°á»›c Long B'),
(78, 'PhÆ°á»ng Hiá»‡p PhÃº'),
(79, 'PhÆ°á»ng Long Tháº¡nh Má»¹'),
(80, 'PhÆ°á»ng Long BÃ¬nh'),
(81, 'PhÆ°á»ng TÃ¢n PhÃº'),
(82, 'PhÆ°á»ng TrÆ°á»ng Thá»'),
(83, 'PhÆ°á»ng BÃ¬nh Chiá»ƒu'),
(84, 'PhÆ°á»ng Linh Trung'),
(85, 'PhÆ°á»ng Linh TÃ¢y'),
(86, 'PhÆ°á»ng Linh XuÃ¢n'),
(87, 'PhÆ°á»ng Tam BÃ¬nh'),
(88, 'PhÆ°á»ng Tam PhÃº'),
(89, 'PhÆ°á»ng Hiá»‡p BÃ¬nh PhÆ°á»›c'),
(90, 'PhÆ°á»ng Hiá»‡p BÃ¬nh ChÃ¡nh'),
(91, 'PhÆ°á»ng TrÆ°á»ng Thá»'),
(92, 'PhÆ°á»ng Tam PhÃº'),
(93, 'PhÆ°á»ng TrÆ°á»ng Tháº¡nh'),
(94, 'PhÆ°á»ng Tháº¡nh XuÃ¢n'),
(95, 'PhÆ°á»ng Tháº¡nh Lá»™c'),
(96, 'PhÆ°á»ng Hiá»‡p ThÃ nh'),
(97, 'PhÆ°á»ng TÃ¢n Thá»›i Hiá»‡p'),
(98, 'PhÆ°á»ng TÃ¢n ChÃ¡nh Hiá»‡p'),
(99, 'PhÆ°á»ng Thá»›i An'),
(100, 'PhÆ°á»ng Trung Má»¹ TÃ¢y'),
(101, 'PhÆ°á»ng ÄÃ´ng HÆ°ng Thuáº­n'),
(102, 'PhÆ°á»ng TÃ¢n HÆ°ng Thuáº­n'),
(103, 'PhÆ°á»ng An PhÃº ÄÃ´ng'),
(104, 'PhÆ°á»ng Thanh XuÃ¢n'),
(105, 'PhÆ°á»ng SÆ¡n Ká»³'),
(106, 'XÃ£ BÃ¬nh ChÃ¡nh'),
(107, 'XÃ£ HÆ°ng Long'),
(108, 'XÃ£ LÃª Minh XuÃ¢n'),
(109, 'XÃ£ BÃ¬nh Lá»£i'),
(110, 'XÃ£ Äa PhÆ°á»›c'),
(111, 'XÃ£ Quy Äá»©c'),
(112, 'XÃ£ An PhÃº TÃ¢y'),
(113, 'XÃ£ An NhÆ¡n TÃ¢y'),
(114, 'XÃ£ PhÆ°á»›c Hiá»‡p'),
(115, 'XÃ£ PhÆ°á»›c Tháº¡nh'),
(116, 'XÃ£ Long PhÆ°á»›c'),
(117, 'XÃ£ Long Tháº¡nh Má»¹'),
(118, 'XÃ£ Long BÃ¬nh'),
(119, 'XÃ£ Pháº¡m VÄƒn Cá»™i'),
(120, 'XÃ£ PhÃº HÃ²a ÄÃ´ng'),
(121, 'XÃ£ Trung An'),
(122, 'XÃ£ HÃ²a PhÃº'),
(123, 'XÃ£ TÃ¢n Tháº¡nh ÄÃ´ng'),
(124, 'XÃ£ TÃ¢n Tháº¡nh TÃ¢y'),
(125, 'XÃ£ Trung Láº­p ThÆ°á»£ng'),
(126, 'XÃ£ Trung Láº­p Háº¡'),
(127, 'XÃ£ Nhuáº­n Äá»©c'),
(128, 'XÃ£ PhÃº Má»¹ HÆ°ng'),
(129, 'XÃ£ PhÃº HÃ²a ÄÃ´ng'),
(130, 'XÃ£ TÃ¢n An Há»™i'),
(131, 'XÃ£ TÃ¢n PhÃº Trung'),
(132, 'XÃ£ PhÆ°á»›c VÄ©nh An'),
(133, 'XÃ£ TÃ¢n ThÃ´ng Há»™i'),
(134, 'XÃ£ TÃ¢n Láº­p'),
(135, 'XÃ£ PhÃº An'),
(136, 'XÃ£ Báº¡ch Äáº±ng'),
(137, 'XÃ£ Long NguyÃªn'),
(138, 'XÃ£ An Äiá»n'),
(139, 'XÃ£ An TÃ¢y'),
(140, 'XÃ£ PhÃº TÃ¢n'),
(141, 'XÃ£ Long TÃ¢n'),
(142, 'XÃ£ Long HÃ²a'),
(143, 'XÃ£ Minh ThÃ nh'),
(144, 'XÃ£ Minh Tháº¡nh'),
(145, 'XÃ£ Äá»‹nh Hiá»‡p'),
(146, 'XÃ£ Äá»‹nh ThÃ nh'),
(147, 'XÃ£ Äá»‹nh An'),
(148, 'XÃ£ Thanh Tuyá»n'),
(149, 'XÃ£ An Láº­p'),
(150, 'XÃ£ Minh HÃ²a'),
(151, 'XÃ£ Dáº§u Tiáº¿ng'),
(152, 'XÃ£ PhÆ°á»›c TÃ¢n'),
(153, 'XÃ£ PhÆ°á»›c Thuáº­n'),
(154, 'XÃ£ HÃ²a Há»™i'),
(155, 'XÃ£ HÃ²a BÃ¬nh'),
(156, 'XÃ£ HÃ²a HÆ°ng'),
(157, 'XÃ£ BÆ°ng Riá»ng'),
(158, 'XÃ£ XuyÃªn Má»™c'),
(159, 'XÃ£ BÃ¬nh ChÃ¢u'),
(160, 'XÃ£ Há»“ TrÃ m'),
(161, 'XÃ£ BÃ u LÃ¢m'),
(162, 'XÃ£ Suá»‘i Rao'),
(163, 'XÃ£ SÆ¡n BÃ¬nh'),
(164, 'XÃ£ XuÃ¢n SÆ¡n'),
(165, 'Äáº·c khu CÃ´n Äáº£o'),
(166, 'XÃ£ Long SÆ¡n'),
(167, 'XÃ£ Tháº¡nh An'),
(168, 'PhÆ°á»ng Thá»›i HÃ²a');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `dich_vu`
--

CREATE TABLE `dich_vu` (
  `id` int(11) NOT NULL,
  `chu_tro_id` int(11) NOT NULL,
  `ma` varchar(50) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `don_vi` varchar(50) NOT NULL,
  `don_gia` decimal(12,2) NOT NULL,
  `co_dong_ho` tinyint(4) NOT NULL DEFAULT 0,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `dich_vu`
--

INSERT INTO `dich_vu` (`id`, `chu_tro_id`, `ma`, `ten`, `don_vi`, `don_gia`, `co_dong_ho`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 2, 'DV001', 'Äiá»‡n', 'kWh', 3500.00, 1, '2025-10-11 11:36:01', '2025-10-26 12:02:44'),
(2, 2, 'DV002', 'NÆ°á»›c', 'm3', 15000.00, 1, '2025-10-11 11:36:01', '2025-10-26 12:02:49'),
(3, 2, 'DV003', 'RÃ¡c', 'thÃ¡ng', 50000.00, 0, '2025-10-11 11:36:01', '2025-10-26 12:02:52'),
(4, 3, 'DV004', 'Internet', 'thÃ¡ng', 100000.00, 0, '2025-10-11 11:36:01', '2025-10-26 12:02:55'),
(5, 3, 'DV005', 'Giá»¯ xe', 'thÃ¡ng', 150000.00, 0, '2025-10-11 11:36:01', '2025-10-26 12:02:57'),
(22, 2, 'DV022', 'Xe', 'thÃ¡ng', 25000.00, 0, '2025-10-26 12:03:23', '2025-10-26 12:03:23'),
(23, 2, 'DV023', 'wifi', 'thÃ¡ng', 80000.00, 0, '2025-10-26 12:14:02', '2025-10-26 12:14:19'),
(24, 2, 'DV024', 'Máº¡ng', 'thÃ¡ng', 80000.00, 0, '2025-10-26 12:24:47', '2025-10-26 12:30:31');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `dich_vu_dinh_ky`
--

CREATE TABLE `dich_vu_dinh_ky` (
  `id` int(11) NOT NULL,
  `phong_id` int(11) NOT NULL,
  `dich_vu_id` int(11) NOT NULL,
  `don_gia` decimal(12,2) NOT NULL,
  `so_luong` decimal(10,2) NOT NULL DEFAULT 1.00,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `dich_vu_dinh_ky`
--

INSERT INTO `dich_vu_dinh_ky` (`id`, `phong_id`, `dich_vu_id`, `don_gia`, `so_luong`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(2, 1, 4, 100000.00, 1.00, '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(3, 2, 3, 50000.00, 1.00, '2025-10-11 11:36:01', '2025-10-22 08:28:48'),
(4, 3, 4, 100000.00, 1.00, '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(5, 3, 5, 150000.00, 1.00, '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(12, 2, 1, 0.00, 1.00, '2025-10-22 15:28:48', '2025-10-22 10:27:39'),
(13, 2, 2, 0.00, 1.00, '2025-10-22 15:28:48', '2025-10-22 10:27:39'),
(14, 11, 2, 0.00, 1.00, '2025-10-22 22:22:35', '2025-10-22 15:22:35'),
(15, 11, 3, 0.00, 1.00, '2025-10-22 22:22:35', '2025-10-22 15:22:35'),
(16, 11, 4, 0.00, 1.00, '2025-10-22 22:22:35', '2025-10-22 15:22:35'),
(18, 1, 5, 50000.00, 1.00, '2025-10-26 12:54:41', '2025-10-26 12:54:41'),
(19, 1, 3, 2500000.00, 1.00, '2025-10-26 12:55:00', '2025-10-26 12:55:00'),
(20, 63, 1, 0.00, 1.00, '2025-11-19 20:25:09', '2025-11-19 13:25:09'),
(21, 63, 2, 0.00, 1.00, '2025-11-19 20:25:09', '2025-11-19 13:25:09'),
(22, 63, 3, 0.00, 1.00, '2025-11-19 20:25:09', '2025-11-19 13:25:09'),
(23, 63, 23, 0.00, 1.00, '2025-11-19 20:25:09', '2025-11-19 13:25:09'),
(24, 64, 1, 0.00, 1.00, '2025-12-02 13:51:32', '2025-12-02 06:58:39'),
(25, 64, 2, 0.00, 1.00, '2025-12-02 13:51:32', '2025-12-02 06:51:32'),
(26, 64, 23, 0.00, 1.00, '2025-12-02 13:51:32', '2025-12-02 06:58:39');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `dong_ho`
--

CREATE TABLE `dong_ho` (
  `id` int(11) NOT NULL,
  `phong_id` int(11) NOT NULL,
  `dich_vu_id` int(11) NOT NULL,
  `ma_dong_ho` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `dong_ho`
--

INSERT INTO `dong_ho` (`id`, `phong_id`, `dich_vu_id`, `ma_dong_ho`) VALUES
(1, 1, 1, 'DH_Dien_A101'),
(2, 1, 2, 'DH_Nuoc_A101'),
(3, 2, 1, 'DH_Dien_A102'),
(4, 3, 1, 'DH_Dien_B201'),
(5, 3, 2, 'DH_Nuoc_B201'),
(6, 13, 1, 'DH_Dien_E08'),
(7, 13, 2, 'DH_Nuoc_E08'),
(8, 63, 1, 'DH_Dien_C105'),
(9, 63, 2, 'DH_Nuoc_C105'),
(10, 64, 1, 'DH_Dien_C107'),
(11, 64, 2, 'DH_Nuoc_C107');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `id` int(11) NOT NULL,
  `hop_dong_id` int(11) NOT NULL,
  `thang` char(7) NOT NULL,
  `tien_phong` decimal(12,2) NOT NULL,
  `tien_dich_vu` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tien_dong_ho` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tong_tien` decimal(12,2) NOT NULL DEFAULT 0.00,
  `trang_thai` enum('chua_thanh_toan','mot_phan','da_thanh_toan','da_huy','cho_xac_nhan') DEFAULT 'chua_thanh_toan',
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `han_thanh_toan` datetime NOT NULL,
  `ngay_thanh_toan` datetime DEFAULT NULL,
  `so_tien_da_tra` decimal(12,2) NOT NULL DEFAULT 0.00,
  `da_gui_canh_bao` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `hoa_don`
--

INSERT INTO `hoa_don` (`id`, `hop_dong_id`, `thang`, `tien_phong`, `tien_dich_vu`, `tien_dong_ho`, `tong_tien`, `trang_thai`, `ngay_tao`, `han_thanh_toan`, `ngay_thanh_toan`, `so_tien_da_tra`, `da_gui_canh_bao`) VALUES
(1, 1, '2025-01', 2500000.00, 150000.00, 475000.00, 3125000.00, 'da_thanh_toan', '2025-10-11 11:36:01', '2025-01-10 00:00:00', NULL, 0.00, 0),
(2, 2, '2025-02', 2800000.00, 150000.00, 105000.00, 3055000.00, 'da_thanh_toan', '2025-10-11 11:36:01', '2025-02-10 00:00:00', NULL, 3055000.00, 0),
(3, 3, '2025-01', 3000000.00, 150000.00, 405000.00, 3555000.00, 'da_huy', '2025-10-11 11:36:01', '2025-01-10 00:00:00', NULL, 0.00, 0),
(4, 4, '2025-03', 3200000.00, 0.00, 0.00, 3200000.00, 'da_thanh_toan', '2025-10-11 11:36:01', '2025-03-10 00:00:00', NULL, 0.00, 0),
(5, 5, '2025-04', 3500000.00, 0.00, 0.00, 3500000.00, 'chua_thanh_toan', '2025-10-11 11:36:01', '2025-04-10 00:00:00', NULL, 0.00, 0),
(10, 1, '2025-11', 2500000.00, 150000.00, 0.00, 2650000.00, 'da_huy', '2025-10-24 15:42:22', '2025-11-01 00:00:00', NULL, 0.00, 0),
(21, 2, '2025-11', 2800000.00, 50000.00, 17500.00, 2867500.00, 'chua_thanh_toan', '2025-11-07 22:59:31', '2025-12-01 00:00:00', NULL, 0.00, 0),
(22, 7, '2025-11', 3500000.00, 0.00, 0.00, 3500000.00, 'chua_thanh_toan', '2025-11-07 22:59:31', '2025-11-25 00:00:00', NULL, 0.00, 0),
(24, 1, '2025-02', 2500000.00, 2650000.00, 0.00, 5150000.00, 'chua_thanh_toan', '2025-11-07 22:59:31', '2025-12-01 00:00:00', NULL, 0.00, 0),
(25, 2, '2025-03', 2800000.00, 50000.00, 0.00, 2850000.00, 'chua_thanh_toan', '2025-11-07 22:59:31', '2025-12-01 00:00:00', NULL, 0.00, 0),
(26, 1, '2025-12', 2500000.00, 2650000.00, 0.00, 5150000.00, 'da_huy', '2025-11-07 22:59:31', '2025-12-01 00:00:00', NULL, 0.00, 0),
(35, 3, '2025-02', 3000000.00, 250000.00, 0.00, 3250000.00, 'chua_thanh_toan', '2025-11-08 11:29:54', '2025-11-15 00:00:00', NULL, 0.00, 0),
(41, 1, '2026-01', 2500000.00, 2650000.00, 0.00, 5150000.00, 'chua_thanh_toan', '2025-11-08 12:05:59', '2025-12-01 00:00:00', NULL, 0.00, 0),
(47, 46, '2025-11', 3000000.00, 250000.00, 0.00, 3250000.00, 'chua_thanh_toan', '2025-11-08 20:38:30', '2025-11-19 00:00:00', NULL, 0.00, 0),
(48, 4, '2025-11', 3200000.00, 0.00, 0.00, 3200000.00, 'chua_thanh_toan', '2025-11-08 20:40:18', '2025-12-01 00:00:00', NULL, 0.00, 0),
(49, 5, '2025-11', 3500000.00, 0.00, 0.00, 3500000.00, 'chua_thanh_toan', '2025-11-08 20:40:18', '2025-12-01 00:00:00', NULL, 0.00, 0),
(50, 4, '2025-04', 3200000.00, 0.00, 0.00, 3200000.00, 'chua_thanh_toan', '2025-11-08 20:40:18', '2025-12-01 00:00:00', NULL, 0.00, 0),
(101, 101, '2025-11', 3100000.00, 200000.00, 0.00, 3300000.00, 'chua_thanh_toan', '2025-11-17 05:24:36', '2025-11-27 05:24:36', NULL, 0.00, 0),
(102, 102, '2025-11', 3200000.00, 200000.00, 0.00, 3400000.00, 'chua_thanh_toan', '2025-11-17 05:24:36', '2025-11-27 05:24:36', NULL, 0.00, 0),
(103, 103, '2025-11', 3300000.00, 200000.00, 0.00, 3500000.00, 'chua_thanh_toan', '2025-11-17 05:24:36', '2025-11-27 05:24:36', NULL, 0.00, 0),
(104, 104, '2025-11', 3400000.00, 200000.00, 0.00, 3600000.00, 'chua_thanh_toan', '2025-11-17 05:24:36', '2025-11-27 05:24:36', NULL, 0.00, 0),
(105, 105, '2025-11', 3500000.00, 200000.00, 0.00, 3700000.00, 'chua_thanh_toan', '2025-11-17 05:24:36', '2025-11-27 05:24:36', NULL, 0.00, 0);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `hop_dong`
--

CREATE TABLE `hop_dong` (
  `id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `phong_id` int(11) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `tien_coc` decimal(12,2) NOT NULL,
  `ghi_chu` text DEFAULT NULL,
  `trang_thai` enum('hieu_luc','ket_thuc','huy') NOT NULL DEFAULT 'hieu_luc',
  `url_file_hop_dong` varchar(500) DEFAULT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `hop_dong`
--

INSERT INTO `hop_dong` (`id`, `khach_thue_id`, `phong_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `tien_coc`, `ghi_chu`, `trang_thai`, `url_file_hop_dong`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 4, 1, '2025-01-01', '2025-12-31', 1000000.00, NULL, 'hieu_luc', 'hop_dong_files/xGEEc1laRSNZJJsEY3Ulkg1tblhuH2UIb6BPyNqT.pdf', '2025-10-11 11:36:01', '2025-11-01 07:31:57'),
(2, 4, 2, '2025-02-01', '2025-12-31', 2500000.00, NULL, 'hieu_luc', 'hd_2.pdf', '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(3, 5, 3, '2025-01-15', '2025-12-31', 2500000.00, NULL, 'huy', 'hd_3.pdf', '2025-10-11 11:36:01', '2025-10-23 20:20:07'),
(4, 5, 4, '2025-03-01', '2025-12-31', 2500000.00, NULL, 'hieu_luc', 'hd_4.pdf', '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(5, 4, 5, '2025-04-01', '2025-12-31', 3000000.00, NULL, 'hieu_luc', 'hd_5.pdf', '2025-10-11 11:36:01', '2025-10-11 11:36:01'),
(7, 5, 6, '2025-10-25', '2026-01-25', 2500000.00, NULL, 'hieu_luc', 'hop_dong_files/F9IcsHdbyC9cUDdA1xLJYMZEC8KJsiyeb19KVDY0.pdf', '2025-10-24 17:49:02', '2025-10-24 18:22:52'),
(46, 4, 3, '2025-11-19', '2025-12-16', 13000000.00, 'dÃ¢dad', 'hieu_luc', 'yeu_cau_files/iKqzcoXNmNhRsXRmj9dd4IUXYnvhNx41Hh4zQElB.pdf', '2025-11-08 13:38:15', '2025-11-08 20:38:15'),
(101, 101, 1, '2025-11-01', '2026-11-01', 2000000.00, 'Há»£p Ä‘á»“ng máº«u 1', 'hieu_luc', 'hd_2.pdf', '2025-11-17 05:24:36', '2025-11-17 05:24:36'),
(102, 102, 2, '2025-11-01', '2026-05-01', 2500000.00, 'Há»£p Ä‘á»“ng máº«u 2', 'hieu_luc', 'hd_2.pdf', '2025-11-17 05:24:36', '2025-11-17 05:24:36'),
(103, 103, 3, '2025-12-01', '2026-12-01', 3000000.00, 'Há»£p Ä‘á»“ng máº«u 3', 'hieu_luc', 'hd_2.pdf', '2025-11-17 05:24:36', '2025-11-17 05:24:36'),
(104, 104, 4, '2025-11-15', '2026-11-15', 2200000.00, 'Há»£p Ä‘á»“ng máº«u 4', 'hieu_luc', 'hd_2.pdf', '2025-11-17 05:24:36', '2025-11-17 05:24:36'),
(105, 105, 5, '2025-10-20', '2026-10-20', 2500000.00, 'Há»£p Ä‘á»“ng máº«u 5', 'hieu_luc', 'hd_2.pdf', '2025-11-17 05:24:36', '2025-11-17 05:24:36');

--
-- Báº«y `hop_dong`
--







-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `khach_thue`
--

CREATE TABLE `khach_thue` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `ngan_sach_min` decimal(12,2) NOT NULL,
  `ngan_sach_max` decimal(12,2) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `khach_thue`
--

INSERT INTO `khach_thue` (`id`, `nguoi_dung_id`, `ngan_sach_min`, `ngan_sach_max`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(4, 4, 1500000.00, 4000000.00, '2025-10-11 11:36:01', '2025-10-18 21:02:46'),
(5, 5, 2000000.00, 5000000.00, '2025-10-11 11:36:01', '2025-10-18 21:02:46'),
(12, 27, 0.00, 0.00, '2025-10-25 14:45:35', '2025-10-25 14:45:35'),
(101, 201, 2000000.00, 4000000.00, '2025-11-17 05:24:36', '2025-11-17 05:26:36'),
(102, 202, 2500000.00, 4500000.00, '2025-11-17 05:24:36', '2025-11-17 05:26:36'),
(103, 203, 3000000.00, 5000000.00, '2025-11-17 05:24:36', '2025-11-17 05:26:36'),
(104, 204, 1800000.00, 3500000.00, '2025-11-17 05:24:36', '2025-11-17 05:26:36'),
(105, 205, 2200000.00, 4200000.00, '2025-11-17 05:24:36', '2025-11-17 05:26:36'),
(106, 206, 0.00, 0.00, '2025-11-19 20:11:54', '2025-11-19 20:11:54');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2025_10_19_104104_add_hopdong_triggers', 2),
(15, '2025_10_23_075027_add_edit_tracking_to_chi_so_table', 3),
(16, '2025_10_24_041103_add_so_tien_da_tra_to_hoa_don_table', 3),
(17, '0001_01_01_000002_create_jobs_table', 3),
(18, '0001_01_01_000002_create_jobs_table', 3),
(19, '2025_11_10_000001_add_columns_to_so_thich', 4),
(20, '2025_11_10_000000_add_unique_constraint_so_thich_nguoi_dung', 5),
(21, '2025_11_10_000002_change_ten_columns_to_text', 6);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` enum('quan_tri','chu_tro','khach_thue') NOT NULL,
  `trang_thai` enum('hoat_dong','da_khoa','chua_xac_thuc') NOT NULL DEFAULT 'chua_xac_thuc',
  `anh_dai_dien` varchar(500) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `so_dien_thoai`, `email`, `mat_khau`, `vai_tro`, `trang_thai`, `anh_dai_dien`, `ngay_tao`, `ngay_cap_nhat`, `is_verified`) VALUES
(1, 'Admin Há»‡ Thá»‘ng', '0909000001', 'admin@gmail.com', '123456', 'quan_tri', 'hoat_dong', 'admin.png', '2025-10-11 11:36:01', '2025-10-11 11:36:01', 0),
(2, 'Duy Báº£o', '0909000002', 'baotranduy666666@gmail.com', '123456', 'chu_tro', 'hoat_dong', '/storage/avatars/011q9vJr4LDvbwzG2YcWxT3UUjzY2cFMnltRgl21.jpg', '2025-10-11 11:36:01', '2025-11-05 13:12:51', 0),
(3, 'Tráº§n Thá»‹ BÃ¬nh', '0909000003', 'chutro2@gmail.com', '123456', 'chu_tro', 'hoat_dong', 'chutro2.png', '2025-10-11 11:36:01', '2025-10-11 11:36:01', 0),
(4, 'LÃª VÄƒn Kiá»‡t', '0909000004', 'tranduybao1005@gmail.com', '123456', 'khach_thue', 'hoat_dong', 'avatars/wfEVCnS6j11hFhykpFtitwZbtsNu7eImHaDxkmzu.png', '2025-10-11 11:36:01', '2025-11-05 13:14:53', 0),
(5, 'Pháº¡m Thá»‹ Linh', '0909000005', 'khach2@gmail.com', '123456', 'khach_thue', 'hoat_dong', 'khach2.png', '2025-10-11 11:36:01', '2025-10-11 11:36:01', 0),
(27, 'tran ly', '0321564897', 'ly2@gmail.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-10-25 07:45:35', '2025-10-25 07:45:35', 0),
(101, 'Nguyá»…n VÄƒn Háº£i', '0901234567', 'chu1@example.com', '123456', 'chu_tro', 'hoat_dong', '', '2025-11-17 05:23:51', '2025-11-17 05:23:51', 0),
(102, 'Tráº§n HoÃ ng Duy', '0902234567', 'chu2@example.com', '123456', 'chu_tro', 'hoat_dong', '', '2025-11-17 05:23:51', '2025-11-17 05:23:51', 0),
(103, 'LÃª Minh TÃ¢m', '0903234567', 'chu3@example.com', '123456', 'chu_tro', 'hoat_dong', '', '2025-11-17 05:23:51', '2025-11-17 05:23:51', 0),
(104, 'Pháº¡m Quá»‘c Báº£o', '0904234567', 'chu4@example.com', '123456', 'chu_tro', 'hoat_dong', '', '2025-11-17 05:23:51', '2025-11-17 05:23:51', 0),
(105, 'VÃµ Thanh Phong', '0905234567', 'chu5@example.com', '123456', 'chu_tro', 'hoat_dong', '', '2025-11-17 05:23:51', '2025-11-17 05:23:51', 0),
(201, 'Nguyá»…n VÄƒn Lá»™c', '0981111111', 'khach1@example.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-17 05:24:03', '2025-11-17 05:24:03', 0),
(202, 'Pháº¡m Thá»‹ Minh', '0982222222', 'khach2@example.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-17 05:24:03', '2025-11-17 05:24:03', 0),
(203, 'Tráº§n KhÃ¡nh Duy', '0983333333', 'khach3@example.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-17 05:24:03', '2025-11-17 05:24:03', 0),
(204, 'Mai Quá»‘c ThÃ¡i', '0984444444', 'khach4@example.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-17 05:24:03', '2025-11-17 05:24:03', 0),
(205, 'HoÃ ng Má»¹ Chi', '0985555555', 'khach5@example.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-17 05:24:03', '2025-11-17 05:24:03', 0),
(206, 'Tran Chi Cuong', '09876654321', 'cuong01062004@gmail.com', '123456', 'khach_thue', 'hoat_dong', '', '2025-11-19 13:11:54', '2025-11-19 13:11:54', 0);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `nguoi_than`
--

CREATE TABLE `nguoi_than` (
  `id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `moi_quan_he` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `nguoi_than`
--

INSERT INTO `nguoi_than` (`id`, `khach_thue_id`, `ho_ten`, `so_dien_thoai`, `moi_quan_he`) VALUES
(1, 4, 'Nguyá»…n VÄƒn Äáº¡t', '0911000001', 'Cha'),
(2, 4, 'Nguyá»…n Thá»‹ Diá»‡u', '0911000002', 'Máº¹'),
(3, 5, 'Pháº¡m VÄƒn Anh', '0911000003', 'Anh trai'),
(4, 5, 'Pháº¡m Thá»‹ TrÃºc', '0911000004', 'Em gÃ¡i'),
(64, 4, 'bao co bap', '0854154248', 'ban'),
(65, 4, 'bao co bap', '0854154248', 'ban'),
(66, 4, 'bao co bap', '0854154248', 'ban'),
(67, 4, 'bao co bap', '0854154248', 'ban');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\NguoiDung', 8, 'api', 'dfedef9e1df3e95f4f8d9d9eb211e8477e25a665b0a6ff8328e697a6ff757cf8', '[\"*\"]', NULL, NULL, '2025-10-11 01:38:31', '2025-10-11 01:38:31'),
(4, 'App\\Models\\NguoiDung', 10, 'api', '7c898b07c3543ded9c87feeba0e65ac6c7c4c4a10f43720289ef4cd40d30ed04', '[\"*\"]', NULL, NULL, '2025-10-11 01:44:23', '2025-10-11 01:44:23'),
(8, 'App\\Models\\NguoiDung', 11, 'api', 'cc98a1839d0b728137c456e34ecefc8586a31325c0e14595241d5510c188629e', '[\"*\"]', NULL, NULL, '2025-10-11 02:16:05', '2025-10-11 02:16:05'),
(11, 'App\\Models\\NguoiDung', 12, 'api', 'b822982063c8cd67e52c1bc97144cf26e5a9d28b154b21ff8b3b6c55d9530901', '[\"*\"]', NULL, NULL, '2025-10-11 02:24:07', '2025-10-11 02:24:07'),
(17, 'App\\Models\\NguoiDung', 2, 'test-token', '83eb04ab93314feb3b8717f0f1b8ad3f470234ac4d2ceae859e3c82162fdfa81', '[\"*\"]', '2025-10-11 06:51:20', NULL, '2025-10-11 06:50:12', '2025-10-11 06:51:20'),
(22, 'App\\Models\\NguoiDung', 2, 'api', '5e64c3cfba493803a4410ee5b8ecca8a6397f085707577bc250ecceb2130d4e0', '[\"*\"]', '2025-10-11 07:57:57', NULL, '2025-10-11 07:57:44', '2025-10-11 07:57:57'),
(24, 'App\\Models\\NguoiDung', 2, 'api', 'f53563c733abef67a578155d244cd8785124d6155bcce81510f62c8737da48cd', '[\"*\"]', '2025-10-17 07:00:28', NULL, '2025-10-17 07:00:11', '2025-10-17 07:00:28'),
(25, 'App\\Models\\NguoiDung', 2, 'api', '281f01831a93b7060c9f69cf7936fd98ea7c1f08afa351c8b04ce21a72851eef', '[\"*\"]', '2025-10-18 00:37:33', NULL, '2025-10-18 00:37:14', '2025-10-18 00:37:33'),
(26, 'App\\Models\\NguoiDung', 2, 'api', 'af56d1aa6998cd044131a01917730bbbcc398aa086bc1269eb9b8d7b3c27184a', '[\"*\"]', '2025-10-18 01:26:41', NULL, '2025-10-18 01:26:24', '2025-10-18 01:26:41'),
(28, 'App\\Models\\NguoiDung', 2, 'api', '9f45e1b47b78e11e279d056451c25d6027bd6fc41d317a01fd8478dfa49a855c', '[\"*\"]', '2025-10-18 02:18:40', NULL, '2025-10-18 01:57:29', '2025-10-18 02:18:40'),
(35, 'App\\Models\\NguoiDung', 2, 'api', 'd0eed545f03652b43dfc34384f901e4c7869b2be0aff9dc22c978f55fcdc2a31', '[\"*\"]', '2025-10-18 09:28:01', NULL, '2025-10-18 09:25:28', '2025-10-18 09:28:01'),
(38, 'App\\Models\\NguoiDung', 2, 'api', '8c1a071581f0b90cc3698c397ba30bbaf8d3eb4e803c53e8e66b5dce3f27d2aa', '[\"*\"]', '2025-10-18 22:06:43', NULL, '2025-10-18 21:31:29', '2025-10-18 22:06:43'),
(39, 'App\\Models\\NguoiDung', 2, 'api', 'c95ad0f5e04f9738827399fccf0e67ebc2f572f16bbae477c0c8ef45f624a553', '[\"*\"]', '2025-10-19 04:16:03', NULL, '2025-10-19 03:44:20', '2025-10-19 04:16:03'),
(44, 'App\\Models\\NguoiDung', 2, 'api', '50c3d6672aae85ca577710260289c671ef7e5243699705c932d0afb52ab83327', '[\"*\"]', '2025-10-19 09:24:21', NULL, '2025-10-19 09:23:03', '2025-10-19 09:24:21'),
(47, 'App\\Models\\NguoiDung', 2, 'api', '6b12976251a2ee6069d12a4214caeaa4965fdc19db8bb44415befbb990d13105', '[\"*\"]', '2025-10-20 01:42:27', NULL, '2025-10-19 23:33:37', '2025-10-20 01:42:27'),
(48, 'App\\Models\\NguoiDung', 2, 'api', '7434b8ad8477e316b9b1ae2e9f92ad44b1a3d5163bae429f4b08eafda62a2e17', '[\"*\"]', '2025-10-21 20:34:52', NULL, '2025-10-21 20:30:55', '2025-10-21 20:34:52'),
(49, 'App\\Models\\NguoiDung', 2, 'api', '3a0a48d3611d31a340d39a6f16177300f4b1b3d1a6866699acfe02a03b4dea72', '[\"*\"]', '2025-10-21 20:38:56', NULL, '2025-10-21 20:38:47', '2025-10-21 20:38:56'),
(55, 'App\\Models\\NguoiDung', 2, 'api', 'f4a9de54a9df946eb676cf7d76b8114851f47775fbd292de94fc3ce0e2035439', '[\"*\"]', '2025-10-22 04:50:55', NULL, '2025-10-22 04:12:44', '2025-10-22 04:50:55'),
(57, 'App\\Models\\NguoiDung', 2, 'api', '442528373fa0f7a8dbfdc9ad7bfb382d6da2006ec8aedb85a80ff8f39c10b1a9', '[\"*\"]', '2025-10-22 08:38:56', NULL, '2025-10-22 07:17:14', '2025-10-22 08:38:56'),
(62, 'App\\Models\\NguoiDung', 2, 'api', '78f5b2f790faed74011c77601be291447ca7bb4468281772b72e654f0dd80fe4', '[\"*\"]', NULL, NULL, '2025-10-22 23:42:03', '2025-10-22 23:42:03'),
(63, 'App\\Models\\NguoiDung', 2, 'api', '6b7056f233bee6df099bc092d184e300ac6bc9e3314b7366389864aec2063456', '[\"*\"]', NULL, NULL, '2025-10-22 23:42:17', '2025-10-22 23:42:17'),
(64, 'App\\Models\\NguoiDung', 2, 'api', 'b3821d06283df0577e399122deb51a04655e02753a38c6558f52986317f2bc2c', '[\"*\"]', '2025-11-01 00:23:15', NULL, '2025-10-22 23:45:29', '2025-11-01 00:23:15'),
(66, 'App\\Models\\NguoiDung', 2, 'api_token', 'ce2255eb9df33d9dcf5bb2c743f86223126ec22ca9ec9ac6055faf40bf4417d9', '[\"chu_tro\"]', '2025-10-22 23:52:09', NULL, '2025-10-22 23:52:00', '2025-10-22 23:52:09'),
(68, 'App\\Models\\NguoiDung', 2, 'api', '5077bd1ccdd42645748eab1510c34420bde24169948cb577550d295f18426d2d', '[\"*\"]', '2025-10-23 01:59:02', NULL, '2025-10-23 00:36:03', '2025-10-23 01:59:02'),
(71, 'App\\Models\\NguoiDung', 2, 'api', '2c0f71e134ff17eeddae9fb9822c026d38ebef853ade7dd0d0418c8bbce2a9f9', '[\"*\"]', '2025-10-23 09:07:31', NULL, '2025-10-23 07:48:17', '2025-10-23 09:07:31'),
(73, 'App\\Models\\NguoiDung', 2, 'api', 'aeb9f4cf578f5d35943d4d3b585ab2490acd4276bd4e10ed7bdd7fb48f88e2de', '[\"*\"]', '2025-10-24 02:47:38', NULL, '2025-10-24 02:39:52', '2025-10-24 02:47:38'),
(74, 'App\\Models\\NguoiDung', 2, 'api', '3e95d2fe05a6bd6dfdee5a3443641cfdac4431779f8a66688efdd5a2b9900c79', '[\"*\"]', '2025-10-24 05:54:00', NULL, '2025-10-24 05:53:42', '2025-10-24 05:54:00'),
(76, 'App\\Models\\NguoiDung', 2, 'api', '9c5c896b1ad18e67743822bfc49b90bcb3e79c86ffd38b1e7e26c5bb65a141c1', '[\"*\"]', '2025-10-24 11:50:54', NULL, '2025-10-24 08:29:47', '2025-10-24 11:50:54'),
(80, 'App\\Models\\NguoiDung', 15, 'api', '602b59a89822a61be6d6759cc3c4a24e4b92e5251cc6f270bbd6debdcc17b8fe', '[\"*\"]', NULL, NULL, '2025-10-24 21:22:28', '2025-10-24 21:22:28'),
(88, 'App\\Models\\NguoiDung', 18, 'api', '8824fac8a32d37c79924f543c5ba1d3e2b0d535f17a26121ffa2f693f07977f2', '[\"*\"]', NULL, NULL, '2025-10-24 21:48:05', '2025-10-24 21:48:05'),
(95, 'App\\Models\\NguoiDung', 21, 'api', '48122a64148ae6cb57efaa4b4624480be4186d63e107e66847af762e7e3db2ef', '[\"*\"]', NULL, NULL, '2025-10-24 22:42:33', '2025-10-24 22:42:33'),
(97, 'App\\Models\\NguoiDung', 24, 'api', 'd6841ec398de359b22b742219639abe470c702a24406de5c1d649ec1a1a23e56', '[\"*\"]', NULL, NULL, '2025-10-24 22:50:15', '2025-10-24 22:50:15'),
(98, 'App\\Models\\NguoiDung', 25, 'api', '063300ec79c95eea4a8286d25e49cf2dd43fbd04d7977ba30be8a0e64b9782b0', '[\"*\"]', NULL, NULL, '2025-10-24 22:51:05', '2025-10-24 22:51:05'),
(101, 'App\\Models\\NguoiDung', 26, 'api', '4f4d998dc4eba55bc08589d6367d4e67e8a5ec1cba8a6e9976283ea75c57c1d3', '[\"*\"]', NULL, NULL, '2025-10-24 23:46:04', '2025-10-24 23:46:04'),
(104, 'App\\Models\\NguoiDung', 27, 'api', '0ede0ae035ede9864cc5b087a66a595a5b967a26e182935e0dff0f26ef331781', '[\"*\"]', NULL, NULL, '2025-10-25 00:45:35', '2025-10-25 00:45:35'),
(106, 'App\\Models\\NguoiDung', 2, 'api', '3b90fc9e6468ea733a5213747bdcfe94cf9bdb8f642f860bfc7996f679cde0e4', '[\"*\"]', '2025-10-25 01:02:01', NULL, '2025-10-25 00:45:58', '2025-10-25 01:02:01'),
(107, 'App\\Models\\NguoiDung', 2, 'api', '25767627866dceca1b19e036f8fe3e759241804eb704d4005afd6007ca6b61ae', '[\"*\"]', '2025-10-25 23:47:28', NULL, '2025-10-25 20:01:51', '2025-10-25 23:47:28'),
(108, 'App\\Models\\NguoiDung', 2, 'api', 'f2d7a9454f488f82d664d1eddb9809b0e9b286eb4432078724044aa4c53e0ba3', '[\"*\"]', '2025-10-26 06:53:37', NULL, '2025-10-26 06:21:47', '2025-10-26 06:53:37'),
(110, 'App\\Models\\NguoiDung', 1, 'api', '68f312e8f6761af0dc0288d4ac40572175c4ee3ad78a23b7751e9456c03400a0', '[\"*\"]', NULL, NULL, '2025-10-31 11:08:32', '2025-10-31 11:08:32'),
(113, 'App\\Models\\NguoiDung', 1, 'api', 'ce8f1c36ee907f0b809bf568f25496e85ff4a0e767ca2b41b1d5dce3f2d2841f', '[\"*\"]', NULL, NULL, '2025-10-31 19:16:03', '2025-10-31 19:16:03'),
(122, 'App\\Models\\NguoiDung', 4, 'api', '3940900a32b5e956f57ca05e2a7a784bc4554aaa8d726790842630028e119fe8', '[\"*\"]', '2025-10-31 21:20:15', NULL, '2025-10-31 21:20:15', '2025-10-31 21:20:15'),
(124, 'App\\Models\\NguoiDung', 4, 'api', '3c535a3b59e1d5db7b0c9a40333359f05ae8bc10fb1de9a83b311302f0268308', '[\"*\"]', '2025-10-31 21:36:20', NULL, '2025-10-31 21:36:20', '2025-10-31 21:36:20'),
(126, 'App\\Models\\NguoiDung', 4, 'api', 'a4325197b8e86619d95beb2688c57d6acc47a6599650f5ae1ca4e19d63597e13', '[\"*\"]', '2025-10-31 21:48:55', NULL, '2025-10-31 21:48:55', '2025-10-31 21:48:55'),
(132, 'App\\Models\\NguoiDung', 2, 'api', '8d7845e065c5c6e97ba25b94a1310d71da38085545f47880957fa2eef045e134', '[\"*\"]', '2025-10-31 22:42:09', NULL, '2025-10-31 22:41:51', '2025-10-31 22:42:09'),
(144, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ca98f49c464432bd886b8ae5bb2f7e651141d842eb425cfc9deac5f678345560', '[\"read\"]', NULL, NULL, '2025-11-01 00:44:20', '2025-11-01 00:44:20'),
(145, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7f3d199bb8184144aab4813d4085776cd50e340a0ad469561984acd37d1fcde0', '[\"read\"]', NULL, NULL, '2025-11-01 00:44:23', '2025-11-01 00:44:23'),
(146, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3a98a862e28bd69f3e51b556ff869d09b7b430110790178e3d180d013d572dd1', '[\"read\"]', NULL, NULL, '2025-11-01 00:44:26', '2025-11-01 00:44:26'),
(147, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5b655f01e0735f67feac972f7268e0c1e7fb4ed0afead81e5ec4b30439f7a699', '[\"read\"]', NULL, NULL, '2025-11-01 00:47:53', '2025-11-01 00:47:53'),
(148, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3cf07cf3e88d1ab0e43080feec4772be835bdc0141d287a408cc9d6ca51a8279', '[\"read\"]', NULL, NULL, '2025-11-01 00:47:56', '2025-11-01 00:47:56'),
(149, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e141f2c0f62f381f51f780de2fbcf89d230dba5077f1000c79828c60b17ee364', '[\"read\"]', NULL, NULL, '2025-11-01 00:47:58', '2025-11-01 00:47:58'),
(150, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ba49fa9df16fd1fe18b807cc5cec79de1951a464459bc04aeb8027331babcaf4', '[\"read\"]', NULL, NULL, '2025-11-01 00:50:45', '2025-11-01 00:50:45'),
(151, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '98c88c84c12620d05bf36c14754b8f0d53197ea7658c2853f5e68a6e83cda049', '[\"read\"]', NULL, NULL, '2025-11-01 00:50:50', '2025-11-01 00:50:50'),
(152, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd85149b5a9934ed59a509bedd674c4ca05cedfcf809c3026f9fd38f314bf4644', '[\"read\"]', NULL, NULL, '2025-11-01 00:50:52', '2025-11-01 00:50:52'),
(153, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '83cc3f4a11c1dd55e4915abe65bf1132edaeb38cd219817e8f465c653a100186', '[\"read\"]', NULL, NULL, '2025-11-01 00:53:23', '2025-11-01 00:53:23'),
(154, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd9f58878190e26efd14616526b2d37aef56d8caacf50d9e846401debf6d463b0', '[\"read\"]', NULL, NULL, '2025-11-01 00:53:31', '2025-11-01 00:53:31'),
(155, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'bf7576cafe860f45e2113db22743a630973be7144e65eaad33873b8a76f0c356', '[\"read\"]', NULL, NULL, '2025-11-01 00:53:34', '2025-11-01 00:53:34'),
(156, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e58ea65c84bb64031d721baa43e32ab4e06038bc1520fee14eb995611ccaa073', '[\"read\"]', NULL, NULL, '2025-11-01 00:53:37', '2025-11-01 00:53:37'),
(157, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5975b38347286dce521968dbcdc843e1e33862ef16bf8534ecd6c75f0c3715db', '[\"read\"]', NULL, NULL, '2025-11-01 00:55:30', '2025-11-01 00:55:30'),
(158, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '26984261ca3e0ba8877b660bb92770f95dd879267628dbc9f3e5bb96b56db18b', '[\"read\"]', NULL, NULL, '2025-11-01 00:55:47', '2025-11-01 00:55:47'),
(159, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '9af92e94d77af5d7a78580c7b5b17d6d52c7902385bf3b21634aad3494febfc8', '[\"read\"]', NULL, NULL, '2025-11-01 00:55:53', '2025-11-01 00:55:53'),
(161, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7aff0a81941b931db5d35f1e3af99480150fa25aaaf444cb634512ca8707ea07', '[\"read\"]', NULL, NULL, '2025-11-01 02:08:07', '2025-11-01 02:08:07'),
(162, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'b9b3591bf39182d2ea947a9f7a338b9578f74ee65afc14c349c32ba623f34e71', '[\"read\"]', NULL, NULL, '2025-11-01 02:20:53', '2025-11-01 02:20:53'),
(163, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2dd40464cc3a508795ab69295924baa286d39aa3d4e04af6e3848bf332c69d25', '[\"read\"]', NULL, NULL, '2025-11-01 02:34:34', '2025-11-01 02:34:34'),
(164, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c398b18cfff665cea21b2befd35c6ee8f0a04452d2033932b016bd8f985f7383', '[\"read\"]', NULL, NULL, '2025-11-01 02:51:22', '2025-11-01 02:51:22'),
(165, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'b6bd831c85f4bfb3ef4825b3764deeff341d8e3462a8dc4cc7c947527ac94310', '[\"read\"]', NULL, NULL, '2025-11-01 02:54:14', '2025-11-01 02:54:14'),
(166, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2915a70ceac76374b72aa55834d74844f11fd78dd8ac7f2c7f4330fb64e302f7', '[\"read\"]', NULL, NULL, '2025-11-01 02:54:20', '2025-11-01 02:54:20'),
(167, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'db977b5beac5892a74abd9f9a0fea12bcbe183447909b08eb3acc54c7afa8e40', '[\"read\"]', NULL, NULL, '2025-11-01 04:19:30', '2025-11-01 04:19:30'),
(168, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7214d60499341ce207ccfee8c0a5359b5531eb4c78c0fab9ac633a4ac18a4988', '[\"read\"]', NULL, NULL, '2025-11-01 04:32:14', '2025-11-01 04:32:14'),
(169, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6398babd8c3cb0966a861efc27951beb698820258fccc32c6fb7f29d8e50ee04', '[\"read\"]', NULL, NULL, '2025-11-01 04:33:09', '2025-11-01 04:33:09'),
(170, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5d84f65a160c4a8943600da2676d9aec81a9b6bbca0d7976459fcd6b2c4fbe61', '[\"read\"]', NULL, NULL, '2025-11-01 04:33:34', '2025-11-01 04:33:34'),
(171, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3b77bde25ae3bfa50713aff3d426631732dde911dc3b99beb52a002b20a1526a', '[\"read\"]', NULL, NULL, '2025-11-01 04:38:03', '2025-11-01 04:38:03'),
(172, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '32eb3c8a1a9bc0fba67075813d7d02cfe612661211f0e896f1a0e30b15a2d4bc', '[\"read\"]', NULL, NULL, '2025-11-01 04:38:22', '2025-11-01 04:38:22'),
(173, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c5d83fe6a073b53c53c8659c7daea7cd8f22b1ac5361ddeacb426596924b1c6b', '[\"read\"]', NULL, NULL, '2025-11-01 04:38:22', '2025-11-01 04:38:22'),
(174, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '949e02c6ccb0861f29b109f6f61243a3f17c0e4b5d1917b0e49f82d0c755abf2', '[\"read\"]', NULL, NULL, '2025-11-01 04:38:46', '2025-11-01 04:38:46'),
(175, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '9823058292b39b204117adb38156761665474167bb5a371d365df5860ad59a1b', '[\"read\"]', NULL, NULL, '2025-11-01 04:42:08', '2025-11-01 04:42:08'),
(176, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '88da87e03765a09b6266cad7435b843cd3c2d394d387f58a5cfb94021f3ec1ba', '[\"read\"]', NULL, NULL, '2025-11-01 04:48:15', '2025-11-01 04:48:15'),
(177, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3ddf7b0712cb05d33dc21aa97199291f93508231ec734af705dbb4fa880719da', '[\"read\"]', NULL, NULL, '2025-11-01 04:55:02', '2025-11-01 04:55:02'),
(178, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '651dd1a4fcf69b824ce9c5e0deac368c62ef047760c9fb4e62bd0e708312add0', '[\"read\"]', NULL, NULL, '2025-11-01 04:55:06', '2025-11-01 04:55:06'),
(180, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'bd269955df64ff0fcf705774e77a0cfb38ea615b7b7b7755f9ac8cc7a34d5f5f', '[\"read\"]', NULL, NULL, '2025-11-01 04:56:12', '2025-11-01 04:56:12'),
(181, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '4761010ac75f5e74f15f55d8c9645349b2a20cddbd30398c8430a34d1f67eb34', '[\"read\"]', NULL, NULL, '2025-11-01 04:56:23', '2025-11-01 04:56:23'),
(182, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'e07cccecd7476389ccc859a61b67264a19317dcc38cc13ef79f01c7bf87552b1', '[\"read\"]', NULL, NULL, '2025-11-01 04:56:34', '2025-11-01 04:56:34'),
(183, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '03eac50bc543e749217be0c3d48f77e0c67b8a89c33d17ed61cd9b139c98b459', '[\"read\"]', NULL, NULL, '2025-11-01 04:56:45', '2025-11-01 04:56:45'),
(184, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '6b87da4ed30c6d4161caf19d6a6cfdc64adce4f2dc12dd324e77ecd54b2f376f', '[\"read\"]', NULL, NULL, '2025-11-01 04:56:56', '2025-11-01 04:56:56'),
(186, 'App\\Models\\NguoiDung', 4, 'api', '469de1d8790dc0fcc07c572ec0408b76698fe3154b41df6fc1f8b6c946430824', '[\"*\"]', '2025-11-01 05:10:41', NULL, '2025-11-01 04:57:55', '2025-11-01 05:10:41'),
(187, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '84df623ddeb9cdaf81a2f2f490560b05efed460cbcd6fd2bcdd812171ceafac5', '[\"read\"]', NULL, NULL, '2025-11-01 04:57:58', '2025-11-01 04:57:58'),
(188, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'fd1bd0df1499b32b602eba5576182b041cfa775d0e92ebc79eb0123f5743da17', '[\"read\"]', NULL, NULL, '2025-11-01 04:58:01', '2025-11-01 04:58:01'),
(189, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6d971863d8d4129cd26fe1e7fa1c7c1995c6bebe0aeb545265d1e8f3c7839be7', '[\"read\"]', NULL, NULL, '2025-11-01 05:03:43', '2025-11-01 05:03:43'),
(190, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '44f800ab872352bc23d16f659b833ce7109af8fa076c5412e2d4ff30b817be53', '[\"read\"]', NULL, NULL, '2025-11-01 05:03:48', '2025-11-01 05:03:48'),
(191, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8d84753cd963c2b15b8876647dcaff61e57b6a92af9d191bb65181b0d8a878dc', '[\"read\"]', NULL, NULL, '2025-11-01 05:03:54', '2025-11-01 05:03:54'),
(192, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '871799f89d9a0d702fee6d89a491f58d658ef817cbc364f53bd853f97e3384f6', '[\"read\"]', NULL, NULL, '2025-11-01 05:04:54', '2025-11-01 05:04:54'),
(193, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '537f477f969291b2ccaa2f6f0d2ea042b32e556af17d71a1409527bcdb9cbad9', '[\"read\"]', NULL, NULL, '2025-11-01 05:05:06', '2025-11-01 05:05:06'),
(194, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ffe0d969f42aa3ea78032a57fd031b49c00ec2ea8ea1552e14be7b5e7a16f1ee', '[\"read\"]', NULL, NULL, '2025-11-01 05:05:07', '2025-11-01 05:05:07'),
(195, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '026c45946b689e4c428c2613957de86bfc3360044fe24d00b0b3acb36e4627f2', '[\"read\"]', NULL, NULL, '2025-11-01 05:07:41', '2025-11-01 05:07:41'),
(196, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '05d5cd3cc8660cb8ccca72e0cc979be72698822d8165bed422848dee5b3d08d9', '[\"read\"]', NULL, NULL, '2025-11-01 05:10:41', '2025-11-01 05:10:41'),
(210, 'App\\Models\\NguoiDung', 1, 'api', '6af3e53b73c56bb1fbec7cdc674d5b0157e690e297efcf825efac446713243f3', '[\"*\"]', '2025-11-03 08:23:40', NULL, '2025-11-03 08:23:40', '2025-11-03 08:23:40'),
(223, 'App\\Models\\NguoiDung', 1, 'api', '450f315c8371fd8baa69816b0e4b58cc10efe4b4d0ec1ad80be59f3324098192', '[\"*\"]', '2025-11-04 02:42:47', NULL, '2025-11-04 02:42:23', '2025-11-04 02:42:47'),
(224, 'App\\Models\\NguoiDung', 4, 'api', 'f6efbbaf6e7d58606add51504a7fbba813d7b8ab7adb17e432c2f98562c1c4be', '[\"*\"]', '2025-11-04 07:03:38', NULL, '2025-11-04 07:03:29', '2025-11-04 07:03:38'),
(235, 'App\\Models\\NguoiDung', 2, 'api', '1d16c727bc3264eff3030e654e48173bf04d934500e175f40f0d5b9e7b66bd92', '[\"*\"]', '2025-11-04 21:10:46', NULL, '2025-11-04 21:09:37', '2025-11-04 21:10:46'),
(243, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'cff50766e6d104f6233f24cae83b83ad88d7a2915c56257f8cbded4c4bea7989', '[\"read\"]', NULL, NULL, '2025-11-04 21:39:01', '2025-11-04 21:39:01'),
(244, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e5e1778cb21804520871f3c77a0c637ba6f299190035d2f093503c9ebebf9ed2', '[\"read\"]', NULL, NULL, '2025-11-04 21:41:04', '2025-11-04 21:41:04'),
(249, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'a4f5ef9be87635cefceb96aa0cd213c1cda100b9e39388a2a29cbabfad7b3747', '[\"read\"]', NULL, NULL, '2025-11-04 21:51:55', '2025-11-04 21:51:55'),
(258, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5db9e8eb25eb7fe977d56712358ee6314f236c7f3cd18b8084b169789ebb1652', '[\"read\"]', NULL, NULL, '2025-11-04 22:36:24', '2025-11-04 22:36:24'),
(264, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ef12050d387a3804949110afec96541f28a416ad975116664aebefd07e716567', '[\"read\"]', NULL, NULL, '2025-11-04 23:15:20', '2025-11-04 23:15:20'),
(267, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8dbc00d27071e7929a3ef50c5c4f08ba6ab0527ed24c221a3e937a4c105ace54', '[\"read\"]', NULL, NULL, '2025-11-04 23:28:48', '2025-11-04 23:28:48'),
(270, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '01628acd0e909f7af5aa8d704f7e455a32864c8451701a62317426c27effc9d4', '[\"read\"]', NULL, NULL, '2025-11-04 23:38:49', '2025-11-04 23:38:49'),
(274, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '55ecbd6419086069f39b38f71b22ecd049bb38c5b56a75637fb6f0383e2737fd', '[\"read\"]', NULL, NULL, '2025-11-04 23:42:42', '2025-11-04 23:42:42'),
(277, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c5593bfed331ab91bc8bdf1174845894c416fbcbee0b3101b9ec7efe78e744a8', '[\"read\"]', NULL, NULL, '2025-11-04 23:48:30', '2025-11-04 23:48:30'),
(278, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd6e82dd375b66ce70441f4298859f8dd85ea4c73f3e8f5edb96f4f969f6f3099', '[\"read\"]', NULL, NULL, '2025-11-04 23:48:38', '2025-11-04 23:48:38'),
(279, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7e24deab184ba44a03b455aea515c9c7799c5b8a0b618d0950486782e7ff8732', '[\"read\"]', NULL, NULL, '2025-11-05 00:06:51', '2025-11-05 00:06:51'),
(280, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6509c78d91c919d20053794f9a19bcb3691d9a4c3a491771d790fc0ed2a674cd', '[\"read\"]', NULL, NULL, '2025-11-05 00:07:01', '2025-11-05 00:07:01'),
(281, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '06e5e79f13f07f157e778e7354d1d24c5898b575e48c51dc45488b84f21b11ed', '[\"read\"]', NULL, NULL, '2025-11-05 00:08:50', '2025-11-05 00:08:50'),
(282, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'dda7b461fea966164b9d2c61c55bc64e2cb165f0e85218a3acd15195d28c43f3', '[\"read\"]', NULL, NULL, '2025-11-05 00:10:05', '2025-11-05 00:10:05'),
(283, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '67d8ce7a5bf07319e30e66c9225cdd62d4aadfba8c207a39766e6cbbf25442ee', '[\"read\"]', NULL, NULL, '2025-11-05 00:14:13', '2025-11-05 00:14:13'),
(284, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '915a00df26932ed7522a370ef53670836d751e1d4a33ffe6d238b68a0fcf6a22', '[\"read\"]', NULL, NULL, '2025-11-05 00:15:55', '2025-11-05 00:15:55'),
(285, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd1f178b7ed951263d0d3c490e7f19a1aa80bfab9ea4c99d11f4f5b8ea0e59331', '[\"read\"]', NULL, NULL, '2025-11-05 00:16:09', '2025-11-05 00:16:09'),
(287, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '557b5ec710c0f6d4611bfd841a6d3ab915dfc8a0b4ba685de01b0cb9dd16a069', '[\"read\"]', NULL, NULL, '2025-11-05 00:18:44', '2025-11-05 00:18:44'),
(288, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e9c3ad02ed600423a47d0deae3b2b623849ad1243a629c4d615f014621dfec34', '[\"read\"]', NULL, NULL, '2025-11-05 00:31:07', '2025-11-05 00:31:07'),
(289, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '130a649fda679169bdf42b3a0d144858bc33c19a70109528245a4695c3457b91', '[\"read\"]', NULL, NULL, '2025-11-05 00:34:10', '2025-11-05 00:34:10'),
(290, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '353af79c203e769f35c3b4769a0420820c1d92b12720d416486095f249ea014f', '[\"read\"]', NULL, NULL, '2025-11-05 00:44:08', '2025-11-05 00:44:08'),
(293, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c795f35a79d7a313392cfdd392a6259988143cae205e06f1b8f32b3101a86eaa', '[\"read\"]', NULL, NULL, '2025-11-05 00:49:12', '2025-11-05 00:49:12'),
(294, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '243d5974304fe42cfb27053add4ef358a2616b7be3f9c48a8d2e67b1cda2fa1e', '[\"read\"]', NULL, NULL, '2025-11-05 00:54:45', '2025-11-05 00:54:45'),
(295, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'a2e43baedd927fc7e97d7825033382cfe5a393e697a734dc0c6799ac43371ca6', '[\"read\"]', NULL, NULL, '2025-11-05 00:58:30', '2025-11-05 00:58:30'),
(296, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '99dab47ec34ecc6ea3354a35667203ff247841eb0eac7112fc0dd6d4664c3ae4', '[\"read\"]', NULL, NULL, '2025-11-05 01:00:48', '2025-11-05 01:00:48'),
(297, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '79cedf19c87cd3c6a88993f2f436bd7fa4e89aeb7ce45e0d2912ed6f43e35e8c', '[\"read\"]', NULL, NULL, '2025-11-05 01:05:20', '2025-11-05 01:05:20'),
(298, 'App\\Models\\NguoiDung', 2, 'api', 'c316fca5153ade5dd7fdec76877ce0caf83809240daeda0ef9b6e53853b842d5', '[\"*\"]', '2025-11-05 01:19:18', NULL, '2025-11-05 01:16:56', '2025-11-05 01:19:18'),
(301, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3430d93c29d9e6c2fce1dbc6e6ac6fb96851ffa566779a7c6cf97aaa3d752662', '[\"read\"]', NULL, NULL, '2025-11-05 04:42:51', '2025-11-05 04:42:51'),
(302, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '4b80734db0b494c434b20ba5163235292b6dc12f11826ccb5014690fa0a99f43', '[\"read\"]', NULL, NULL, '2025-11-05 04:43:13', '2025-11-05 04:43:13'),
(303, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7656d1bde2426768e8d16f3d80a0dbbaec936d8a64da0c68fcefe8a777af445c', '[\"read\"]', NULL, NULL, '2025-11-05 04:43:26', '2025-11-05 04:43:26'),
(304, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'bb7e2f2314292b076d507fc9af7de7e8a8be86a7fe90b8f8a52d09ace8b668fd', '[\"read\"]', NULL, NULL, '2025-11-05 04:43:31', '2025-11-05 04:43:31'),
(305, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '628a584b3397333ede0bdca685fbdbcf6461f3bb0d1d7fd83b2bd31320532733', '[\"read\"]', NULL, NULL, '2025-11-05 04:43:38', '2025-11-05 04:43:38'),
(306, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '219423571ba685ac15d7de36abe4dc1fe2d8fd76c02f02dbecb4c2ea5b6a9b48', '[\"read\"]', NULL, NULL, '2025-11-05 04:43:48', '2025-11-05 04:43:48'),
(307, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '262e8bafe709a93b60bf3c07998d4c044782a5d1c698987a2a37ed7949d116e4', '[\"read\"]', NULL, NULL, '2025-11-05 05:18:20', '2025-11-05 05:18:20'),
(308, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2668707e7818b6b342f5d2300495fc3e0d1cfdeadd0f03fd3182cf6488a5f96e', '[\"read\"]', NULL, NULL, '2025-11-05 05:25:03', '2025-11-05 05:25:03'),
(311, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'cf20b158f254fedd49e2d926c654dcba3b61e537cca059883741f8b96aa941f8', '[\"read\"]', NULL, NULL, '2025-11-05 05:29:09', '2025-11-05 05:29:09'),
(312, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd0b7f445dc3bf2076f8cf922d18d5ee2961ce669a757309d1aa470c55b32736c', '[\"read\"]', NULL, NULL, '2025-11-05 05:31:20', '2025-11-05 05:31:20'),
(313, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '73c5cf582c26b3fb4667bf5ee4e9c855797bb095fe9240d5de9d71471b4da350', '[\"read\"]', NULL, NULL, '2025-11-05 05:37:30', '2025-11-05 05:37:30'),
(314, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '82556fe1a4b8705b496162413948313393333e58491190395bb9f57d79d32f62', '[\"read\"]', NULL, NULL, '2025-11-05 05:38:15', '2025-11-05 05:38:15'),
(315, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2a36589ffae93bd36aa41511a70dd7c91d7247e5c679e5121ec33b90ba3aaacc', '[\"read\"]', NULL, NULL, '2025-11-05 05:42:11', '2025-11-05 05:42:11'),
(316, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '4040679b6b4d0940a09878919c720453cbac4e4534a3d3fe4858c141d674a545', '[\"read\"]', NULL, NULL, '2025-11-05 05:43:15', '2025-11-05 05:43:15'),
(317, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '4d245389b005e7145bc7e1df612ad3387f53662c015518c4877a16cbbd7ce724', '[\"read\"]', NULL, NULL, '2025-11-05 05:47:14', '2025-11-05 05:47:14'),
(318, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '0f8b782536a96a9e0572378710739d8bd8981a8feb9c106c616f00c7c0b1454f', '[\"read\"]', NULL, NULL, '2025-11-05 06:06:48', '2025-11-05 06:06:48'),
(319, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'aaa0fb8f34135027af7287fcd1a1303ad24d32521701633abe2cc1a2e2ee4cf8', '[\"read\"]', NULL, NULL, '2025-11-05 06:10:41', '2025-11-05 06:10:41'),
(320, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '9a3dda849e3ce03247b5f9d9d9277c41f443f09f14da9e8be065ac52ca2c4778', '[\"read\"]', NULL, NULL, '2025-11-05 06:12:45', '2025-11-05 06:12:45'),
(321, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'fa292bc780fa3324afd38c80158e79e752b9961113100846e431bbedfa11ff8a', '[\"read\"]', NULL, NULL, '2025-11-05 06:26:05', '2025-11-05 06:26:05'),
(322, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'af0456202ac3c74811bb7006c6a7904a9e417c20517c7a1e7190e8f9b3d67787', '[\"read\"]', NULL, NULL, '2025-11-05 06:32:12', '2025-11-05 06:32:12'),
(325, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e2d222053c77e6e7e8995500900e26a18e897323623da5e0df7466c0e8ec7be3', '[\"read\"]', NULL, NULL, '2025-11-05 07:29:15', '2025-11-05 07:29:15'),
(328, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5bffc1531a9b0a74b7f0e938092887c06d199b7a129a10966a540646c55d4daf', '[\"read\"]', NULL, NULL, '2025-11-05 07:56:14', '2025-11-05 07:56:14'),
(329, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '065086d7be818f80f6fd74a0079014e85d6a4ead33b3fe056812fbcb1aa2451a', '[\"read\"]', NULL, NULL, '2025-11-05 07:56:22', '2025-11-05 07:56:22'),
(330, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '403501097976048042c8dbab6a103406aa220fa70f14aae2964debb3f51a28d3', '[\"read\"]', NULL, NULL, '2025-11-05 07:56:34', '2025-11-05 07:56:34'),
(333, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'dbbd59caa68bc571433a57cc0e32445657997e5e292b0d066f08a9b3b0780987', '[\"read\"]', NULL, NULL, '2025-11-05 08:09:37', '2025-11-05 08:09:37'),
(334, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ef0a418bdf570c3e8d5d2df7ed16afb39a431c70dffa849e90d67878a97e9f4b', '[\"read\"]', NULL, NULL, '2025-11-05 08:10:38', '2025-11-05 08:10:38'),
(337, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'a797b9507631595575e0271225cba30ea166e489623d7559b5495c645693affb', '[\"read\"]', NULL, NULL, '2025-11-05 08:19:34', '2025-11-05 08:19:34'),
(338, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '47b73fcc79a9c40aa6cd4c9ed11792747b64e96ab064574be053a446ccef5f4d', '[\"read\"]', NULL, NULL, '2025-11-05 08:19:40', '2025-11-05 08:19:40'),
(339, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '98bf7f54f5ddec361285d8ec0ac244b41c6675bff971654ad483541016bbc9d2', '[\"read\"]', NULL, NULL, '2025-11-05 08:23:22', '2025-11-05 08:23:22'),
(346, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c7391e057049d5bed77cad557de930f35ea2e318a363fc3d7835d9e5ca803017', '[\"read\"]', NULL, NULL, '2025-11-05 08:47:32', '2025-11-05 08:47:32'),
(347, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd8ff5d0da8ce24feda789d8b2bb30ee8d7326e4c9a43efe5b489c0be3df61da2', '[\"read\"]', NULL, NULL, '2025-11-05 08:47:43', '2025-11-05 08:47:43'),
(348, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '512f0a9561e73e6d35ce85fd7e1d76a8eea00eeb5861a0d197753b39cf3a098b', '[\"read\"]', NULL, NULL, '2025-11-05 08:48:15', '2025-11-05 08:48:15'),
(349, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '25397f773cb5331947c2f3f64a5e75150931afe601223e46d5cd0a4496abf754', '[\"read\"]', NULL, NULL, '2025-11-05 08:48:25', '2025-11-05 08:48:25'),
(351, 'App\\Models\\NguoiDung', 4, 'api', '82ce3a024ef0d35027b43b31ea60669767192bbb2b0688c858272179571444a1', '[\"*\"]', '2025-11-05 08:50:26', NULL, '2025-11-05 08:49:48', '2025-11-05 08:50:26'),
(352, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'cb02360ebd9818d160cf7b668b81796e5cae330f8f5f4d8d6bd52ead7e1f638e', '[\"read\"]', NULL, NULL, '2025-11-05 08:49:51', '2025-11-05 08:49:51'),
(353, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '86cf6b94bac22e1f4b9ecb631e30d8d28c01071c9de91d4c36530ca0acb8238e', '[\"read\"]', NULL, NULL, '2025-11-05 08:50:05', '2025-11-05 08:50:05'),
(354, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7dfa586ac73d7a9ac11dda500c78463ac88cf4b76001fbbd932988e7d674da81', '[\"read\"]', NULL, NULL, '2025-11-05 08:50:13', '2025-11-05 08:50:13'),
(357, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'dad6d350f9cf85903bcbd70382e3647353c6196473f721d57ecb866e833c7395', '[\"read\"]', NULL, NULL, '2025-11-05 09:06:38', '2025-11-05 09:06:38'),
(358, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6d4a0bee848e1d5d01f6edb9b2533faa3d64410e3b1f4de839d66c6083f9fda9', '[\"read\"]', NULL, NULL, '2025-11-05 09:06:45', '2025-11-05 09:06:45'),
(359, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7fef77421a4965ae8e066408d69cbde1124767072bb3f2c1c1f9b940fca2650e', '[\"read\"]', NULL, NULL, '2025-11-05 09:06:48', '2025-11-05 09:06:48'),
(361, 'App\\Models\\NguoiDung', 4, 'api', '7733a3b86d1c95ef763ffa6ad413cf77967cebe2605538574cc6642ec0a7ab1b', '[\"*\"]', '2025-11-05 09:11:41', NULL, '2025-11-05 09:11:26', '2025-11-05 09:11:41'),
(362, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '887abd7ab568bb0923e66ff7f89d1af2781870ae8e0d4fc2584d4951447fa121', '[\"read\"]', NULL, NULL, '2025-11-05 09:11:29', '2025-11-05 09:11:29'),
(363, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'bee61fa8a84a3c5e34e61fdf0e211d7532fd1af436b4f7f2ef3da14c3252d3d4', '[\"read\"]', NULL, NULL, '2025-11-05 09:11:34', '2025-11-05 09:11:34'),
(364, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'a89b06950da3ba8ae33c68df5136f8e6307b1801fdebbfd8e5527423b661f7f2', '[\"read\"]', NULL, NULL, '2025-11-05 09:11:40', '2025-11-05 09:11:40'),
(367, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'b756c1e73a9db8673899c192552175c83c0e937c757d75dab404ec4cc2822b86', '[\"read\"]', NULL, NULL, '2025-11-07 00:13:25', '2025-11-07 00:13:25'),
(370, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6acd60de08777cac4de1bcffc9e1772e89ff7727b2b9dfc5318220c24dc314ac', '[\"read\"]', NULL, NULL, '2025-11-07 00:32:43', '2025-11-07 00:32:43'),
(373, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '831ff3dee4ec6731d47c66498896acd9fcef4c4d9ae708557f0951b015015fb7', '[\"read\"]', NULL, NULL, '2025-11-07 00:40:02', '2025-11-07 00:40:02'),
(374, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6acaa2351ac9560cb6cbf663e3c1991e7f7b3ab2abea09926a0efd7765bf54ab', '[\"read\"]', NULL, NULL, '2025-11-07 00:40:05', '2025-11-07 00:40:05'),
(376, 'App\\Models\\NguoiDung', 4, 'api', 'f9b1aa65664a64fcc6d20fdd6c469ac9393937cf61d814f25f5d69140341187b', '[\"*\"]', '2025-11-07 00:41:20', NULL, '2025-11-07 00:41:19', '2025-11-07 00:41:20'),
(378, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'b8a4634199da3efdad1884747f03b0badc9089871e0752e1ff08f0e1f260c429', '[\"read\"]', NULL, NULL, '2025-11-07 00:41:23', '2025-11-07 00:41:23'),
(379, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '646cd7636028754e3f146673e2a212119d9d3108ae0fb41d16611fdf58f90046', '[\"read\"]', NULL, NULL, '2025-11-07 00:41:24', '2025-11-07 00:41:24'),
(382, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '15905828d42ec6e3e7d1a519557327421c930411d9af16709a2cc4107dc455ea', '[\"read\"]', NULL, NULL, '2025-11-07 02:12:03', '2025-11-07 02:12:03'),
(385, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '0901a952e54be300e09592a3362de3ecfa74b86fa6bc5faa307a93b9e40dbf64', '[\"read\"]', NULL, NULL, '2025-11-07 02:21:55', '2025-11-07 02:21:55'),
(386, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'fbfdbfb1bce61ba374c588571fe582d32026b8c8d28730bf15c77b517f972343', '[\"read\"]', NULL, NULL, '2025-11-07 02:22:06', '2025-11-07 02:22:06'),
(389, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '66130eb60be2dfb39c11714c7439f3c1c341fc0fb95a8c46d7297021736a4895', '[\"read\"]', NULL, NULL, '2025-11-07 02:31:09', '2025-11-07 02:31:09'),
(392, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd6e81077c5d9691694d16763e602122eb10c22abf3bfc44f1e884e1cd5ccb6de', '[\"read\"]', NULL, NULL, '2025-11-07 02:35:30', '2025-11-07 02:35:30'),
(394, 'App\\Models\\NguoiDung', 4, 'api', '79d67ca7a6f2ea47c6ba082242d8e31aed9e03e5a749b95f50d047e80afcd124', '[\"*\"]', '2025-11-07 02:49:55', NULL, '2025-11-07 02:42:28', '2025-11-07 02:49:55'),
(395, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'f8cb2f814e64285a01fdfd122ce2252f537c60cc5aad336837691f066a065ce5', '[\"read\"]', NULL, NULL, '2025-11-07 02:42:30', '2025-11-07 02:42:30'),
(398, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2438d2d09d47dbe874bd8f0fc98ee83a671fe3bfc5163c8492b4cef491cd4eba', '[\"read\"]', NULL, NULL, '2025-11-07 07:32:18', '2025-11-07 07:32:18'),
(401, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '55dcad6aa96f7525b8eab984711f7c5e2f381326f753c627f22a6085c95cf3ea', '[\"read\"]', NULL, NULL, '2025-11-07 07:47:42', '2025-11-07 07:47:42'),
(404, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '235c864b48d6f2c0446edcbe4939cf27d6be4027c9f1f405449a8ab4a214611f', '[\"read\"]', NULL, NULL, '2025-11-07 08:16:36', '2025-11-07 08:16:36'),
(405, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6edd760b600dd5711d40fd20c66c3f58341d9abe51c36ef67eccfcce7711a549', '[\"read\"]', NULL, NULL, '2025-11-07 08:16:58', '2025-11-07 08:16:58'),
(408, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ab5485007abb4dd409572516f62a7a7e60cb3aff0a33fba14fc532dcabc77c56', '[\"read\"]', NULL, NULL, '2025-11-07 08:18:30', '2025-11-07 08:18:30'),
(411, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '51780229d92002896f3f5ddfffbb80f188b10ccfcc80977e90410207ae4b6f60', '[\"read\"]', NULL, NULL, '2025-11-07 08:21:07', '2025-11-07 08:21:07'),
(412, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '172d910cb9790eb1cf16858031ffb82c19374d4c7dd1a2b1a199d8ef3f3acd7e', '[\"read\"]', NULL, NULL, '2025-11-07 08:25:11', '2025-11-07 08:25:11'),
(414, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '05a352c3a19d0e5788eacdf742c2edfd91310e835c1fe6d825e94c864caa1d77', '[\"read\"]', NULL, NULL, '2025-11-07 08:25:50', '2025-11-07 08:25:50'),
(417, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c689655d0128be294fd13488bedb6995901eb5ec4f7921cb79c42dd6f72fefe3', '[\"read\"]', NULL, NULL, '2025-11-07 08:26:48', '2025-11-07 08:26:48'),
(418, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '1fa72da9a6fd213324e62c9ed7ee1f01291bb8c0272ad7a1554de471f0be7ee2', '[\"read\"]', NULL, NULL, '2025-11-07 08:27:15', '2025-11-07 08:27:15'),
(421, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5a8e55f8f28a0fcf6ebf2a08b91b672fc468cb771a0fda1e178602ed7bc0617f', '[\"read\"]', NULL, NULL, '2025-11-07 08:28:07', '2025-11-07 08:28:07'),
(422, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '332d5174b7c08e7d61f2805ab57cf471fdb9f8564eaca5977c6c9e4b27c6b44a', '[\"read\"]', NULL, NULL, '2025-11-07 08:28:23', '2025-11-07 08:28:23'),
(423, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '50b62005406e189b97d083ce2d2ed30fdc29f82e1e1adec6a9036f01c45c4951', '[\"read\"]', NULL, NULL, '2025-11-07 08:42:53', '2025-11-07 08:42:53'),
(426, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd6a5f1b65b4447da82eba3f61d1c86c8620c8cbe4bacf24131ba01267a8d82c0', '[\"read\"]', NULL, NULL, '2025-11-07 08:46:18', '2025-11-07 08:46:18'),
(429, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '741e0115b58cf4a65b1d307c1b97fa1b8c99e3fab484ff6b64ac87cf2c415f50', '[\"read\"]', NULL, NULL, '2025-11-07 08:49:09', '2025-11-07 08:49:09'),
(430, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd56890c133ab840a3e2b77837c474aee7fecf1253de8a5940b84ff74dde11866', '[\"read\"]', NULL, NULL, '2025-11-07 08:49:16', '2025-11-07 08:49:16'),
(433, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'faffe148b17a725c77aa2da7733b6cc692b1df4ac593d3b1fd51065a06fe8992', '[\"read\"]', NULL, NULL, '2025-11-07 08:51:53', '2025-11-07 08:51:53'),
(436, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7d0f266f221b4af1f748311d048d60f72132a9f0db7b58002cb3b709a332de79', '[\"read\"]', NULL, NULL, '2025-11-07 09:00:27', '2025-11-07 09:00:27'),
(439, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '553f9691b31077a6a92d6c7d4482afbf32f972db37c14a4d8b2fd475a2f07498', '[\"read\"]', NULL, NULL, '2025-11-07 09:40:09', '2025-11-07 09:40:09'),
(440, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'efc44de26aa0ac8221f06e50cf15fda0baa376267918a8d916d7579e912c0832', '[\"read\"]', NULL, NULL, '2025-11-07 09:40:21', '2025-11-07 09:40:21'),
(442, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8a62c9a4b27e15323f4629ce4a8cbacdc62eeba428842a0ed62d5e98d70de5a7', '[\"read\"]', NULL, NULL, '2025-11-07 09:41:23', '2025-11-07 09:41:23'),
(445, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '961b16f5d50e7b38abcaa22a066616412c2f868023cbb518e231541f3180d09c', '[\"read\"]', NULL, NULL, '2025-11-07 09:42:25', '2025-11-07 09:42:25'),
(448, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '04523456d7ffb56452b5b2a6518f2b7daae46be593dd2d2b30a843251f362ee7', '[\"read\"]', NULL, NULL, '2025-11-07 09:45:40', '2025-11-07 09:45:40'),
(451, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '44549f53135269708a693390e29150cd6fb65c6e7eefe07034c6d9c90f64ef55', '[\"read\"]', NULL, NULL, '2025-11-07 09:46:59', '2025-11-07 09:46:59'),
(454, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '1db56003b59a1d8880e7a8272ed8361d01427ec92428b87e6f8028185949739f', '[\"read\"]', NULL, NULL, '2025-11-07 10:10:29', '2025-11-07 10:10:29'),
(457, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7d6b3d399e0aa6564012e4d80b742fb52b2463c12c79202896486754d8df9f4e', '[\"read\"]', NULL, NULL, '2025-11-07 10:11:57', '2025-11-07 10:11:57'),
(462, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '851bdb1ede9bb187c0d952e2cb0dd172007570c485f38e51992f4d6d86dcfb30', '[\"read\"]', NULL, NULL, '2025-11-07 10:16:35', '2025-11-07 10:16:35'),
(463, 'App\\Models\\NguoiDung', 2, 'api', 'd3ddbacada1123dca7941dfc280b1c0838430d0873dac80ae4d825b94db15cc8', '[\"*\"]', '2025-11-07 10:17:11', NULL, '2025-11-07 10:17:02', '2025-11-07 10:17:11'),
(464, 'App\\Models\\NguoiDung', 2, 'api', '04b7f9bb58609d662ad2f720de08407ccbe5807f0fa50fbb28bb931ab2fd0c3d', '[\"*\"]', '2025-11-07 20:30:30', NULL, '2025-11-07 20:30:28', '2025-11-07 20:30:30'),
(468, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6f9ff011231c1d8408bd5078bd9c333fe585bff958bcbc1de0f9fc08dcc31838', '[\"read\"]', NULL, NULL, '2025-11-07 20:38:51', '2025-11-07 20:38:51'),
(472, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '4e061bb5298e500374991e66f49ba0845904b6a54d79354ed136bc4bc2f54bba', '[\"read\"]', NULL, NULL, '2025-11-07 20:40:33', '2025-11-07 20:40:33'),
(478, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ce45b0fb57e84f039c077426a3663c0272a80f8e41a58810aa8b1e79a801980e', '[\"read\"]', NULL, NULL, '2025-11-07 21:14:44', '2025-11-07 21:14:44'),
(481, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '1927636f52be3402e185dd3afd606fd985b571d2c2973d492fb101599882b0c8', '[\"read\"]', NULL, NULL, '2025-11-07 21:16:12', '2025-11-07 21:16:12'),
(482, 'App\\Models\\NguoiDung', 2, 'api', '31a178041d53464970a1e63d85cb088c053728bbb61e77b15ac3c9306e3a05d4', '[\"*\"]', '2025-11-07 21:16:49', NULL, '2025-11-07 21:16:48', '2025-11-07 21:16:49'),
(487, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'bc971862ab4faceb845cb7e014800232fa52d0e661cc9bca85063ee517901103', '[\"read\"]', NULL, NULL, '2025-11-07 21:19:34', '2025-11-07 21:19:34'),
(490, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '47b13d58382e58240461b3972bb5be2c0d302390bc42bf42c4c253390e7dd400', '[\"read\"]', NULL, NULL, '2025-11-07 21:20:39', '2025-11-07 21:20:39'),
(493, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ec7d3421617cc9fbe003616ca01176a49a523a232ef21ba781b47b0d1ba42f36', '[\"read\"]', NULL, NULL, '2025-11-07 21:28:32', '2025-11-07 21:28:32'),
(496, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd7d2ae7ad57ef8c30fecef27b1bccecdd90b301bca344540eb05cd38eedc06ec', '[\"read\"]', NULL, NULL, '2025-11-07 21:30:17', '2025-11-07 21:30:17'),
(499, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '7ecde26c07d821dd58e356bea7d9f9aa8909b5f4085f5e11e30173716c9ddffa', '[\"read\"]', NULL, NULL, '2025-11-07 21:38:09', '2025-11-07 21:38:09'),
(500, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '0aa3ad38a07758495ea22b62afb6c9abdbc669bbfa63b0f31b62d87a525197a2', '[\"read\"]', NULL, NULL, '2025-11-07 21:38:10', '2025-11-07 21:38:10'),
(503, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '44011bff11e51462c374e548e522123e6048b8c13ced008db8bf320174ff3e3c', '[\"read\"]', NULL, NULL, '2025-11-07 21:39:42', '2025-11-07 21:39:42'),
(509, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '781c79ed0fd0a35a1729558e239a55f3e446bf7feacfa07d9aee38aeda683b8b', '[\"read\"]', NULL, NULL, '2025-11-07 21:44:06', '2025-11-07 21:44:06'),
(512, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '0d6270f34c971b60493335751661ddd030453c4c3d422fb917115129cdc16057', '[\"read\"]', NULL, NULL, '2025-11-07 21:45:17', '2025-11-07 21:45:17'),
(515, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'd2db28d8f63b174aa4a75e9af34b333025215c81cdc6140f44e14268fcc9984c', '[\"read\"]', NULL, NULL, '2025-11-07 21:48:48', '2025-11-07 21:48:48'),
(518, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '13826110a2b37f5bfed5eaca2dd502a75c0ddf70fbc41c6e898fad3494771ea4', '[\"read\"]', NULL, NULL, '2025-11-07 21:49:55', '2025-11-07 21:49:55'),
(519, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8bf23596f3f57fdc8e5c8a33ee61f7b2a35ddc4f6a44dec4a1f2cf3e9e332fef', '[\"read\"]', NULL, NULL, '2025-11-07 21:49:56', '2025-11-07 21:49:56'),
(522, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '1316a1839abcd264a0ffb65be0b29d801fd4d38cb6563f66898b3fc37d4b4c43', '[\"read\"]', NULL, NULL, '2025-11-07 21:59:44', '2025-11-07 21:59:44'),
(525, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'fe026cfffcda1c64666b02852d1bc65a670cbe52f61c7028136802ec69eb897b', '[\"read\"]', NULL, NULL, '2025-11-07 22:00:58', '2025-11-07 22:00:58'),
(526, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'fe0dba7ae896fc79b17f697cae5be49b659cec2695ce8ae5a21683b619527dcc', '[\"read\"]', NULL, NULL, '2025-11-07 22:01:00', '2025-11-07 22:01:00'),
(531, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e6071bdcef834cecbdd0f694d39887254f9d793cef04df4d2f343f91a79883fe', '[\"read\"]', NULL, NULL, '2025-11-07 22:06:17', '2025-11-07 22:06:17'),
(536, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '76b4583e01ac73ceddd77463a0ba85d96f2a1e567ee557629862db51d1fce561', '[\"read\"]', NULL, NULL, '2025-11-07 22:11:20', '2025-11-07 22:11:20'),
(539, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'dd2a84ba837ef778875587d512bf41e3588bb7a45f81aa2f075b95e9c8b330e6', '[\"read\"]', NULL, NULL, '2025-11-07 22:12:56', '2025-11-07 22:12:56'),
(542, 'App\\Models\\NguoiDung', 2, 'api', '1a5a40532a0c0558c4ef6fb2f894c2f5a08b01863ca8f911c1f1fdac74fdcabd', '[\"*\"]', '2025-11-07 22:14:47', NULL, '2025-11-07 22:14:47', '2025-11-07 22:14:47'),
(545, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '2e35be39d0eba1edd3986b4becd6ad41ef2b8e43b3f01be8971189e675b86a75', '[\"read\"]', NULL, NULL, '2025-11-07 22:15:29', '2025-11-07 22:15:29'),
(546, 'App\\Models\\NguoiDung', 2, 'api', '191c26711048fb11f44d1fd03effbe64cbd8eab9ae3de3067078d524b748fb47', '[\"*\"]', '2025-11-07 22:16:01', NULL, '2025-11-07 22:15:48', '2025-11-07 22:16:01'),
(549, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '619e8d583b3eb9fe61d6ced57896e640f4a8247cd8787b77c53639dbf84931d6', '[\"read\"]', NULL, NULL, '2025-11-08 01:29:18', '2025-11-08 01:29:18'),
(550, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '3e940daa2d906f95058edd25da632013a29ebce7109f7c2a73731016d6cf76c9', '[\"read\"]', NULL, NULL, '2025-11-08 01:30:04', '2025-11-08 01:30:04'),
(554, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'eae187a033208c9444478253f45ec6df3539602b493491cf776041b11fede8fb', '[\"read\"]', NULL, NULL, '2025-11-08 01:32:15', '2025-11-08 01:32:15'),
(557, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '83677fdff2abfac46d0f9d5fddbaf40a3811979f948c546d169b8a9708264340', '[\"read\"]', NULL, NULL, '2025-11-08 01:33:13', '2025-11-08 01:33:13'),
(562, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'ac2995881162f35179faa27801fba4ec1a3113bb693c48d394b2116d5635e029', '[\"read\"]', NULL, NULL, '2025-11-08 01:46:04', '2025-11-08 01:46:04'),
(565, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '240e64a238a14446808227d46fbd5792033843fa0db35e160918889779e93c18', '[\"read\"]', NULL, NULL, '2025-11-08 01:47:00', '2025-11-08 01:47:00'),
(568, 'App\\Models\\NguoiDung', 4, 'api', '25bb522530caebacaf87451be7211c19929bb07e9513d26324b5e9c661ae14bb', '[\"*\"]', '2025-11-08 02:14:13', NULL, '2025-11-08 02:13:56', '2025-11-08 02:14:13'),
(578, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8068a164171081c69903d6567a5101b857a45b9df77af62b215561d1cdd29342', '[\"read\"]', NULL, NULL, '2025-11-08 06:09:42', '2025-11-08 06:09:42'),
(581, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '5e78a8547263bf00c8af9b2608d4243c18a778309aa4ddd7bb3f8c8d99bd53f2', '[\"read\"]', NULL, NULL, '2025-11-08 06:10:34', '2025-11-08 06:10:34'),
(586, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'bcecbad7cbe55a0227573288d874fcfcd23b8b5e9d02aff7c21f8556103f4264', '[\"read\"]', NULL, NULL, '2025-11-08 06:38:57', '2025-11-08 06:38:57'),
(589, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '2a4631db3cf939f0a98c12b5889240e03d813eed965f0723585bbe3d54fb8973', '[\"read\"]', NULL, NULL, '2025-11-08 06:40:42', '2025-11-08 06:40:42'),
(591, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '6f693ec3693d802d797c7973f1a2c13b23ac20571edfab0e0243b7a8132c5605', '[\"read\"]', NULL, NULL, '2025-11-08 06:41:24', '2025-11-08 06:41:24'),
(592, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '0085ea57cb23bcdbb4431639e67fee5d3008920632bb98972cd1df84e0332ecb', '[\"read\"]', NULL, NULL, '2025-11-08 06:43:49', '2025-11-08 06:43:49'),
(593, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'b8567ed89326216cebaf900913b3afa5263b97fc0ca1ad4b56cffb3f7d2ad32e', '[\"read\"]', NULL, NULL, '2025-11-08 06:47:33', '2025-11-08 06:47:33'),
(594, 'App\\Models\\NguoiDung', 4, 'api', '03e3f4a7cac4eb11805b260931ac42b5d99e25dab26207c0b37e57c6309e0d2b', '[\"*\"]', '2025-11-08 07:27:17', NULL, '2025-11-08 06:58:54', '2025-11-08 07:27:17'),
(595, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e5c0ff0e27a23055e5fdb6fb8dc993054eb71f322840f2ef6c91526251ff9925', '[\"read\"]', NULL, NULL, '2025-11-08 06:58:56', '2025-11-08 06:58:56'),
(596, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '8f9ca93834cab7d647fd535a9bd61feb44e785bc3cce07a3dd58838e0fcfa218', '[\"read\"]', NULL, NULL, '2025-11-08 07:02:10', '2025-11-08 07:02:10'),
(597, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'c9ae8516442ac057e82d64c47ed4e49b977b73002a4d417803f0c1b215e353c6', '[\"read\"]', NULL, NULL, '2025-11-08 07:18:06', '2025-11-08 07:18:06'),
(598, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '79bd269011801cd5fa620ddbf9f36cae419885d32f914a049be36c9772512246', '[\"read\"]', NULL, NULL, '2025-11-08 07:23:38', '2025-11-08 07:23:38'),
(601, 'App\\Models\\NguoiDung', 3, 'api', '75facb48d6bdc42e95f71b48f05193cd399048219270709bf764421830e00096', '[\"*\"]', '2025-11-09 13:12:00', NULL, '2025-11-09 13:11:56', '2025-11-09 13:12:00'),
(602, 'App\\Models\\NguoiDung', 1, 'api', '6ad323f7c19366ddce47cd359fbb55874bfb9d2ea49a7956906ef3bb6ef52483', '[\"*\"]', '2025-11-09 14:09:16', NULL, '2025-11-09 13:35:47', '2025-11-09 14:09:16'),
(604, 'App\\Models\\NguoiDung', 3, 'api', '72be36e1757f9ccaeeff427cf9292cc4f4aa820814619a1ae4f255bfa7faaeda', '[\"*\"]', '2025-11-09 14:33:38', NULL, '2025-11-09 14:33:37', '2025-11-09 14:33:38'),
(605, 'App\\Models\\NguoiDung', 3, 'api', '5c2282aba6852ed256471c10e1db59a4e931c7bebb882d2d660d0d9397d12f5a', '[\"*\"]', '2025-11-09 14:36:39', NULL, '2025-11-09 14:34:07', '2025-11-09 14:36:39');
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(606, 'App\\Models\\NguoiDung', 3, 'api', '798443160e2d8edb609f48a3ce5558aa419575f27a07f54f1e634be567b8b778', '[\"*\"]', '2025-11-09 14:49:08', NULL, '2025-11-09 14:49:05', '2025-11-09 14:49:08'),
(608, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'deee9b6b76d7032b5e49d719582f7337a58889f3814950428280a5dc63c7aaa9', '[\"read\"]', NULL, NULL, '2025-11-09 15:03:15', '2025-11-09 15:03:15'),
(609, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '7ec84c87b93566d2227a41a91dc561ade7d91d491d0624864d2b4172716c670a', '[\"read\"]', NULL, NULL, '2025-11-09 15:03:38', '2025-11-09 15:03:38'),
(610, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '9e61f40cce31dcb204d257ca01c2ad7c84983cf3aa850706157d6af4723663a6', '[\"read\"]', NULL, NULL, '2025-11-09 15:03:51', '2025-11-09 15:03:51'),
(611, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '5a101c48b04287317fcad1a547c58638dd6485bf3b61b8375f81b9f57e22f9bd', '[\"read\"]', NULL, NULL, '2025-11-09 15:04:05', '2025-11-09 15:04:05'),
(612, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'a9e7a4afb15ca4be58368678d2a77bba4b9d5175d417789db11b2bf930d54ba2', '[\"read\"]', NULL, NULL, '2025-11-09 15:13:47', '2025-11-09 15:13:47'),
(613, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'b044d90905f2186e185c5fd82eec28bd40dc66ebb51e0ab99283316c3f987b3a', '[\"read\"]', NULL, NULL, '2025-11-09 15:13:53', '2025-11-09 15:13:53'),
(614, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '4863c41996090587d09458efd7b27a91977be5ffc3f14a3fa676278da7ae2cb6', '[\"read\"]', NULL, NULL, '2025-11-09 15:14:13', '2025-11-09 15:14:13'),
(615, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '0509be4aea593297c8bebda4c34937b5576318726a9ab3fa917ccdfe0e7eb33e', '[\"read\"]', NULL, NULL, '2025-11-09 15:16:53', '2025-11-09 15:16:53'),
(616, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '208ff4b07f2848d7314c3ed47c4f9b04d61107cce68cc0d45576fd8fe8cecb71', '[\"read\"]', NULL, NULL, '2025-11-09 15:22:03', '2025-11-09 15:22:03'),
(617, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '17a94bc9c77debe0d682aaf05fa686586c608b215a59421b534dc1575187f5c4', '[\"read\"]', NULL, NULL, '2025-11-09 15:25:52', '2025-11-09 15:25:52'),
(619, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '38350d0025b77ef4ab4bde9110d07ef60149068c908b5b0f970a22614ed34574', '[\"read\"]', NULL, NULL, '2025-11-09 16:45:39', '2025-11-09 16:45:39'),
(620, 'App\\Models\\NguoiDung', 5, 'api', '798e83a0f059de644de3e2d3d7a3099db3bf9ca4f6525b25657a0841b5adc1f2', '[\"*\"]', '2025-11-09 16:53:06', NULL, '2025-11-09 16:53:02', '2025-11-09 16:53:06'),
(621, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '7ea846f148e792d94a75266c59d302f784f60d8a019b3bbae1927c07c0c5684a', '[\"read\"]', NULL, NULL, '2025-11-09 16:53:05', '2025-11-09 16:53:05'),
(623, 'App\\Models\\NguoiDung', 5, 'view_hopdong', '0efe4dc93641c3b78ed37bf000fdfcbd5a61d6f8de2e7979dcef40d123e8476a', '[\"read\"]', NULL, NULL, '2025-11-09 16:53:38', '2025-11-09 16:53:38'),
(624, 'App\\Models\\NguoiDung', 5, 'view_hopdong', 'cec03c72804f945d95714519a83822b000484bb486d4ce7fc86838ca8b2085a2', '[\"read\"]', NULL, NULL, '2025-11-09 17:00:38', '2025-11-09 17:00:38'),
(627, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '5ca697a3f5e58f680c7359a2a7a11afc60ec4d78e1361166ab00e826fa390310', '[\"read\"]', NULL, NULL, '2025-11-09 17:04:05', '2025-11-09 17:04:05'),
(628, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '4e8443273a9a3ff4071ea7b36afca2ba8df7a9562c84e38f1cb0b96491642698', '[\"read\"]', NULL, NULL, '2025-11-09 17:04:06', '2025-11-09 17:04:06'),
(632, 'App\\Models\\NguoiDung', 5, 'api', '6a2e1b5e32708e2ec4f9c11ca9d2bf483920c731bb44ca278c05ea1b4f9a2ab4', '[\"*\"]', '2025-11-09 17:12:22', NULL, '2025-11-09 17:12:13', '2025-11-09 17:12:22'),
(633, 'App\\Models\\NguoiDung', 28, 'api', '0bafec45b9485e84167b7893ca8437e5255ae06e7ce5e71e3a8ab17d848a1e48', '[\"*\"]', NULL, NULL, '2025-11-16 15:07:05', '2025-11-16 15:07:05'),
(634, 'App\\Models\\NguoiDung', 27, 'api', '878aba2398a4a70ac0bdc4ed3f0e61a0026c3a18c15b24d814724ded69c984c1', '[\"*\"]', '2025-11-16 16:44:00', NULL, '2025-11-16 15:54:12', '2025-11-16 16:44:00'),
(635, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '252b3cbe9bb8d168965258b06cd0582a831c549fdb0fe48c5c22e6e6039eff54', '[\"read\"]', NULL, NULL, '2025-11-16 15:54:25', '2025-11-16 15:54:25'),
(636, 'App\\Models\\NguoiDung', 1, 'api', '9d0ac907fdf81d07b544c67efd6e95cbc4e1e230810fcf8a821b6af1462ae1b3', '[\"*\"]', '2025-11-16 16:26:27', NULL, '2025-11-16 15:55:31', '2025-11-16 16:26:27'),
(637, 'App\\Models\\NguoiDung', 27, 'api', '5881ddba928b88bb97d0bf44247fa9b30e4398996994d209efac07cd950ff784', '[\"*\"]', '2025-11-17 23:09:24', NULL, '2025-11-17 23:02:17', '2025-11-17 23:09:24'),
(638, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '13056d3ae6efe62f2485adc634d4e98b95aee2259a4eaac3adb0ec8c3c1d6532', '[\"read\"]', NULL, NULL, '2025-11-17 23:05:00', '2025-11-17 23:05:00'),
(639, 'App\\Models\\NguoiDung', 1, 'api', '52dca786b037eb8b62361934570f5107c25af27cf85bdea2dfa533fe16f8cf97', '[\"*\"]', '2025-11-17 23:13:33', NULL, '2025-11-17 23:12:00', '2025-11-17 23:13:33'),
(640, 'App\\Models\\NguoiDung', 206, 'api', '0b05958e1ea1f4078da5732f583271ee3a38ff09a5aaceeffc56a9de82ee9e67', '[\"*\"]', NULL, NULL, '2025-11-19 06:11:55', '2025-11-19 06:11:55'),
(642, 'App\\Models\\NguoiDung', 206, 'view_hopdong', '4229ba614a545b504dc58a80fb3b602f8b17906aa911546aa308098b5f83a867', '[\"read\"]', NULL, NULL, '2025-11-19 06:15:51', '2025-11-19 06:15:51'),
(643, 'App\\Models\\NguoiDung', 206, 'view_hopdong', '550366c7929275d479961c6012e016f24fa523e8545e942213023ec5fee7cced', '[\"read\"]', NULL, NULL, '2025-11-19 06:15:57', '2025-11-19 06:15:57'),
(645, 'App\\Models\\NguoiDung', 4, 'view_hopdong', '09225303967f45046e3fe9de9bde23c8c4e054b05963752bae03f60c7ebade8f', '[\"read\"]', NULL, NULL, '2025-11-19 06:19:39', '2025-11-19 06:19:39'),
(646, 'App\\Models\\NguoiDung', 4, 'view_hopdong', 'e6010495dc91f6441db5c12667352498a31122cfd4f52cb637860b85e9f2931e', '[\"read\"]', NULL, NULL, '2025-11-19 06:19:51', '2025-11-19 06:19:51'),
(647, 'App\\Models\\NguoiDung', 2, 'api', 'b853d701b373718a49f5840bcd2d4fcc0766da03b8ec04bc8c9c7eafc2bc5d85', '[\"*\"]', '2025-11-19 06:38:15', NULL, '2025-11-19 06:20:58', '2025-11-19 06:38:15'),
(648, 'App\\Models\\NguoiDung', 1, 'api', '25de423d6384ca29f84334a2fe5a4e3fed240259bf9409de8576bf66df6cd81e', '[\"*\"]', '2025-11-19 06:27:13', NULL, '2025-11-19 06:23:30', '2025-11-19 06:27:13'),
(649, 'App\\Models\\NguoiDung', 27, 'api', 'c6e320544edcf29b4a84c089b67d86d5fe18124b1275a523e681fce3ff48b34f', '[\"*\"]', '2025-11-25 03:40:31', NULL, '2025-11-25 03:17:00', '2025-11-25 03:40:31'),
(650, 'App\\Models\\NguoiDung', 27, 'view_hopdong', 'e9f19a1450e4107fab0676a98dc431b8f7b0ca79a881ef39349b24c2f1caea20', '[\"read\"]', NULL, NULL, '2025-11-25 03:40:30', '2025-11-25 03:40:30'),
(652, 'App\\Models\\NguoiDung', 27, 'api', '46517ea5ab7fe5c55b6db69440a78cee365ef466cb49ba7a2bebf636337610d8', '[\"*\"]', '2025-11-25 07:24:20', NULL, '2025-11-25 05:52:46', '2025-11-25 07:24:20'),
(653, 'App\\Models\\NguoiDung', 27, 'api', 'c6edce20faa8568676a95e6cb065d1dbb70e137cb49465864cd57f15c7dd5273', '[\"*\"]', '2025-11-25 07:47:13', NULL, '2025-11-25 07:24:44', '2025-11-25 07:47:13'),
(654, 'App\\Models\\NguoiDung', 27, 'api', '42bd3e7984f1fd1ce6fe672a3015812b6796c62028338d47685424ae17cf2c16', '[\"*\"]', '2025-11-25 13:06:37', NULL, '2025-11-25 10:09:17', '2025-11-25 13:06:37'),
(655, 'App\\Models\\NguoiDung', 27, 'view_hopdong', 'f24db8a681f18d41fbf40906d914e25794e694f78f6bec0307916ab7adc4eb7b', '[\"read\"]', NULL, NULL, '2025-11-25 10:10:03', '2025-11-25 10:10:03'),
(656, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '680a1be3cb68b41deacbb0b41926abb19ea8cec6b86f1fdca091b0892e1ebd4f', '[\"read\"]', NULL, NULL, '2025-11-25 10:10:07', '2025-11-25 10:10:07'),
(657, 'App\\Models\\NguoiDung', 27, 'view_hopdong', 'fe82512f9fa46dd42409bba756a35bbaddb9c0d0830ebbf131b86bbc2e528f03', '[\"read\"]', NULL, NULL, '2025-11-25 12:53:39', '2025-11-25 12:53:39'),
(658, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '02828fb0d467ad5a9a4fcc72747aacb72d5d287266444af719d5562aced70ab4', '[\"read\"]', NULL, NULL, '2025-11-25 13:06:08', '2025-11-25 13:06:08'),
(659, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '08332184c76b114cdbd7321cd3d3b2a57bdad204f6fbb546229e92a8de436848', '[\"read\"]', NULL, NULL, '2025-11-25 13:06:14', '2025-11-25 13:06:14'),
(661, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '00ac4dbf163cc91639ac509d434f4efd55a7e8c5aa4e469a14e49f05d3e7a117', '[\"read\"]', NULL, NULL, '2025-11-28 07:13:13', '2025-11-28 07:13:13'),
(662, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '97b59ce0bbabb50a40f6995f6922536f4baf4a797c8b6e830ca607a889f9afa4', '[\"read\"]', NULL, NULL, '2025-11-28 07:17:15', '2025-11-28 07:17:15'),
(663, 'App\\Models\\NguoiDung', 27, 'view_hopdong', '69cd198b6a42e8179e7ee6f0feed18f75fc3ede4ed380e97b634f779f8768b6d', '[\"read\"]', NULL, NULL, '2025-11-28 07:17:57', '2025-11-28 07:17:57'),
(667, 'App\\Models\\NguoiDung', 3, 'api', 'c782a4a09f665e21f182a0bdd6688e782e7692c84b53c5306194968636527384', '[\"*\"]', '2025-11-28 08:43:49', NULL, '2025-11-28 08:36:35', '2025-11-28 08:43:49'),
(669, 'App\\Models\\NguoiDung', 3, 'api', '39c525f8b6306191e79806e07f4ba9fabff8df53e0bc004e69aaa5fb355a34bf', '[\"*\"]', '2025-11-29 20:56:23', NULL, '2025-11-29 20:49:30', '2025-11-29 20:56:23'),
(670, 'App\\Models\\NguoiDung', 1, 'api', '0b237f81650e13e2e48580b47f9d300c2d583d86ec2c6003f56bc8daf0cb6c9d', '[\"*\"]', '2025-11-29 20:54:31', NULL, '2025-11-29 20:52:45', '2025-11-29 20:54:31'),
(671, 'App\\Models\\NguoiDung', 27, 'api', '99b8cff0ce24bdf1a5a08c9e7410652596f99502f2e0c5310880a3f89ad41a5d', '[\"*\"]', '2025-11-30 08:03:06', NULL, '2025-11-30 06:20:57', '2025-11-30 08:03:06'),
(672, 'App\\Models\\NguoiDung', 27, 'api', 'df6009813ec19a2f98069a1c02ce69c29cec46350db3fc54457bcc4a3a823359', '[\"*\"]', '2025-12-01 01:21:47', NULL, '2025-12-01 00:51:07', '2025-12-01 01:21:47'),
(674, 'App\\Models\\NguoiDung', 3, 'api', 'ab00486c5692c5b7cda26cec96162b4a414d3e15650c3259907977bdeb40252a', '[\"*\"]', '2025-12-01 06:26:49', NULL, '2025-12-01 05:24:43', '2025-12-01 06:26:49'),
(675, 'App\\Models\\NguoiDung', 27, 'api', 'ab519a42968ea604df2534e469987f0852f9a0b36eaa9a8839d14e7fe853a34d', '[\"*\"]', '2025-12-01 23:24:44', NULL, '2025-12-01 23:24:33', '2025-12-01 23:24:44'),
(677, 'App\\Models\\NguoiDung', 27, 'view_hopdong', 'fbd7248593ac72e0ca31ddd1bc535a06c22ca12b795881b3f466c55473bc6c2a', '[\"read\"]', NULL, NULL, '2025-12-01 23:27:20', '2025-12-01 23:27:20'),
(678, 'App\\Models\\NguoiDung', 27, 'view_hopdong', 'a9b03a5f4cae1bc8c73d653d9729aec44526020b607497c1fcc25605683c0abd', '[\"read\"]', NULL, NULL, '2025-12-01 23:45:22', '2025-12-01 23:45:22'),
(679, 'App\\Models\\NguoiDung', 3, 'api', '88b7b06cbac73943dab65f1cc8ce448299751e8c6a66f4ebd598e493664c3793', '[\"*\"]', '2025-12-01 23:58:39', NULL, '2025-12-01 23:47:08', '2025-12-01 23:58:39'),
(680, 'App\\Models\\NguoiDung', 1, 'api', '3cce63dbf20232cd87008b61da8137257807f2bc3dee814bc525fc2b67f26542', '[\"*\"]', '2025-12-01 23:51:52', NULL, '2025-12-01 23:48:08', '2025-12-01 23:51:52');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `phong`
--

CREATE TABLE `phong` (
  `id` int(11) NOT NULL,
  `day_tro_id` int(11) NOT NULL,
  `so_phong` varchar(50) NOT NULL,
  `gia` decimal(12,2) NOT NULL,
  `trang_thai` enum('trong','da_thue','bao_tri') NOT NULL DEFAULT 'trong',
  `suc_chua` int(11) NOT NULL,
  `dien_tich` decimal(8,2) NOT NULL,
  `tang` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `phong`
--

INSERT INTO `phong` (`id`, `day_tro_id`, `so_phong`, `gia`, `trang_thai`, `suc_chua`, `dien_tich`, `tang`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 1, 'A101', 2500000.00, 'da_thue', 2, 20.00, 3, '2025-10-11 11:36:01', '2025-11-17 05:24:36'),
(2, 1, 'A102', 2800000.00, 'da_thue', 2, 22.00, 1, '2025-10-11 11:36:01', '2025-11-17 05:24:36'),
(3, 2, 'B201', 3000000.00, 'da_thue', 3, 25.00, 2, '2025-10-11 11:36:01', '2025-11-17 05:24:36'),
(4, 3, 'C101', 3200000.00, 'da_thue', 2, 20.00, 1, '2025-10-11 11:36:01', '2025-11-17 05:24:36'),
(5, 4, 'D301', 3500000.00, 'da_thue', 3, 28.00, 3, '2025-10-11 11:36:01', '2025-11-17 05:24:36'),
(6, 5, 'E03', 3500000.00, 'da_thue', 2, 22.00, 2, '2025-10-19 10:41:25', '2025-10-25 01:22:52'),
(11, 5, 'E05', 3100000.00, 'trong', 3, 24.00, 2, '2025-10-22 22:21:31', '2025-11-05 18:42:07'),
(12, 2, 'B05', 2900000.00, 'trong', 3, 25.90, 4, '2025-10-22 22:34:07', '2025-11-07 16:30:15'),
(13, 5, 'E08', 1570000.00, 'trong', 2, 35.00, 2, '2025-10-26 20:22:40', '2025-10-26 20:22:40'),
(14, 6, 'A101', 2500000.00, 'trong', 2, 20.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(15, 6, 'A102', 2600000.00, 'trong', 2, 20.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(16, 7, 'B101', 2700000.00, 'trong', 2, 22.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(17, 7, 'B102', 2800000.00, 'trong', 3, 22.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(18, 8, 'C101', 2900000.00, 'trong', 2, 23.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(19, 8, 'C102', 3000000.00, 'trong', 3, 23.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(20, 9, 'D101', 3100000.00, 'trong', 2, 24.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(21, 9, 'D102', 3200000.00, 'trong', 3, 24.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(22, 10, 'E101', 3300000.00, 'trong', 2, 25.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(23, 10, 'E102', 3400000.00, 'trong', 3, 25.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(24, 11, 'A201', 2550000.00, 'trong', 2, 20.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(25, 11, 'A202', 2650000.00, 'trong', 3, 20.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(26, 12, 'B201', 2750000.00, 'trong', 2, 22.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(27, 12, 'B202', 2850000.00, 'trong', 3, 22.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(28, 13, 'C201', 2950000.00, 'trong', 2, 23.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(29, 13, 'C202', 3050000.00, 'trong', 3, 23.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(30, 14, 'D201', 3150000.00, 'trong', 2, 24.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(31, 14, 'D202', 3250000.00, 'trong', 3, 24.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(32, 15, 'E201', 3350000.00, 'trong', 2, 25.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(33, 15, 'E202', 3450000.00, 'trong', 3, 25.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(34, 16, 'A301', 2600000.00, 'trong', 2, 20.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(35, 16, 'A302', 2700000.00, 'trong', 3, 20.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(36, 17, 'B301', 2800000.00, 'trong', 2, 22.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(37, 17, 'B302', 2900000.00, 'trong', 3, 22.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(38, 18, 'C301', 3000000.00, 'trong', 2, 23.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(39, 18, 'C302', 3100000.00, 'trong', 3, 23.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(40, 19, 'D301', 3200000.00, 'trong', 2, 24.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(41, 19, 'D302', 3300000.00, 'trong', 3, 24.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(42, 20, 'E301', 3400000.00, 'trong', 2, 25.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(43, 20, 'E302', 3500000.00, 'trong', 3, 25.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(44, 21, 'A401', 2650000.00, 'trong', 2, 20.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(45, 21, 'A402', 2750000.00, 'trong', 3, 20.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(46, 22, 'B401', 2850000.00, 'trong', 2, 22.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(47, 22, 'B402', 2950000.00, 'trong', 3, 22.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(48, 23, 'C401', 3050000.00, 'trong', 2, 23.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(49, 23, 'C402', 3150000.00, 'trong', 3, 23.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(50, 24, 'D401', 3250000.00, 'trong', 2, 24.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(51, 24, 'D402', 3350000.00, 'trong', 3, 24.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(52, 25, 'E401', 3450000.00, 'trong', 2, 25.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(53, 25, 'E402', 3550000.00, 'trong', 3, 25.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(54, 26, 'A501', 2700000.00, 'trong', 2, 20.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(55, 26, 'A502', 2800000.00, 'trong', 3, 20.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(56, 27, 'B501', 2900000.00, 'trong', 2, 22.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(57, 27, 'B502', 3000000.00, 'trong', 3, 22.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(58, 28, 'C501', 3100000.00, 'trong', 2, 23.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(59, 28, 'C502', 3200000.00, 'trong', 3, 23.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(60, 29, 'D501', 3300000.00, 'trong', 2, 24.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(61, 29, 'D502', 3400000.00, 'trong', 3, 24.00, 2, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(62, 30, 'E501', 3500000.00, 'trong', 2, 25.00, 1, '2025-11-17 06:17:32', '2025-11-17 06:17:32'),
(63, 5, 'C105', 4000000.00, 'trong', 2, 25.00, 2, '2025-11-19 20:24:33', '2025-11-19 20:24:33'),
(64, 3, 'C107', 5000000.00, 'trong', 3, 25.00, 1, '2025-11-30 10:51:50', '2025-11-30 10:51:50');

--
-- Báº«y `phong`
--




-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `phong_tien_ich`
--

CREATE TABLE `phong_tien_ich` (
  `phong_id` int(11) NOT NULL,
  `tien_ich_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `phong_tien_ich`
--

INSERT INTO `phong_tien_ich` (`phong_id`, `tien_ich_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 5),
(3, 2);

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `phuong_tien`
--

CREATE TABLE `phuong_tien` (
  `id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `loai` enum('xe_may','xe_dap','o_to','khac') NOT NULL,
  `bien_so` varchar(20) NOT NULL,
  `mo_ta` varchar(255) NOT NULL,
  `hoat_dong` tinyint(4) NOT NULL DEFAULT 1,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `phuong_tien`
--

INSERT INTO `phuong_tien` (`id`, `khach_thue_id`, `loai`, `bien_so`, `mo_ta`, `hoat_dong`, `ngay_tao`) VALUES
(1, 4, 'xe_may', '59A1-12345', 'Xe mÃ¡y SH', 1, '2025-10-11 11:36:01'),
(2, 4, 'xe_may', '59B1-54321', 'Xe mÃ¡y AirBlade', 1, '2025-10-11 11:36:01'),
(3, 5, 'xe_dap', 'N/A', 'Xe Ä‘áº¡p Ä‘á»‹a hÃ¬nh', 1, '2025-10-11 11:36:01'),
(4, 5, 'o_to', '51H-99999', 'Xe Ã´ tÃ´ 4 chá»—', 1, '2025-10-11 11:36:01'),
(5, 5, 'xe_may', '59C1-88888', 'Xe mÃ¡y Vision', 1, '2025-10-11 11:36:01');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `tam_tru`
--

CREATE TABLE `tam_tru` (
  `id` int(11) NOT NULL,
  `hop_dong_id` int(11) NOT NULL,
  `ngay_lam` date NOT NULL,
  `co_quan` varchar(255) NOT NULL,
  `so_giay_to` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `tam_tru`
--

INSERT INTO `tam_tru` (`id`, `hop_dong_id`, `ngay_lam`, `co_quan`, `so_giay_to`) VALUES
(1, 1, '2025-01-05', 'CÃ´ng an Q1', 'TT001'),
(2, 2, '2025-02-05', 'CÃ´ng an Q1', 'TT002'),
(3, 3, '2025-01-20', 'CÃ´ng an Q5', 'TT003'),
(4, 4, '2025-03-10', 'CÃ´ng an Q5', 'TT004'),
(5, 5, '2025-04-10', 'CÃ´ng an Q3', 'TT005');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `id` int(11) NOT NULL,
  `hoa_don_id` int(11) NOT NULL,
  `ngay_thanh_toan` datetime NOT NULL,
  `so_tien` decimal(12,2) NOT NULL,
  `phuong_thuc` enum('tien_mat','chuyen_khoan','momo','zalopay','khac') NOT NULL,
  `ma_giao_dich` varchar(100) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `thanh_toan`
--

INSERT INTO `thanh_toan` (`id`, `hoa_don_id`, `ngay_thanh_toan`, `so_tien`, `phuong_thuc`, `ma_giao_dich`, `ngay_tao`) VALUES
(1, 1, '2025-01-05 00:00:00', 3200000.00, 'chuyen_khoan', 'GD001', '2025-10-11 11:36:01'),
(2, 2, '2025-02-06 00:00:00', 2000000.00, 'momo', 'GD002', '2025-10-11 11:36:01'),
(3, 4, '2025-03-05 00:00:00', 3930000.00, 'tien_mat', 'GD003', '2025-10-11 11:36:01'),
(4, 1, '2025-01-06 00:00:00', 500000.00, 'momo', 'GD004', '2025-10-11 11:36:01'),
(5, 2, '2025-02-08 00:00:00', 500000.00, 'zalopay', 'GD005', '2025-10-11 11:36:01');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id` int(11) NOT NULL,
  `nguoi_nhan_id` int(11) NOT NULL,
  `noi_dung` varchar(500) NOT NULL,
  `loai` varchar(50) DEFAULT NULL,
  `trang_thai` varchar(20) DEFAULT 'chua_doc',
  `lien_ket` varchar(255) DEFAULT NULL,
  `da_xem` tinyint(1) DEFAULT 0,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `thong_bao`
--

INSERT INTO `thong_bao` (`id`, `nguoi_nhan_id`, `noi_dung`, `loai`, `trang_thai`, `lien_ket`, `da_xem`, `ngay_tao`) VALUES
(1, 1, 'KhÃ¡ch Nguyá»…n VÄƒn A Ä‘Ã£ gá»­i yÃªu cáº§u thuÃª phÃ²ng A101', NULL, 'chua_doc', '/chu-tro/yeu-cau/1', 0, '2025-10-18 20:54:26'),
(2, 1, 'KhÃ¡ch Tráº§n Thá»‹ B muá»‘n thuÃª phÃ²ng B202', NULL, 'chua_doc', '/chu-tro/yeu-cau/2', 0, '2025-10-18 20:54:26'),
(3, 1, 'PhÃ²ng C303 vá»«a Ä‘Æ°á»£c xem 5 láº§n hÃ´m nay', NULL, 'chua_doc', '/chu-tro/phong/3', 1, '2025-10-18 20:54:26'),
(9, 3, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-05 11:34:10'),
(10, 3, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-05 11:48:53'),
(11, 3, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-05 11:52:32'),
(12, 3, 'KhÃ¡ch \"Pháº¡m Thá»‹ Linh\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-05 12:00:23'),
(124, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:36:55'),
(126, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:39:06'),
(127, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/36', 0, '2025-11-08 04:39:23'),
(129, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:42:33'),
(131, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:43:30'),
(132, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/37', 0, '2025-11-08 04:43:53'),
(134, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/37', 0, '2025-11-08 04:44:42'),
(135, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:48:15'),
(137, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:49:34'),
(138, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/38', 0, '2025-11-08 04:49:44'),
(140, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/38', 0, '2025-11-08 04:50:30'),
(141, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 04:59:17'),
(143, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:00:29'),
(144, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/39', 0, '2025-11-08 05:00:44'),
(146, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/39', 0, '2025-11-08 05:01:34'),
(147, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:04:42'),
(149, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:05:52'),
(150, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/40', 0, '2025-11-08 05:06:03'),
(152, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/40', 0, '2025-11-08 05:07:02'),
(153, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:08:41'),
(155, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:10:46'),
(156, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/42', 0, '2025-11-08 05:11:04'),
(158, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/42', 0, '2025-11-08 05:12:43'),
(159, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:14:05'),
(160, 2, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-08 12:14:34'),
(161, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 05:14:59'),
(162, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/43', 0, '2025-11-08 05:15:14'),
(163, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=43', 1, '2025-11-08 05:15:38'),
(164, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/43', 0, '2025-11-08 05:15:56'),
(165, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 08:29:01'),
(166, 2, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-08 15:30:35'),
(167, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 08:31:32'),
(168, 5, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ tá»« chá»‘i yÃªu cáº§u thuÃª cá»§a báº¡n.', NULL, 'chua_doc', '/khach-thue/yeu-cau-thue', 0, '2025-11-08 08:31:40'),
(169, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/44', 0, '2025-11-08 08:32:00'),
(170, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=44', 1, '2025-11-08 08:32:27'),
(171, 4, 'âŒ YÃªu cáº§u xÃ¡c nháº­n thanh toÃ¡n HÄ thÃ¡ng 2025-11 (phÃ²ng B201) Ä‘Ã£ bá»‹ tá»« chá»‘i. Vui lÃ²ng thanh toÃ¡n láº¡i qua QR vÃ  báº¥m xÃ¡c nháº­n.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/44', 0, '2025-11-08 08:32:55'),
(172, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=44', 1, '2025-11-08 08:33:27'),
(173, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/44', 0, '2025-11-08 08:33:49'),
(174, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 08:41:03'),
(175, 2, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-08 15:44:41'),
(176, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 08:45:10'),
(177, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/45', 0, '2025-11-08 08:45:37'),
(178, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=45', 1, '2025-11-08 08:46:17'),
(179, 4, 'âŒ YÃªu cáº§u xÃ¡c nháº­n thanh toÃ¡n HÄ thÃ¡ng 2025-11 (phÃ²ng B201) Ä‘Ã£ bá»‹ tá»« chá»‘i. Vui lÃ²ng thanh toÃ¡n láº¡i qua QR vÃ  báº¥m xÃ¡c nháº­n.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/45', 0, '2025-11-08 08:46:40'),
(180, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=45', 1, '2025-11-08 08:47:14'),
(181, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/45', 0, '2025-11-08 08:47:36'),
(182, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 09:51:09'),
(183, 2, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-08 20:08:31'),
(184, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 13:09:06'),
(185, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/46', 0, '2025-11-08 13:09:24'),
(186, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=46', 1, '2025-11-08 13:09:58'),
(187, 4, 'âŒ YÃªu cáº§u xÃ¡c nháº­n thanh toÃ¡n HÄ thÃ¡ng 2025-11 (phÃ²ng B201) Ä‘Ã£ bá»‹ tá»« chá»‘i. Vui lÃ²ng thanh toÃ¡n láº¡i qua QR vÃ  báº¥m xÃ¡c nháº­n.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/46', 0, '2025-11-08 13:10:19'),
(188, 2, 'ðŸ“¨ KhÃ¡ch thuÃª phÃ²ng B201 Ä‘Ã£ xÃ¡c nháº­n Ä‘Ã£ chuyá»ƒn khoáº£n thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11.', 'hoa_don', 'chua_doc', '/chu-tro/hoadon?id=46', 1, '2025-11-08 13:11:10'),
(189, 4, 'ðŸ’° Chá»§ trá» Ä‘Ã£ xÃ¡c nháº­n báº¡n Ä‘Ã£ thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/46', 0, '2025-11-08 13:11:27'),
(190, 4, 'Chá»§ trá» Ä‘Ã£ xÃ³a há»£p Ä‘á»“ng thuÃª cá»§a báº¡n cho phÃ²ng 3.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 13:12:13'),
(191, 2, 'KhÃ¡ch \"LÃª VÄƒn Kiá»‡t\" vá»«a gá»­i yÃªu cáº§u thuÃª phÃ²ng \"B201\"', NULL, 'chua_doc', '/chu-tro/yeu-cau-thue', 1, '2025-11-08 20:37:44'),
(192, 4, 'Chá»§ trá» Duy Báº£o Ä‘Ã£ cháº¥p nháº­n yÃªu cáº§u thuÃª vÃ  táº¡o há»£p Ä‘á»“ng cho phÃ²ng B201 - DÃ£y B.', NULL, 'chua_doc', '/khach-thue/hop-dong', 0, '2025-11-08 13:38:20'),
(193, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng B201.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/47', 0, '2025-11-08 13:38:40'),
(194, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2025-11 cho phÃ²ng D301.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/49', 0, '2025-11-08 13:40:24'),
(195, 4, 'ðŸ“© Chá»§ trá» yÃªu cáº§u thanh toÃ¡n hÃ³a Ä‘Æ¡n thÃ¡ng 2026-01 cho phÃ²ng A101.', 'hoa_don', 'chua_doc', '/khach-thue/hoa-don/41', 0, '2025-11-19 13:28:44');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `tien_ich`
--

CREATE TABLE `tien_ich` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `tien_ich`
--

INSERT INTO `tien_ich` (`id`, `ten`) VALUES
(4, 'BÃ n há»c'),
(3, 'GiÆ°á»ng vip'),
(2, 'MÃ¡y giáº·t'),
(1, 'MÃ¡y láº¡nh'),
(5, 'Tá»§ quáº§n');

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `yeu_cau_sua_chua`
--

CREATE TABLE `yeu_cau_sua_chua` (
  `id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `phong_id` int(11) NOT NULL,
  `loai` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT 'cho_xu_ly',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `yeu_cau_thue`
--

CREATE TABLE `yeu_cau_thue` (
  `id` int(11) NOT NULL,
  `bai_dang_id` int(11) NOT NULL,
  `phong_id` bigint(20) DEFAULT NULL,
  `chu_tro_id` int(11) DEFAULT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `cccd` varchar(20) DEFAULT NULL,
  `ghi_chu` varchar(500) DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `tien_coc` decimal(12,0) DEFAULT NULL,
  `file_hop_dong` varchar(255) DEFAULT NULL,
  `nguoi_than` text DEFAULT NULL,
  `trang_thai` enum('cho_duyet','chap_nhan','tu_choi','da_tao_hop_dong','huy','chu_tro_huy_hop_dong') NOT NULL DEFAULT 'cho_duyet',
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `yeu_cau_thue`
--

INSERT INTO `yeu_cau_thue` (`id`, `bai_dang_id`, `phong_id`, `chu_tro_id`, `khach_thue_id`, `cccd`, `ghi_chu`, `ngay_bat_dau`, `ngay_ket_thuc`, `tien_coc`, `file_hop_dong`, `nguoi_than`, `trang_thai`, `ngay_tao`) VALUES
(1, 1, 1, 2, 4, NULL, 'Test trigger', NULL, NULL, NULL, NULL, NULL, 'da_tao_hop_dong', '2025-10-18 21:04:51'),
(3, 1, 1, 2, 4, NULL, 'Muá»‘n thuÃª phÃ²ng â€“ test A', NULL, NULL, NULL, NULL, NULL, 'da_tao_hop_dong', '2025-10-25 11:54:11'),
(4, 2, 2, 2, 5, NULL, 'Xin xem phÃ²ng â€“ test B', NULL, NULL, NULL, NULL, NULL, 'da_tao_hop_dong', '2025-10-25 11:52:11'),
(5, 1, 1, 2, 5, NULL, 'Quan tÃ¢m phÃ²ng â€“ test C', NULL, NULL, NULL, NULL, NULL, 'tu_choi', '2025-10-25 11:49:11'),
(78, 3, 3, 2, 4, '01202490011', 'dÃ¢dad', '2025-11-19', '2025-12-16', 13000000, 'yeu_cau_files/iKqzcoXNmNhRsXRmj9dd4IUXYnvhNx41Hh4zQElB.pdf', '\"[{\\\"ho_ten\\\":\\\"bao co bap\\\",\\\"so_dien_thoai\\\":\\\"0854154248\\\",\\\"moi_quan_he\\\":\\\"ban\\\"}]\"', 'da_tao_hop_dong', '2025-11-08 13:37:44');

--
-- Báº«y `yeu_cau_thue`
--


-- --------------------------------------------------------

--
-- Cáº¥u trÃºc báº£ng cho báº£ng `yeu_thich`
--

CREATE TABLE `yeu_thich` (
  `id` int(11) NOT NULL,
  `khach_thue_id` int(11) NOT NULL,
  `bai_dang_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Äang Ä‘á»• dá»¯ liá»‡u cho báº£ng `yeu_thich`
--

INSERT INTO `yeu_thich` (`id`, `khach_thue_id`, `bai_dang_id`, `ngay_tao`) VALUES
(3, 4, 3, '2025-11-04 22:28:36'),
(9, 12, 104, '2025-11-30 22:02:40');

--
-- Chá»‰ má»¥c cho cÃ¡c báº£ng Ä‘Ã£ Ä‘á»•
--

--
-- Chá»‰ má»¥c cho báº£ng `anh_bai_dang`
--
ALTER TABLE `anh_bai_dang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_anh_baidang_order` (`bai_dang_id`,`thu_tu`),
  ADD KEY `idx_anh_baidang` (`bai_dang_id`);

--
-- Chá»‰ má»¥c cho báº£ng `bai_dang`
--
ALTER TABLE `bai_dang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_baidang_trangthai_gia` (`trang_thai`,`gia_niem_yet`),
  ADD KEY `idx_baidang_phong` (`phong_id`),
  ADD KEY `idx_baidang_nguoidung` (`nguoi_dung_id`);
-- ALTER TABLE `bai_dang` ADD FULLTEXT KEY `ft_baidang_title_desc` (`tieu_de`,`mo_ta`);

--
-- Chá»‰ má»¥c cho báº£ng `chi_so`
--
ALTER TABLE `chi_so`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cs_dongho` (`dong_ho_id`),
  ADD KEY `idx_cs_nguoinhap` (`nguoi_nhap_id`);

--
-- Chá»‰ má»¥c cho báº£ng `chi_tiet_dich_vu`
--
ALTER TABLE `chi_tiet_dich_vu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ctdv_hd` (`hoa_don_id`),
  ADD KEY `idx_ctdv_dv` (`dich_vu_id`);

--
-- Chá»‰ má»¥c cho báº£ng `chi_tiet_dong_ho`
--
ALTER TABLE `chi_tiet_dong_ho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ctdh_hd` (`hoa_don_id`),
  ADD KEY `idx_ctdh_dongho` (`dong_ho_id`),
  ADD KEY `idx_ctdh_dv` (`dich_vu_id`);

--
-- Chá»‰ má»¥c cho báº£ng `chu_tro`
--
ALTER TABLE `chu_tro`
  ADD PRIMARY KEY (`id`);

--
-- Chá»‰ má»¥c cho báº£ng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_dg_hd` (`hop_dong_id`),
  ADD KEY `idx_dg_khach` (`khach_thue_id`);

--
-- Chá»‰ má»¥c cho báº£ng `day_tro`
--
ALTER TABLE `day_tro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_daytro_chutro` (`chu_tro_id`);

--
-- Chá»‰ má»¥c cho báº£ng `dia_chi`
--
ALTER TABLE `dia_chi`
  ADD PRIMARY KEY (`id`);

--
-- Chá»‰ má»¥c cho báº£ng `dich_vu`
--
ALTER TABLE `dich_vu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_dv_ma` (`ma`);

--
-- Chá»‰ má»¥c cho báº£ng `dich_vu_dinh_ky`
--
ALTER TABLE `dich_vu_dinh_ky`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dvdk_phong` (`phong_id`),
  ADD KEY `idx_dvdk_dichvu` (`dich_vu_id`);

--
-- Chá»‰ má»¥c cho báº£ng `dong_ho`
--
ALTER TABLE `dong_ho`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_dh_code` (`ma_dong_ho`),
  ADD UNIQUE KEY `uq_dh_room_service` (`phong_id`,`dich_vu_id`),
  ADD KEY `idx_dh_phong` (`phong_id`),
  ADD KEY `idx_dh_dichvu` (`dich_vu_id`);

--
-- Chá»‰ má»¥c cho báº£ng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_hd_hopdong` (`hop_dong_id`),
  ADD KEY `idx_hd_thang` (`thang`);

--
-- Chá»‰ má»¥c cho báº£ng `hop_dong`
--
ALTER TABLE `hop_dong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_hd_khach` (`khach_thue_id`),
  ADD KEY `idx_hd_phong` (`phong_id`);

--
-- Chá»‰ má»¥c cho báº£ng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chá»‰ má»¥c cho báº£ng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chá»‰ má»¥c cho báº£ng `khach_thue`
--
ALTER TABLE `khach_thue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_khach_thue_user` (`nguoi_dung_id`);

--
-- Chá»‰ má»¥c cho báº£ng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chá»‰ má»¥c cho báº£ng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_phone` (`so_dien_thoai`),
  ADD UNIQUE KEY `uq_user_email` (`email`);

--
-- Chá»‰ má»¥c cho báº£ng `nguoi_than`
--
ALTER TABLE `nguoi_than`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_than_khach` (`khach_thue_id`);

--
-- Chá»‰ má»¥c cho báº£ng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chá»‰ má»¥c cho báº£ng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chá»‰ má»¥c cho báº£ng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_phong_daytro` (`day_tro_id`),
  ADD KEY `idx_phong_gia` (`gia`),
  ADD KEY `idx_phong_trangthai` (`trang_thai`);

--
-- Chá»‰ má»¥c cho báº£ng `phong_tien_ich`
--
ALTER TABLE `phong_tien_ich`
  ADD PRIMARY KEY (`phong_id`,`tien_ich_id`),
  ADD KEY `idx_pti_tienich` (`tien_ich_id`);

--
-- Chá»‰ má»¥c cho báº£ng `phuong_tien`
--
ALTER TABLE `phuong_tien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pt_khach` (`khach_thue_id`);

--
-- Chá»‰ má»¥c cho báº£ng `tam_tru`
--
ALTER TABLE `tam_tru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tt_hd` (`hop_dong_id`);

--
-- Chá»‰ má»¥c cho báº£ng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tt_magiaodich` (`ma_giao_dich`),
  ADD KEY `idx_tt_hd` (`hoa_don_id`);

--
-- Chá»‰ má»¥c cho báº£ng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_nhan_id` (`nguoi_nhan_id`);

--
-- Chá»‰ má»¥c cho báº£ng `tien_ich`
--
ALTER TABLE `tien_ich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tienich_ten` (`ten`);

--
-- Chá»‰ má»¥c cho báº£ng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chá»‰ má»¥c cho báº£ng `yeu_cau_sua_chua`
--
ALTER TABLE `yeu_cau_sua_chua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_thue_id` (`khach_thue_id`),
  ADD KEY `phong_id` (`phong_id`);

--
-- Chá»‰ má»¥c cho báº£ng `yeu_cau_thue`
--
ALTER TABLE `yeu_cau_thue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_yct_baidang` (`bai_dang_id`),
  ADD KEY `idx_yct_khach` (`khach_thue_id`);

--
-- Chá»‰ má»¥c cho báº£ng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_yeu_thich_unique` (`khach_thue_id`,`bai_dang_id`),
  ADD KEY `fk_yeu_thich_baidang` (`bai_dang_id`);

--
-- AUTO_INCREMENT cho cÃ¡c báº£ng Ä‘Ã£ Ä‘á»•
--

--
-- AUTO_INCREMENT cho báº£ng `anh_bai_dang`
--
ALTER TABLE `anh_bai_dang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT cho báº£ng `bai_dang`
--
ALTER TABLE `bai_dang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT cho báº£ng `chi_so`
--
ALTER TABLE `chi_so`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho báº£ng `chi_tiet_dich_vu`
--
ALTER TABLE `chi_tiet_dich_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho báº£ng `chi_tiet_dong_ho`
--
ALTER TABLE `chi_tiet_dong_ho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho báº£ng `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho báº£ng `day_tro`
--
ALTER TABLE `day_tro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho báº£ng `dia_chi`
--
ALTER TABLE `dia_chi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT cho báº£ng `dich_vu`
--
ALTER TABLE `dich_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho báº£ng `dich_vu_dinh_ky`
--
ALTER TABLE `dich_vu_dinh_ky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho báº£ng `dong_ho`
--
ALTER TABLE `dong_ho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho báº£ng `hoa_don`
--
ALTER TABLE `hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT cho báº£ng `hop_dong`
--
ALTER TABLE `hop_dong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT cho báº£ng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho báº£ng `khach_thue`
--
ALTER TABLE `khach_thue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT cho báº£ng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho báº£ng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT cho báº£ng `nguoi_than`
--
ALTER TABLE `nguoi_than`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho báº£ng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=681;

--
-- AUTO_INCREMENT cho báº£ng `phong`
--
ALTER TABLE `phong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho báº£ng `phuong_tien`
--
ALTER TABLE `phuong_tien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho báº£ng `tam_tru`
--
ALTER TABLE `tam_tru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho báº£ng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho báº£ng `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT cho báº£ng `tien_ich`
--
ALTER TABLE `tien_ich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho báº£ng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho báº£ng `yeu_cau_sua_chua`
--
ALTER TABLE `yeu_cau_sua_chua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho báº£ng `yeu_cau_thue`
--
ALTER TABLE `yeu_cau_thue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho báº£ng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- CÃ¡c rÃ ng buá»™c cho cÃ¡c báº£ng Ä‘Ã£ Ä‘á»•
--

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `anh_bai_dang`
--
ALTER TABLE `anh_bai_dang`
  ADD CONSTRAINT `fk_anh_baidang` FOREIGN KEY (`bai_dang_id`) REFERENCES `bai_dang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `bai_dang`
--
ALTER TABLE `bai_dang`
  ADD CONSTRAINT `fk_baidang_phong` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_baidang_user` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `chi_so`
--
ALTER TABLE `chi_so`
  ADD CONSTRAINT `fk_cs_dongho` FOREIGN KEY (`dong_ho_id`) REFERENCES `dong_ho` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cs_user` FOREIGN KEY (`nguoi_nhap_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `chi_tiet_dich_vu`
--
ALTER TABLE `chi_tiet_dich_vu`
  ADD CONSTRAINT `fk_ctdv_dv` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdv_hd` FOREIGN KEY (`hoa_don_id`) REFERENCES `hoa_don` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `chi_tiet_dong_ho`
--
ALTER TABLE `chi_tiet_dong_ho`
  ADD CONSTRAINT `fk_ctdh_dongho` FOREIGN KEY (`dong_ho_id`) REFERENCES `dong_ho` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_dv` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ctdh_hd` FOREIGN KEY (`hoa_don_id`) REFERENCES `hoa_don` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `chu_tro`
--
ALTER TABLE `chu_tro`
  ADD CONSTRAINT `fk_chu_tro_user` FOREIGN KEY (`id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `fk_dg_hd` FOREIGN KEY (`hop_dong_id`) REFERENCES `hop_dong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dg_khach` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `day_tro`
--
ALTER TABLE `day_tro`
  ADD CONSTRAINT `fk_daytro_chutro` FOREIGN KEY (`chu_tro_id`) REFERENCES `chu_tro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `dich_vu_dinh_ky`
--
ALTER TABLE `dich_vu_dinh_ky`
  ADD CONSTRAINT `fk_dvdk_dv` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dvdk_phong` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `dong_ho`
--
ALTER TABLE `dong_ho`
  ADD CONSTRAINT `fk_dh_dv` FOREIGN KEY (`dich_vu_id`) REFERENCES `dich_vu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dh_phong` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `fk_hd_hopdong` FOREIGN KEY (`hop_dong_id`) REFERENCES `hop_dong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `hop_dong`
--
ALTER TABLE `hop_dong`
  ADD CONSTRAINT `fk_hd_khach` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_hd_phong` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`) ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `khach_thue`
--
ALTER TABLE `khach_thue`
  ADD CONSTRAINT `fk_khach_thue_user` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `nguoi_than`
--
ALTER TABLE `nguoi_than`
  ADD CONSTRAINT `fk_than_khach` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `fk_phong_daytro` FOREIGN KEY (`day_tro_id`) REFERENCES `day_tro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `phong_tien_ich`
--
ALTER TABLE `phong_tien_ich`
  ADD CONSTRAINT `fk_pti_phong` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pti_tienich` FOREIGN KEY (`tien_ich_id`) REFERENCES `tien_ich` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `phuong_tien`
--
ALTER TABLE `phuong_tien`
  ADD CONSTRAINT `fk_pt_khach` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `tam_tru`
--
ALTER TABLE `tam_tru`
  ADD CONSTRAINT `fk_tamtru_hopdong` FOREIGN KEY (`hop_dong_id`) REFERENCES `hop_dong` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD CONSTRAINT `fk_thanhtoan_hoadon` FOREIGN KEY (`hoa_don_id`) REFERENCES `hoa_don` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `thong_bao_ibfk_1` FOREIGN KEY (`nguoi_nhan_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `yeu_cau_sua_chua`
--
ALTER TABLE `yeu_cau_sua_chua`
  ADD CONSTRAINT `yeu_cau_sua_chua_ibfk_1` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`),
  ADD CONSTRAINT `yeu_cau_sua_chua_ibfk_2` FOREIGN KEY (`phong_id`) REFERENCES `phong` (`id`);

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `yeu_cau_thue`
--
ALTER TABLE `yeu_cau_thue`
  ADD CONSTRAINT `fk_yct_bd` FOREIGN KEY (`bai_dang_id`) REFERENCES `bai_dang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yct_kh` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yeu_cau_thue_ibfk_1` FOREIGN KEY (`bai_dang_id`) REFERENCES `bai_dang` (`id`),
  ADD CONSTRAINT `yeu_cau_thue_ibfk_2` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`);

--
-- CÃ¡c rÃ ng buá»™c cho báº£ng `yeu_thich`
--
ALTER TABLE `yeu_thich`
  ADD CONSTRAINT `fk_yeu_thich_baidang` FOREIGN KEY (`bai_dang_id`) REFERENCES `bai_dang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yeu_thich_khach` FOREIGN KEY (`khach_thue_id`) REFERENCES `khach_thue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

