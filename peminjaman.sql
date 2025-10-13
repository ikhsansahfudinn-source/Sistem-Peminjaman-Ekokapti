-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table peminjaman.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(120) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.admin: ~2 rows (approximately)
INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
	(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500'),
	(2, 'Administrator', 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- Dumping structure for table peminjaman.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int NOT NULL AUTO_INCREMENT,
  `penanggung_jawab` varchar(120) DEFAULT NULL,
  `kode_type` varchar(120) NOT NULL,
  `nama_barang` varchar(120) NOT NULL,
  `jumlah` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `harga` int NOT NULL,
  `denda` int NOT NULL,
  `pengantaran` int DEFAULT NULL,
  `pengambilan` int DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.barang: ~11 rows (approximately)
INSERT INTO `barang` (`id_barang`, `penanggung_jawab`, `kode_type`, `nama_barang`, `jumlah`, `status`, `harga`, `denda`, `pengantaran`, `pengambilan`, `gambar`) VALUES
	(23, 'Ezra', 'PO', 'Kabel Lapangan Voli', '2', '1', 5000, 500, 1, 1, 'kabel-removebg-preview.png'),
	(24, 'Ezra', 'PO', 'Lampu LED voli', '12', '1', 10000, 2000, 1, 1, 'lampu-removebg-preview.png'),
	(25, 'Ezra', 'PO', 'Fitting LED voli', '17', '1', 12000, 2500, 1, 1, 'fitting_led.jpeg'),
	(26, 'Ezra', 'PO', 'Lampu sorot voli', '13', '1', 20000, 5000, 0, 1, 'lampu-sorot.png'),
	(27, 'Ezra', 'PO', 'Lampu 36 w', '3', '1', 15000, 3000, 0, 1, 'lampu_36_w.jpg'),
	(28, 'Karima', 'PS', 'Meja saten besar', '2', '1', 50000, 10000, 0, 1, 'meja_saten-removebg-preview.png'),
	(29, 'Karima', 'PS', 'Meja saten kecil', '2', '1', 35000, 8000, 1, 1, 'meja_saten_kecil.png'),
	(30, 'Karima', 'PS', 'Nampan', '12', '1', 7000, 1500, 1, 1, 'nampan-removebg-preview.png'),
	(31, 'Karima', 'PS', 'Toples kerupuk', '2', '1', 7500, 1500, 1, 1, 'toples1.png'),
	(32, 'Karima', 'PS', 'Wakul nasi', '2', '1', 8000, 2000, 1, 1, 'wakul1.png'),
	(33, 'Karima', 'PNS', 'Lemari alat', '-', '1', 1, 1, 0, 0, 'lemari.png');

-- Dumping structure for table peminjaman.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id_customer` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(120) NOT NULL,
  `penanggung_jawab` varchar(120) NOT NULL,
  `username` varchar(120) NOT NULL,
  `alamat` varchar(120) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `no_ktp` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.customer: ~7 rows (approximately)
INSERT INTO `customer` (`id_customer`, `nama`, `penanggung_jawab`, `username`, `alamat`, `gender`, `no_telp`, `no_ktp`, `password`, `role_id`) VALUES
	(27, 'Ikhsan', '', 'Ikhsan', 'Ngrandu', 'Laki-laki', '081230253468', '340106190401', 'bc939c4e66cfde482283a675507333dc', 1),
	(28, 'Ezra', 'Ezra', 'Ezra', 'Ngrandu', 'Laki-laki', '0812546087', '34020338383838', '8beb6443d15f540099bb756f62b629a3', 3),
	(29, 'Karima', 'Karima', 'Karima', 'Ngrandu', 'Laki-laki', '08245678910', '34012345678', '89fa8dcd8e0bf3ba4904bc1b444d50eb', 3),
	(30, 'Tri', '', 'Tri', 'Ngrandu', 'Laki-laki', '0834676654124', '3401064576890001', 'b85593ca6abda3f203e0af8239beb228', 2),
	(31, 'Sipa', '', 'Sipa', 'Ngrandu', 'Perempuan', '081230253468', '340198765129', 'e10adc3949ba59abbe56e057f20f883e', 2),
	(32, 'test', '', 'admin1', 'test alamat', 'Laki-laki', '2340932432', '2934893294234', '827ccb0eea8a706c4c34a16891f84e7b', 1),
	(33, 'test', '', 'admin2', 'test alamat', 'Laki-laki', '2340932432', '2934893294234', '827ccb0eea8a706c4c34a16891f84e7b', 2);

-- Dumping structure for table peminjaman.payment
CREATE TABLE IF NOT EXISTS `payment` (
  `id_payment` int NOT NULL AUTO_INCREMENT,
  `nama_payment` varchar(120) NOT NULL,
  `key_payment` varchar(120) NOT NULL,
  `atas_nama` varchar(120) DEFAULT NULL,
  `penanggung_jawab` varchar(120) NOT NULL,
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.payment: ~15 rows (approximately)
INSERT INTO `payment` (`id_payment`, `nama_payment`, `key_payment`, `atas_nama`, `penanggung_jawab`) VALUES
	(2, 'Bank BRI', '42367482374', 'Mang Group', 'Jaya Rental'),
	(3, 'Bank Kai', '123', NULL, 'Murah Rental'),
	(6, 'nro', 'ljk', NULL, 'Murah Rental'),
	(7, 'jkjk', '899', 'fdsfs', 'Murah Rental'),
	(8, 'Paypal', 'mang@mangkok.com', 'Mang Group', 'Jaya Rental'),
	(9, 'BANK BRI', '478657865432656', 'Sejahtera Travel', 'Sejahtera Travel'),
	(10, 'DANA', '08115656777', 'Sejahtera Travel', 'Sejahtera Travel'),
	(11, 'OVO', '08115656777', 'Sejahtera Travel', 'Sejahtera Travel'),
	(12, 'BANK BNI', '2367489773', 'Sejahtera Travel', 'Sejahtera Travel'),
	(13, 'BANK MANDIRI', '3493439897432', 'Sejahtera Travel', 'Sejahtera Travel'),
	(14, 'BANK BRI', '324349897689743', 'Permata Rental', 'Permata Rental'),
	(15, 'BANK BNI', '2487539893', 'Permata Rental', 'Permata Rental'),
	(16, 'BANK BRI', '47254587854765', 'Putra Riau Travel', 'Putra Riau Travel'),
	(17, 'BANK BNI', '5247698584', 'Putra Riau Travel', 'Putra Riau Travel'),
	(18, 'BANK MANDIRI', '4373487899322', 'Putra Riau Travel', 'Putra Riau Travel');

-- Dumping structure for table peminjaman.rental
CREATE TABLE IF NOT EXISTS `rental` (
  `id_pinjam` int NOT NULL AUTO_INCREMENT,
  `id_customer` int NOT NULL,
  `tanggal_rental` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status_rental` varchar(50) NOT NULL,
  `status_pengembalian` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.rental: ~0 rows (approximately)

-- Dumping structure for table peminjaman.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_pinjam` int NOT NULL AUTO_INCREMENT,
  `id_customer` int NOT NULL,
  `id_barang` int NOT NULL,
  `penanggung_jawab` varchar(120) NOT NULL,
  `tanggal_rental` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `harga` int NOT NULL,
  `denda` int NOT NULL,
  `total_denda` varchar(120) NOT NULL DEFAULT '0',
  `tanggal_pengembalian` date NOT NULL,
  `status_pengembalian` varchar(50) NOT NULL,
  `status_rental` varchar(50) NOT NULL,
  `bukti_pembayaran` varchar(130) NOT NULL,
  `status_pembayaran` int NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id_pinjam`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.transaksi: ~14 rows (approximately)
INSERT INTO `transaksi` (`id_pinjam`, `id_customer`, `id_barang`, `penanggung_jawab`, `tanggal_rental`, `tanggal_kembali`, `harga`, `denda`, `total_denda`, `tanggal_pengembalian`, `status_pengembalian`, `status_rental`, `bukti_pembayaran`, `status_pembayaran`, `jumlah`) VALUES
	(28, 30, 23, 'Ezra', '2025-01-03', '2025-01-05', 5000, 500, '16500', '2025-01-08', 'Kembali', 'Selesai', 'ktp_ikhsan.pdf', 1, 1),
	(30, 30, 23, 'Ezra', '2025-01-13', '2025-01-17', 5000, 500, '27000', '2025-01-21', 'Kembali', 'Selesai', '', 1, 2),
	(38, 30, 26, 'Ezra', '2025-01-13', '2025-01-16', 20000, 5000, '0', '0000-00-00', 'Belum Kembali', 'Belum Selesai', '', 0, 2),
	(41, 30, 30, 'Karima', '2025-01-20', '2025-01-22', 7000, 1500, '0', '0000-00-00', 'Belum Kembali', 'Belum Selesai', '', 0, 2),
	(60, 32, 23, '', '2025-01-20', '2025-01-21', 5000, 500, '0', '0000-00-00', 'Belum Kembali', 'Belum Selesai', '', 0, 2),
	(66, 32, 23, 'Ezra', '2025-01-15', '2025-01-22', 5000, 500, '0', '0000-00-00', 'Belum Kembali', 'Belum Selesai', '', 0, 1),
	(67, 33, 23, 'Ezra', '2025-01-23', '2025-01-24', 5000, 500, '10500', '2025-01-25', 'Kembali', 'Selesai', '', 1, 2),
	(68, 33, 23, 'Ezra', '2025-01-25', '2025-01-26', 5000, 500, '10000', '2025-01-26', 'Kembali', 'Selesai', '', 1, 1),
	(69, 33, 23, 'Ezra', '2025-01-23', '2025-01-24', 5000, 500, '10000', '0000-00-00', 'Belum Kembali', 'Selesai', 'Screenshot_2024-12-31_135925.png', 1, 2),
	(72, 33, 24, 'Ezra', '2025-02-25', '2025-02-26', 10000, 2000, '20000', '2025-02-26', 'Kembali', 'Selesai', 'Screenshot_2024-12-31_1359251.png', 1, 3),
	(73, 33, 24, 'Ezra', '2025-02-27', '2025-02-28', 10000, 2000, '20000', '2025-02-28', 'Kembali', 'Selesai', '476609224_526927330434244_9113456161546298531_n.jpg', 1, 1),
	(74, 33, 24, 'Ezra', '2025-02-28', '2025-03-01', 10000, 2000, '20000', '2025-03-01', 'Kembali', 'Selesai', '476609224_526927330434244_9113456161546298531_n.jpg', 1, 1),
	(75, 33, 23, 'Ezra', '2025-03-02', '2025-03-04', 5000, 500, '0', '0000-00-00', 'Belum Kembali', 'Belum Selesai', 'Gf9P7YBa0AA8OH0.jpg', 0, 1),
	(78, 33, 24, 'Ezra', '2025-02-27', '2025-02-28', 10000, 2000, '20000', '2025-02-28', 'Kembali', 'Selesai', 'Gf9P7YBa0AA8OH01.jpg', 1, 1);

-- Dumping structure for table peminjaman.type
CREATE TABLE IF NOT EXISTS `type` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `kode_type` varchar(10) NOT NULL,
  `nama_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table peminjaman.type: ~3 rows (approximately)
INSERT INTO `type` (`id_type`, `kode_type`, `nama_type`) VALUES
	(1, 'PO', 'Peralatan Olahraga'),
	(2, 'PS', 'Peralatan Sinoman'),
	(3, 'PNS', 'Peralatan Non Sewa');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
