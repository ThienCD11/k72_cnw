-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 08, 2024 lúc 09:59 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `k72_nhom_23`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoi_xet_tuyen`
--

CREATE TABLE `khoi_xet_tuyen` (
  `id_khoi` int(50) NOT NULL,
  `ten_khoi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mon1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mon2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mon3` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_nganh` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khoi_xet_tuyen`
--

INSERT INTO `khoi_xet_tuyen` (`id_khoi`, `ten_khoi`, `mon1`, `mon2`, `mon3`, `id_nganh`) VALUES
(1, 'A00', 'Toán', 'Lý', 'Hóa', 1),
(2, 'A01', 'Toán', 'Lý', 'Anh', 1),
(3, 'A00', 'Toán', 'Lý', 'Hóa', 2),
(4, 'A01', 'Toán', 'Lý', 'Anh', 2),
(5, 'A00', 'Toán', 'Lý', 'Hóa', 3),
(6, 'A02', 'Toán', 'Lý', 'Sinh', 3),
(7, 'A00', 'Toán', 'Lý', 'Hóa', 4),
(8, 'A01', 'Toán', 'Lý', 'Anh', 4),
(9, 'B00', 'Toán', 'Hóa', 'Sinh', 5),
(10, 'D07', 'Toán', 'Hóa', 'Anh', 5),
(11, 'C00', 'Văn', 'Sử', 'Địa', 6),
(12, 'D01', 'Văn', 'Toán', 'Anh', 6),
(13, 'C00', 'Văn', 'Sử', 'Địa', 7),
(14, 'C03', 'Văn', 'Toán', 'Sử', 7),
(15, 'C00', 'Văn', 'Sử', 'Địa', 8),
(16, 'C04', 'Văn', 'Toán', 'Địa', 8),
(17, 'A02', 'Toán', 'Lý', 'Sinh', 9),
(18, 'B00', 'Toán', 'Hóa', 'Sinh', 9),
(19, 'A00', 'Toán', 'Lý', 'Hóa', 10),
(20, 'D01', 'Toán', 'Văn', 'Anh', 11),
(21, 'D01', 'Toán', 'Văn', 'Anh', 12),
(22, 'D03', 'Toán', 'Văn', 'Pháp', 13),
(23, 'D04', 'Toán', 'Văn', 'Trung', 14),
(24, 'C00', 'Văn', 'Sử', 'Địa', 15),
(25, 'D01', 'Toán', 'Văn', 'Anh', 16),
(26, 'C01', 'Toán', 'Văn', 'Lý', 17),
(27, 'D01', 'Toán', 'Văn', 'Anh', 18),
(28, 'D01', 'Toán', 'Văn', 'Anh', 19),
(29, 'D01', 'Toán', 'Văn', 'Anh', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nganh_hoc`
--

CREATE TABLE `nganh_hoc` (
  `id_nganh` int(20) NOT NULL,
  `ten_nganh` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `an_hien` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'hiện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nganh_hoc`
--

INSERT INTO `nganh_hoc` (`id_nganh`, `ten_nganh`, `ngay_bat_dau`, `ngay_ket_thuc`, `an_hien`) VALUES
(1, 'Công nghệ thông tin', '2024-11-01', '2024-12-13', 'hiện'),
(2, 'Sư phạm Tin học', '2024-11-01', '2024-12-13', 'hiện'),
(3, 'Sư phạm Toán học', '2024-11-01', '2024-12-13', 'hiện'),
(4, 'Sư phạm Vật lý', '2024-11-01', '2024-12-13', 'hiện'),
(5, 'Sư phạm Hóa học', '2024-11-01', '2024-12-13', 'hiện'),
(6, 'Sư phạm Ngữ văn', '2024-11-01', '2024-12-13', 'hiện'),
(7, 'Sư phạm Lịch sử', '2024-11-01', '2024-12-13', 'hiện'),
(8, 'Sư phạm Địa lý', '2024-11-01', '2024-12-13', 'hiện'),
(9, 'Sư phạm Sinh học', '2024-11-01', '2024-12-13', 'hiện'),
(10, 'Sư phạm Công nghệ', '2024-11-01', '2024-12-13', 'hiện'),
(11, 'Ngôn ngữ Anh', '2024-11-01', '2024-12-13', 'hiện'),
(12, 'Sư phạm Tiếng Anh', '2024-11-01', '2024-12-13', 'hiện'),
(13, 'Sư phạm Tiếng Pháp', '2024-11-01', '2024-12-13', 'hiện'),
(14, 'Sư phạm Tiếng Trung', '2024-11-01', '2024-12-13', 'hiện'),
(15, 'Giáo dục Công dân', '2024-11-01', '2024-12-13', 'hiện'),
(16, 'Giáo dục Thể chất', '2024-11-01', '2024-12-13', 'hiện'),
(17, 'Giáo dục Tiểu học', '2024-11-01', '2024-12-13', 'hiện'),
(18, 'Giáo dục QP - AN', '2024-11-01', '2024-12-13', 'hiện'),
(19, 'Giáo dục Pháp luật', '2024-11-01', '2024-12-13', 'hiện'),
(20, 'Giáo dục Đặc biệt', '2024-11-01', '2024-12-13', 'hiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id_nguoi_dung` int(10) NOT NULL,
  `tai_khoan` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vai_tro` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id_nguoi_dung`, `tai_khoan`, `mat_khau`, `vai_tro`) VALUES
(1, 'admin', 'b4b147bc522828731f1a016bfa72c073', 'admin'),
(2, 'giaovien', '6512bd43d9caa6e02c990b0a82652dca', 'giáo viên'),
(3, 'hocsinh', 'b6d767d2f8ed5d21a44b0e5886680cb9', 'học sinh'),
(13, 'a', '0cc175b9c0f1b6a831c399e269772661', 'học sinh'),
(14, 'd', '0cc175b9c0f1b6a831c399e269772661', 'giáo viên'),
(17, 'e', '4a8a08f09d37b73795649038408b5f33', 'giáo viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_tin`
--

CREATE TABLE `thong_tin` (
  `id_hoc_sinh` int(50) NOT NULL,
  `ho_ten_hoc_sinh` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nganh_nop_ho_so` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `khoi_xet` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mon1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diem1` decimal(4,2) NOT NULL,
  `mon2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diem2` decimal(4,2) NOT NULL,
  `mon3` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diem3` decimal(4,2) NOT NULL,
  `hoc_ba` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nguoi_duyet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thong_tin`
--

INSERT INTO `thong_tin` (`id_hoc_sinh`, `ho_ten_hoc_sinh`, `nganh_nop_ho_so`, `khoi_xet`, `mon1`, `diem1`, `mon2`, `diem2`, `mon3`, `diem3`, `hoc_ba`, `nguoi_duyet`, `trang_thai`) VALUES
(1, 'Cao Đức Thiện', 'Công nghệ thông tin', 'A00', 'Toán', '9.00', 'Lý', '9.00', 'Hóa', '9.00', '../hoc_ba/20241124_105930.png', 'chưa có', 'chưa duyệt'),
(2, 'Cao Đức Thiện 2', 'Công nghệ thông tin', 'A01', 'Toán', '9.00', 'Lý', '8.00', 'Anh', '10.00', '../hoc_ba/20241124_110032.png', 'admin', 'không duyệt'),
(3, 'Cao Đức Thiện 3', 'Công nghệ thông tin', 'A00', 'Toán', '10.00', 'Lý', '8.00', 'Hóa', '10.00', '../hoc_ba/20241124_110050.png', 'admin', 'đã duyệt'),
(4, 'Cao Đức Thiện', 'Sư phạm Tin học', 'A00', 'Toán', '9.00', 'Lý', '9.00', 'Hóa', '8.00', '../hoc_ba/20241124_110131.png', 'admin', 'đã duyệt'),
(5, 'Cao Đức Thiện 2', 'Sư phạm Tin học', 'A01', 'Toán', '9.00', 'Lý', '8.00', 'Anh', '8.00', '../hoc_ba/20241124_110151.png', 'admin', 'không duyệt'),
(6, 'Cao Đức Thiện', 'Sư phạm Ngữ văn', 'C00', 'Văn', '9.00', 'Sử', '9.00', 'Địa', '9.00', '../hoc_ba/20241124_110227.png', 'giáo viên', 'đã duyệt'),
(7, 'Cao Đức Thiện 2', 'Sư phạm Ngữ văn', 'D01', 'Văn', '9.00', 'Toán', '8.00', 'Anh', '9.00', '../hoc_ba/20241124_110244.png', 'admin', 'không duyệt'),
(8, 'Cao Đức Thiện', 'Sư phạm Tiếng Anh', 'D01', 'Toán', '9.00', 'Văn', '9.00', 'Anh', '8.00', '../hoc_ba/20241124_110318.png', 'giáo viên', 'đã duyệt'),
(9, 'Cao Đức Thiện 2', 'Sư phạm Tiếng Anh', 'D01', 'Toán', '8.00', 'Văn', '8.00', 'Anh', '8.00', '../hoc_ba/20241124_110336.png', 'chưa có', 'chưa duyệt'),
(10, 'Cao Đức Thiện', 'Sư phạm Toán học', 'A00', 'Toán', '10.00', 'Lý', '10.00', 'Hóa', '10.00', '../hoc_ba/20241124_110403.png', 'admin', 'đã duyệt'),
(11, 'Cao Đức Thiện 2', 'Sư phạm Toán học', 'A02', 'Toán', '10.00', 'Lý', '10.00', 'Sinh', '9.75', '../hoc_ba/20241124_110451.png', 'admin', 'đã duyệt'),
(12, 'Cao Đức Thiện 3', 'Sư phạm Toán học', 'A00', 'Toán', '9.25', 'Lý', '9.50', 'Hóa', '9.75', '../hoc_ba/20241124_110515.png', 'chưa có', 'chưa duyệt'),
(13, 'Cao Đức Thiện', 'Sư phạm Hóa học', 'B00', 'Toán', '8.00', 'Hóa', '9.00', 'Sinh', '8.00', '../hoc_ba/20241124_110648.png', 'giáo viên', 'không duyệt'),
(14, 'Cao Đức Thiện 2', 'Sư phạm Hóa học', 'D07', 'Toán', '8.00', 'Hóa', '9.00', 'Anh', '9.75', '../hoc_ba/20241124_110709.png', 'giáo viên', 'đã duyệt'),
(15, 'Cao Đức Thiện', 'Sư phạm Vật lý', 'A00', 'Toán', '9.00', 'Lý', '9.00', 'Hóa', '9.00', '../hoc_ba/20241124_110731.png', 'giáo viên', 'đã duyệt'),
(16, 'Cao Đức Thiện 2', 'Sư phạm Vật lý', 'A01', 'Toán', '9.00', 'Lý', '9.00', 'Anh', '9.00', '../hoc_ba/20241124_110752.png', 'admin', 'đã duyệt'),
(17, 'Cao Đức Thiện', 'Sư phạm Địa lý', 'C00', 'Văn', '8.00', 'Sử', '9.00', 'Địa', '8.00', '../hoc_ba/20241124_110820.png', 'admin', 'không duyệt'),
(18, 'Cao Đức Thiện', 'Sư phạm Sinh học', 'A02', 'Toán', '9.00', 'Lý', '9.00', 'Sinh', '8.00', '../hoc_ba/20241124_110847.png', 'chưa có', 'chưa duyệt'),
(19, 'Cao Đức Thiện 2', 'Sư phạm Địa lý', 'C00', 'Văn', '8.00', 'Sử', '8.00', 'Địa', '8.00', '../hoc_ba/20241125_110327.png', 'chưa có', 'chưa duyệt'),
(20, 'Cao Đức Thiện', 'Sư phạm Lịch sử', 'C00', 'Văn', '9.00', 'Sử', '9.00', 'Địa', '9.00', '../hoc_ba/20241126_184752.png', 'chưa có', 'chưa duyệt');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `khoi_xet_tuyen`
--
ALTER TABLE `khoi_xet_tuyen`
  ADD PRIMARY KEY (`id_khoi`),
  ADD KEY `fk_khoi_xet` (`id_nganh`);

--
-- Chỉ mục cho bảng `nganh_hoc`
--
ALTER TABLE `nganh_hoc`
  ADD PRIMARY KEY (`id_nganh`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id_nguoi_dung`);

--
-- Chỉ mục cho bảng `thong_tin`
--
ALTER TABLE `thong_tin`
  ADD PRIMARY KEY (`id_hoc_sinh`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `khoi_xet_tuyen`
--
ALTER TABLE `khoi_xet_tuyen`
  MODIFY `id_khoi` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `nganh_hoc`
--
ALTER TABLE `nganh_hoc`
  MODIFY `id_nganh` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id_nguoi_dung` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `thong_tin`
--
ALTER TABLE `thong_tin`
  MODIFY `id_hoc_sinh` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `khoi_xet_tuyen`
--
ALTER TABLE `khoi_xet_tuyen`
  ADD CONSTRAINT `fk_khoi_xet` FOREIGN KEY (`id_nganh`) REFERENCES `nganh_hoc` (`id_nganh`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
