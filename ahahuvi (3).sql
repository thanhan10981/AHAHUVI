-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2024 lúc 12:11 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ahahuvi`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id_binh_luan` int(11) NOT NULL,
  `id_kh` int(11) DEFAULT NULL,
  `id_sp` int(11) DEFAULT NULL,
  `danh_gia` int(11) DEFAULT NULL,
  `noi_dung_binh_luan` text DEFAULT NULL,
  `ngay_tao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `binh_luan`
--

INSERT INTO `binh_luan` (`id_binh_luan`, `id_kh`, `id_sp`, `danh_gia`, `noi_dung_binh_luan`, `ngay_tao`) VALUES
(1, 1, 1, 5, 'truyện hay ', '2024-10-13'),
(2, 1, 2, 5, 'truyện hay \r\n', '2024-10-13'),
(3, 2, 1, 4, 'truyện bth', '2024-10-13'),
(4, 2, 2, 4, 'truyện bth', '2024-10-13'),
(5, 3, 1, 3, 'cũng tạm', '2024-10-13'),
(7, 3, 2, 4, 'cũng ok', '2024-12-08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc`
--

CREATE TABLE `danh_muc` (
  `id_danh_muc` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_muc`
--

INSERT INTO `danh_muc` (`id_danh_muc`, `ten_danh_muc`) VALUES
(1, 'VĂN HỌC'),
(2, 'SÁCH THIẾU NHI'),
(3, 'KINH TẾ'),
(4, 'TÂM LÝ - KĨ NĂNG SỐNG'),
(5, 'NUÔI DẠY CON'),
(6, 'TIỂU SỬ - HỒI KÝ'),
(7, ' SÁCH HỌC NGOẠI NGỮ'),
(8, 'GIÁO KHOA - THAM KHẢO');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id_don_hang` int(11) NOT NULL,
  `id_kh` int(11) DEFAULT NULL,
  `tong_tien` decimal(10,2) DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT 'đang giao',
  `dia_chi` varchar(255) DEFAULT NULL,
  `ngay_tao` date DEFAULT current_timestamp(),
  `pt_thanhtoan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id_don_hang`, `id_kh`, `tong_tien`, `trang_thai`, `dia_chi`, `ngay_tao`, `pt_thanhtoan`) VALUES
(27, 3, 50000.00, 'thành công', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-11-25', 'momo'),
(30, 3, 25000.00, 'thành công', '416 nguyễn thái học, nguyễn văn cừ ,quy nhơn , bình định', '2024-12-01', 'momo'),
(31, 3, 75000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-02', 'momo'),
(32, 3, 25000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-03', 'momo'),
(33, 3, 25000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-04', 'cash'),
(34, 3, 150000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-07', 'momo'),
(35, 3, 25000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-07', 'momo'),
(36, 3, 250000.00, 'đang giao', '764 Võ Văn Kiệt, Phường 1, Quận 5, Hồ Chí Minh', '2024-12-08', 'momo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giam_gia`
--

CREATE TABLE `giam_gia` (
  `id_giam_gia` int(11) NOT NULL,
  `ma` varchar(255) DEFAULT NULL,
  `gia_giam` decimal(10,2) DEFAULT NULL,
  `phan_tram` int(11) DEFAULT NULL,
  `sl` int(11) DEFAULT NULL,
  `ngay_tao` date DEFAULT NULL,
  `hsd` date DEFAULT NULL,
  `dieu_kien` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giam_gia`
--

INSERT INTO `giam_gia` (`id_giam_gia`, `ma`, `gia_giam`, `phan_tram`, `sl`, `ngay_tao`, `hsd`, `dieu_kien`) VALUES
(1, 'AHAHUVINGUOIMOI10K', 10000.00, 10, 97, '2024-10-29', '2025-10-29', 130000),
(2, 'Mã giảm 25k', 25000.00, 10, 1000, '2024-10-29', '2025-10-29', 280000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `id_gio_hang` int(11) NOT NULL,
  `id_kh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `gio_hang`
--

INSERT INTO `gio_hang` (`id_gio_hang`, `id_kh`) VALUES
(24, NULL),
(25, NULL),
(26, NULL),
(27, NULL),
(28, NULL),
(29, NULL),
(30, NULL),
(23, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ho_tro`
--

CREATE TABLE `ho_tro` (
  `ma_ht` int(10) NOT NULL,
  `ma_kh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `ten_kh` varchar(255) DEFAULT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `dich_vu` text DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `ngay_tao` date DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ho_tro`
--

INSERT INTO `ho_tro` (`ma_ht`, `ma_kh`, `ten_kh`, `sdt`, `email`, `dich_vu`, `noi_dung`, `ngay_tao`, `trang_thai`) VALUES
(2, '2', 'võ thanh an', '0932541103', 'voan10981@gmail.com', 'service1', 'cần mua sách', '2024-11-16', 'Chờ xử lý'),
(15, '3', 'võ thanh an', '0932541103', 'voan10981@gmail.com', 'Tu-van-online', 'tôi bị lỗi mua hàng', '2024-12-07', 'Chờ xử lý');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `mkh` int(11) NOT NULL,
  `ten_kh` varchar(255) DEFAULT NULL,
  `gioi_tinh` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `mk` varchar(255) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`mkh`, `ten_kh`, `gioi_tinh`, `email`, `sdt`, `mk`, `ngay_sinh`, `dia_chi`) VALUES
(1, 'Trương Ngọc Hân', 'Nữ', 'hanhan@gmail.com', '0123456789', 'hanhan', '2024-10-13', 'Nhơn Phú, Quy Nhơn, Bình Định'),
(2, 'Trần Hoàng Vinh', 'Nam', 'vinh@gmail.com', '0123456789', 'vinh', '2024-10-13', 'quy nhơn , bình định'),
(3, 'Võ Thanh An', 'Nam', 'Anvo10981@gmail.com', '0369554541', 'an', '2004-07-14', '245 nguyễn thái,Xã Quan Lạn,Huyện Vân Đồn,Tỉnh Quảng Ninh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho`
--

CREATE TABLE `kho` (
  `id_sp` int(11) NOT NULL,
  `sl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `kho`
--

INSERT INTO `kho` (`id_sp`, `sl`) VALUES
(2, 0),
(9, 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `mnv` int(11) NOT NULL,
  `ten_nhan_vien` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `mk` varchar(255) DEFAULT NULL,
  `ngay_tao` date DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhan_vien`
--

INSERT INTO `nhan_vien` (`mnv`, `ten_nhan_vien`, `email`, `sdt`, `mk`, `ngay_tao`, `dia_chi`) VALUES
(1, 'Võ thanh an', 'voan10981@gmail.com', '0369554541', 'nnnnnnnn', '2024-12-14', '416 nguyễn thái học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `id_nhacungcap` int(11) NOT NULL,
  `ten_nhacungcap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`id_nhacungcap`, `ten_nhacungcap`) VALUES
(1, 'Nhà xuất bản Kim Đồng'),
(2, 'Đinh Tị'),
(3, 'NXB trẻ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quang_cao`
--

CREATE TABLE `quang_cao` (
  `id_quang_cao` int(11) NOT NULL,
  `ten` varchar(255) DEFAULT NULL,
  `vi_tri` varchar(255) DEFAULT NULL,
  `ngay_tao` date DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quang_cao`
--

INSERT INTO `quang_cao` (`id_quang_cao`, `ten`, `vi_tri`, `ngay_tao`, `ngay_bat_dau`, `ngay_ket_thuc`) VALUES
(1, 'NccMcbooksVang.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(2, 'ctthang12_herobanner.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(3, 'Tranglich2025.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(4, 'TrangDCGS_0711_ResizeBanner.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(5, 'ThienLong_KC.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(6, 'TanViet_banner.png', 'anh-quang_cao-chinh', '2024-12-09', '2024-12-09', '2025-01-30'),
(7, 'trangpatnership.png', 'anh-quang_cao-giam_gia1', '2024-12-09', '2024-12-09', '2025-01-30'),
(8, 'vnpay_ngay_sale_t11.png', 'anh-quang_cao-giam_gia2', '2024-12-09', '2024-12-09', '2025-01-30'),
(9, 'header_banner.png', 'header', '2024-12-09', '2024-12-09', '2025-01-30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `id_sp` int(11) NOT NULL,
  `ten_sp` varchar(255) DEFAULT NULL,
  `id_the_loai` int(11) DEFAULT NULL,
  `id_danh_muc` int(11) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL,
  `gia_giam` decimal(10,2) DEFAULT NULL,
  `phan_tram` int(11) DEFAULT NULL,
  `anh_bia` varchar(255) DEFAULT NULL,
  `anh_phu` varchar(255) DEFAULT NULL,
  `tac_gia` varchar(255) DEFAULT NULL,
  `nxb` varchar(255) DEFAULT NULL,
  `nha_xb` varchar(255) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `id_ncc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`id_sp`, `ten_sp`, `id_the_loai`, `id_danh_muc`, `gia`, `gia_giam`, `phan_tram`, `anh_bia`, `anh_phu`, `tac_gia`, `nxb`, `nha_xb`, `mo_ta`, `id_ncc`) VALUES
(1, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 36', 201, 2, 25.00, 0.00, 0, 'mikobiachinh30.png', 'truyentranhmiko.png', 'ONO Eriko', '2030', '0', 'Miko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 201, 2, 25000.00, 23000.00, 8, 'truyentranhmiko37.png', 'truyentranhmiko37.png,truyentranhmiko37.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!!', 3),
(3, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 35 ', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh35.png', 'mikobiachinh35.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 35\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!? Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý. Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình!', 3),
(4, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 34', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh34.png', 'mikobiachinh34.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 34\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(5, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 33 ', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh33.png', 'mikobiachinh35.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 33\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(6, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 32', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh32.png', 'mikobiachinh32.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 32\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!? Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý. Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình!', 3),
(7, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 31 ', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh31.png', 'mikobiachinh31.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 31\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(8, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 30 ', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh30.png', 'mikobiachinh30.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 30\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(9, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 22 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh22.png', 'mikobiachinh22.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 22\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(10, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 23 (Tái Bản 2023)', 201, 2, 25.00, 23.00, 8, 'mikobiachinh23.png', 'mikobiachinh23.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 23\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(11, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 24(Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh24.png', 'mikobiachinh24.png', 'ONO Eriko', '2023', 'Trẻ', '', 3),
(12, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 25 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh25.png', 'mikobiachinh25.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 25\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(13, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 26 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh26.png', 'mikobiachinh26.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 26\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(14, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 27 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh27.png', 'mikobiachinh27.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 27\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(15, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 28 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh28.png', 'mikobiachinh28.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 28\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!?♥ Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý ★ Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình! Lại còn bài phát biểu cực kỳ quan trọng nữa chứ!!!??? Trời ơi? Muốn đọc quá đi ~!!! ', 3),
(16, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 29 (Tái Bản 2023)', 201, 2, 25000.00, 23000.00, 8, 'mikobiachinh29.png', 'mikobiachinh29.png', 'ONO Eriko', '2023', 'Trẻ', 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 29\r\n\r\nMiko là cô nhóc lớp 6 vô cùng hoạt bát, khỏe khoắn. Ngày nào cũng rộn ràng, náo nhiệt cùng gia đình và bạn bè xung quanh ☆ Trong những chuỗi ngày ấy, Mari rốt cuộc lại đóng vai thần tình yêu Cupid để tác hợp cho Miko và Tappei...!? Và thế là tình cảm của hai cô cậu trở thành tâm điểm chú ý. Tập này còn đầy ắp những câu chuyện về cô nhóc Miko đáng yêu, như chạy tiếp sức trong hội thao cuối cùng của thời tiểu học, câu chuyện đau xót của Rinka hay những chuyện bí mật của con gái chúng mình!', 3),
(68, 'a', 211, 1, 1.00, 0.00, 0, 'binh_nuoc.png', 'dau-tu-tuong-lai.png', 'a', 'a', 'a', 'a', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham_dat_mua`
--

CREATE TABLE `san_pham_dat_mua` (
  `id_spdatmua` int(11) NOT NULL,
  `id_don_hang` int(11) DEFAULT NULL,
  `id_sp` int(11) DEFAULT NULL,
  `ten_sp` varchar(255) NOT NULL,
  `sl` int(11) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL,
  `thanh_tien` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham_dat_mua`
--

INSERT INTO `san_pham_dat_mua` (`id_spdatmua`, `id_don_hang`, `id_sp`, `ten_sp`, `sl`, `gia`, `thanh_tien`) VALUES
(12, 27, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 1, 25000.00, 25000),
(14, 30, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 1, 25000.00, 25000),
(15, 31, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 3, 25000.00, 75000),
(16, 32, 4, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 34', 1, 25000.00, 25000),
(17, 33, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 1, 25000.00, 25000),
(18, 34, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 3, 25000.00, 75000),
(19, 34, 4, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 34', 3, 25000.00, 75000),
(20, 35, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 1, 25000.00, 25000),
(21, 36, 2, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 37', 10, 25000.00, 250000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham_gio_hang`
--

CREATE TABLE `san_pham_gio_hang` (
  `id_sp` int(11) NOT NULL,
  `id_gio_hang` int(11) DEFAULT NULL,
  `ten_sp` varchar(255) DEFAULT NULL,
  `sl` int(11) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham_gio_hang`
--

INSERT INTO `san_pham_gio_hang` (`id_sp`, `id_gio_hang`, `ten_sp`, `sl`, `gia`) VALUES
(3, 24, 'Nhóc Miko! Cô Bé Nhí Nhảnh - Tập 35 ', 1, 25000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tai_khoan_quan_tri`
--

CREATE TABLE `tai_khoan_quan_tri` (
  `ma_tai_khoan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `mat_khau` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `ho_ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tai_khoan_quan_tri`
--

INSERT INTO `tai_khoan_quan_tri` (`ma_tai_khoan`, `mat_khau`, `email`, `ho_ten`) VALUES
('Anvo10981', 'Anvo10981', 'Voan10981@gmail.com', 'Võ Thanh An');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai`
--

CREATE TABLE `the_loai` (
  `id_the_loai` int(11) NOT NULL,
  `id_danh_muc` int(11) DEFAULT NULL,
  `ten_the_loai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `the_loai`
--

INSERT INTO `the_loai` (`id_the_loai`, `id_danh_muc`, `ten_the_loai`) VALUES
(201, 2, 'Truyện tranh - comic'),
(202, 2, 'Truyện tranh thiếu nhi'),
(203, 2, 'Truyện đọc thiếu nhi'),
(204, 2, 'Truyện tranh Ehon Nhật Bản'),
(205, 2, 'Sách kĩ năng sống cho trẻ '),
(206, 2, 'Vừa học vừa chơi với trẻ'),
(207, 2, 'Sách kiến thức sống cho trẻ'),
(208, 2, 'Hỏi đáp - câu đố - trò chơi'),
(209, 2, 'Kiến thức bách khoa'),
(210, 2, 'Bách khoa tri thức - câu hỏi vì sao'),
(211, 1, 'Tuổi Teen'),
(212, 1, 'Tiểu thuyết'),
(213, 1, 'Truyện Ngắn -Tản Văn'),
(214, 1, 'Truyện Trinh Thám - Kiếm Hiệp'),
(215, 1, 'Tác Phẩm Kinh Điển'),
(216, 1, 'Huyền Bí - Giả Tưởng - Kinh Dị'),
(217, 1, 'Ngôn Tình'),
(218, 1, 'Thơ Ca, Tục Ngữ, Ca Dao, Thành Ngữ'),
(219, 1, 'Du ký'),
(220, 1, 'Hài Hước - Truyện Cười'),
(221, 3, 'Quản Trị - Lãnh Đạo'),
(222, 3, 'Nhân vật - Bài Học Kinh doanh'),
(223, 3, 'Marketing - Bán Hàng'),
(224, 3, 'Khởi Nghiệp - Làm Giàu'),
(225, 3, 'Phân Tích Kinh Tế'),
(226, 3, 'Chứng Khoán - Bất Động Sản - Đầu Tư'),
(227, 3, 'Tài Chính - Ngân Hàng'),
(228, 3, 'Nhân Sự - Việc Làm'),
(229, 3, 'Kế Toán - Kiểm Toán - Thuế'),
(230, 3, 'Ngoại Thương'),
(231, 4, 'Kỹ năng sống'),
(232, 4, 'Tâm lý'),
(233, 4, 'Sách cho tuổi mới lớn'),
(234, 4, 'Chicken Soup - Hạt Giống Tâm Hồn'),
(235, 4, 'Rèn luyện nhân cách'),
(236, 5, 'Phát Triển Kỹ Năng - Trí Tuệ Cho Trẻ'),
(237, 5, 'Phương Pháp Giáo Dục Trẻ Các Nước'),
(238, 5, 'Dinh Dưỡng - Sức Khỏe Cho Trẻ'),
(239, 5, 'Giáo Dục Trẻ Tuổi Teen'),
(240, 5, 'Dành Cho Mẹ Bầu'),
(241, 5, 'Cẩm Nang Làm Cha Mẹ'),
(242, 6, 'Lịch Sử'),
(243, 6, 'Nghệ Thuật - Giải Trí'),
(244, 6, 'Chính Trị'),
(245, 6, 'Kinh Tế'),
(246, 6, 'Thể Thao'),
(247, 6, 'Câu Chuyện Cuộc Đời'),
(248, 7, 'Tiếng Anh'),
(249, 7, 'Tiếng Hoa'),
(250, 7, 'Tiếng Nhật'),
(251, 7, 'Tiếng Hàn'),
(252, 7, 'Tiếng Việt cho người nước ngoài'),
(253, 7, 'Ngoại ngữ khác'),
(254, 7, 'Tiếng Pháp'),
(255, 7, 'Tiếng Đức'),
(256, 8, 'Sách Tham Khảo'),
(257, 8, 'Sách Giáo Khoa'),
(258, 8, 'Mẫu Giáo'),
(259, 8, 'Sách giáo viên'),
(260, 8, 'Đại học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_bao`
--

CREATE TABLE `thong_bao` (
  `id_thong_bao` int(11) NOT NULL,
  `id_kh` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thong_bao`
--

INSERT INTO `thong_bao` (`id_thong_bao`, `id_kh`, `noi_dung`) VALUES
(2, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-03 10:04:49'),
(3, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-03 10:10:49'),
(4, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-03 21:36:20'),
(5, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-07 21:11:09'),
(6, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-07 22:24:55'),
(7, 3, 'Bạn vừa đặt thành công đơn hàng lúc 2024-12-08 14:05:05');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id_binh_luan`),
  ADD KEY `id_kh` (`id_kh`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Chỉ mục cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  ADD PRIMARY KEY (`id_danh_muc`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id_don_hang`),
  ADD KEY `don_hang_ibfk_1` (`id_kh`);

--
-- Chỉ mục cho bảng `giam_gia`
--
ALTER TABLE `giam_gia`
  ADD PRIMARY KEY (`id_giam_gia`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`id_gio_hang`),
  ADD KEY `id_kh` (`id_kh`);

--
-- Chỉ mục cho bảng `ho_tro`
--
ALTER TABLE `ho_tro`
  ADD PRIMARY KEY (`ma_ht`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`mkh`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`id_sp`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`mnv`);

--
-- Chỉ mục cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`id_nhacungcap`);

--
-- Chỉ mục cho bảng `quang_cao`
--
ALTER TABLE `quang_cao`
  ADD PRIMARY KEY (`id_quang_cao`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id_sp`),
  ADD KEY `id_the_loai` (`id_the_loai`),
  ADD KEY `id_danh_muc` (`id_danh_muc`),
  ADD KEY `fk_ncc` (`id_ncc`);

--
-- Chỉ mục cho bảng `san_pham_dat_mua`
--
ALTER TABLE `san_pham_dat_mua`
  ADD PRIMARY KEY (`id_spdatmua`),
  ADD KEY `id_dơn_hang` (`id_don_hang`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Chỉ mục cho bảng `san_pham_gio_hang`
--
ALTER TABLE `san_pham_gio_hang`
  ADD PRIMARY KEY (`id_sp`),
  ADD KEY `id_gio_hang` (`id_gio_hang`);

--
-- Chỉ mục cho bảng `tai_khoan_quan_tri`
--
ALTER TABLE `tai_khoan_quan_tri`
  ADD PRIMARY KEY (`ma_tai_khoan`);

--
-- Chỉ mục cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`id_the_loai`),
  ADD KEY `fk_danhmuc` (`id_danh_muc`);

--
-- Chỉ mục cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD PRIMARY KEY (`id_thong_bao`),
  ADD KEY `id_kh` (`id_kh`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id_binh_luan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `danh_muc`
--
ALTER TABLE `danh_muc`
  MODIFY `id_danh_muc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id_don_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `giam_gia`
--
ALTER TABLE `giam_gia`
  MODIFY `id_giam_gia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `id_gio_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `ho_tro`
--
ALTER TABLE `ho_tro`
  MODIFY `ma_ht` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `mkh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `mnv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `id_nhacungcap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `quang_cao`
--
ALTER TABLE `quang_cao`
  MODIFY `id_quang_cao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT cho bảng `san_pham_dat_mua`
--
ALTER TABLE `san_pham_dat_mua`
  MODIFY `id_spdatmua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `san_pham_gio_hang`
--
ALTER TABLE `san_pham_gio_hang`
  MODIFY `id_sp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  MODIFY `id_the_loai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  MODIFY `id_thong_bao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`id_kh`) REFERENCES `khach_hang` (`mkh`),
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`id_sp`) REFERENCES `san_pham` (`id_sp`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`id_kh`) REFERENCES `khach_hang` (`mkh`);

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`id_kh`) REFERENCES `khach_hang` (`mkh`);

--
-- Các ràng buộc cho bảng `kho`
--
ALTER TABLE `kho`
  ADD CONSTRAINT `kho_ibfk_1` FOREIGN KEY (`id_sp`) REFERENCES `san_pham` (`id_sp`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_ncc` FOREIGN KEY (`id_ncc`) REFERENCES `nha_cung_cap` (`id_nhacungcap`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`id_the_loai`) REFERENCES `the_loai` (`id_the_loai`),
  ADD CONSTRAINT `san_pham_ibfk_2` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id_danh_muc`);

--
-- Các ràng buộc cho bảng `san_pham_gio_hang`
--
ALTER TABLE `san_pham_gio_hang`
  ADD CONSTRAINT `san_pham_gio_hang_ibfk_1` FOREIGN KEY (`id_gio_hang`) REFERENCES `gio_hang` (`id_gio_hang`),
  ADD CONSTRAINT `san_pham_gio_hang_ibfk_2` FOREIGN KEY (`id_sp`) REFERENCES `san_pham` (`id_sp`);

--
-- Các ràng buộc cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD CONSTRAINT `fk_danhmuc` FOREIGN KEY (`id_danh_muc`) REFERENCES `danh_muc` (`id_danh_muc`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `thong_bao_ibfk_1` FOREIGN KEY (`id_kh`) REFERENCES `khach_hang` (`mkh`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
