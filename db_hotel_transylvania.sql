-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2022 at 11:06 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hotel_transylvania`
--

-- --------------------------------------------------------

--
-- Table structure for table `tkamar`
--

CREATE TABLE `tkamar` (
  `no_kamar` varchar(3) NOT NULL,
  `jenis_kamar` enum('Standar','Single','Double','Family','Suite') DEFAULT NULL,
  `status` enum('Lengkap','Tidak Lengkap') DEFAULT NULL,
  `fasilitas` varchar(20) DEFAULT NULL,
  `harga` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tkamar`
--

INSERT INTO `tkamar` (`no_kamar`, `jenis_kamar`, `status`, `fasilitas`, `harga`) VALUES
('101', 'Suite', 'Lengkap', 'Kulkas', 3000000),
('102', 'Double', 'Lengkap', 'Televisi', 200000),
('103', 'Family', 'Tidak Lengkap', 'Extra bed', 1500000),
('104', 'Standar', 'Tidak Lengkap', 'Kupon sarapan', 100000),
('105', 'Single', 'Lengkap', 'Extra bantal', 150000),
('301', 'Single', 'Lengkap', 'apaaja', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tmemesan`
--

CREATE TABLE `tmemesan` (
  `no_pemesanan` int(5) NOT NULL,
  `id_petugas` varchar(5) DEFAULT NULL,
  `no_kamar` varchar(3) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `banyak_orang` int(2) DEFAULT NULL,
  `lama_inap` int(2) DEFAULT NULL,
  `tgl_check_in` datetime DEFAULT NULL,
  `tgl_check_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tmemesan`
--

INSERT INTO `tmemesan` (`no_pemesanan`, `id_petugas`, `no_kamar`, `nik`, `banyak_orang`, `lama_inap`, `tgl_check_in`, `tgl_check_out`) VALUES
(1, 'P0001', '101', '320405873109002', 1, 3, '2022-07-13 19:24:43', '2022-07-16 19:24:52'),
(5, 'P0001', '102', '317502192819633', 1, 1, '2022-07-16 19:27:03', '2022-07-17 19:27:08'),
(6, 'P0001', '103', '320621863180920', 4, 4, '2022-07-18 19:32:48', '2022-07-22 19:32:59'),
(18, 'P0001', '104', '326028918190038', 2, 2, '2022-07-27 19:38:26', '2022-07-29 19:38:31'),
(19, 'P0001', '105', '320361361838218', 1, 2, '2022-07-04 19:42:03', '2022-07-06 19:42:10'),
(28, 'P0001', '103', '320361361838218', 2, 1, '2022-07-29 08:34:41', '2022-07-29 08:34:41'),
(33, 'P0003', '101', '326028918190038', 2, 1, '2022-07-29 08:43:23', '2022-07-29 08:43:23'),
(35, 'P0004', '102', '317502192819633', 2, 5, '2022-07-15 13:49:00', '2022-07-22 13:49:00'),
(36, 'P0004', '102', '317502192819633', 2, 5, '2022-07-15 13:49:00', '2022-07-22 13:49:00'),
(37, 'P0001', '102', '320361361838218', 2, 28, '2022-07-29 14:28:00', '2022-08-26 15:29:00'),
(41, 'P0002', '103', '326028918190038', 2, 7, '2022-07-30 14:57:00', '2022-08-06 11:57:00'),
(42, NULL, '101', '320361361838218', 1, 1, '2022-07-30 16:28:00', '2022-07-31 18:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `tpelanggan`
--

CREATE TABLE `tpelanggan` (
  `nik` varchar(16) NOT NULL,
  `nama_pelanggan` varchar(30) DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `nama_pengguna` varchar(10) NOT NULL,
  `kata_sandi` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tpelanggan`
--

INSERT INTO `tpelanggan` (`nik`, `nama_pelanggan`, `telepon`, `nama_pengguna`, `kata_sandi`) VALUES
('317502192819633', 'Oman', '089213789217', 'gemjeeh', 'gataugue'),
('3175021928196333', 'test ea', '089777856478', 'test ea', 'hayuq'),
('320361361838218', 'Jalis', '081361736179', 'jaleez', 'apaiyah1'),
('320405873109002', 'Winda ', '085167834521', 'windasmr', 'haisay15'),
('320621863180920', 'Irvin ', '087381786310', 'irveen', 'rotikeju'),
('326028918190038', 'Rayaaaaa', '089731910029', 'xray', 'sukakamu');

-- --------------------------------------------------------

--
-- Table structure for table `tpembayaran`
--

CREATE TABLE `tpembayaran` (
  `no_pembayaran` int(5) NOT NULL,
  `opsi_bayar` enum('Tunai','Non Tunai') NOT NULL,
  `nilai_bayar` int(7) NOT NULL,
  `no_pemesanan` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tpembayaran`
--

INSERT INTO `tpembayaran` (`no_pembayaran`, `opsi_bayar`, `nilai_bayar`, `no_pemesanan`) VALUES
(14, 'Tunai', 3000000, 1),
(15, 'Tunai', 200000, 5),
(16, 'Non Tunai', 1500000, 6),
(17, 'Tunai', 100000, 18),
(18, 'Non Tunai', 150000, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tpetugas`
--

CREATE TABLE `tpetugas` (
  `id_petugas` varchar(5) NOT NULL,
  `nama_petugas` varchar(15) NOT NULL,
  `jabatan` enum('Petugas Resepsionis','Petugas Administrasi','Petugas Bagian Keuangan','Pramukamar') NOT NULL,
  `nama_pengguna` varchar(10) NOT NULL,
  `kata_sandi` varchar(8) NOT NULL,
  `no_lantai` varchar(2) DEFAULT NULL,
  `pelayanan` varchar(20) DEFAULT NULL,
  `tugas_keuangan` varchar(20) DEFAULT NULL,
  `tugas_administrasi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tpetugas`
--

INSERT INTO `tpetugas` (`id_petugas`, `nama_petugas`, `jabatan`, `nama_pengguna`, `kata_sandi`, `no_lantai`, `pelayanan`, `tugas_keuangan`, `tugas_administrasi`) VALUES
('P0001', 'David John', 'Petugas Administrasi', 'rogers63', 'rog6633', NULL, NULL, NULL, 'Mengelola Laporan'),
('P0002', 'Roger Paul', 'Petugas Bagian Keuangan', 'mike28', 'mik2288', NULL, NULL, 'Validasi Pembayaran', NULL),
('P0003', 'Maria Sanders', 'Petugas Resepsionis', 'rivera92', 'riv9922', NULL, 'Mencatat Pemesanan', NULL, NULL),
('P0004', 'Morris Miller', 'Pramukamar', 'morris85', 'mor8855', '4', NULL, NULL, NULL),
('P0020', 'Daniel Michaela', 'Petugas Administrasi', 'daniel78', 'dan7788', '2', NULL, NULL, NULL),
('P0088', 'irvinnnn', 'Pramukamar', 'irvinw', 'irvinw', '3', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tkamar`
--
ALTER TABLE `tkamar`
  ADD PRIMARY KEY (`no_kamar`);

--
-- Indexes for table `tmemesan`
--
ALTER TABLE `tmemesan`
  ADD PRIMARY KEY (`no_pemesanan`),
  ADD KEY `nik` (`nik`),
  ADD KEY `no_kamar` (`no_kamar`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `tpelanggan`
--
ALTER TABLE `tpelanggan`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `tpembayaran`
--
ALTER TABLE `tpembayaran`
  ADD PRIMARY KEY (`no_pembayaran`),
  ADD KEY `no_pemesanan` (`no_pemesanan`);

--
-- Indexes for table `tpetugas`
--
ALTER TABLE `tpetugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tmemesan`
--
ALTER TABLE `tmemesan`
  MODIFY `no_pemesanan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tpembayaran`
--
ALTER TABLE `tpembayaran`
  MODIFY `no_pembayaran` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tmemesan`
--
ALTER TABLE `tmemesan`
  ADD CONSTRAINT `tmemesan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `tpelanggan` (`nik`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tmemesan_ibfk_2` FOREIGN KEY (`no_kamar`) REFERENCES `tkamar` (`no_kamar`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tmemesan_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `tpetugas` (`id_petugas`);

--
-- Constraints for table `tpembayaran`
--
ALTER TABLE `tpembayaran`
  ADD CONSTRAINT `tpembayaran_ibfk_1` FOREIGN KEY (`no_pemesanan`) REFERENCES `tmemesan` (`no_pemesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
