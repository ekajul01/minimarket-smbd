-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2022 at 04:39 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket-smbd`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `jumlahKtgr` (INOUT `ktgrList` INT(11))  BEGIN
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE idKategori VARCHAR(100) DEFAULT "";

	-- declare cursor for employee email
	DECLARE curKategori 
		CURSOR FOR 
			SELECT COUNT(id_kategori) FROM kategori;

	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET finished = 1;

	OPEN curKategori;

	getKategori: LOOP
		FETCH curKategori INTO idKategori;
		IF finished = 1 THEN 
			LEAVE getKategori;
		END IF;
		-- build email list
		SET ktgrList = CONCAT(idKategori);
	END LOOP getKategori;
	
	CLOSE curKategori;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_countIDBarang` (OUT `jumlahbrg` INT(11))  BEGIN
		SELECT COUNT(id_barang) INTO jumlahbrg FROM barang;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_countStok` (OUT `stok1` INT(11))  BEGIN
		SELECT SUM(stok) INTO stok1 FROM barang;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_countTerjual` (OUT `jmljual` INT(11))  BEGIN
		SELECT SUM(jumlah) INTO jmljual FROM nota;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_upktgr` (IN `id` INT(5), IN `nama` VARCHAR(20))  BEGIN
		UPDATE kategori SET
		nama_kategori = nama
		WHERE id_kategori = id;
	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(10) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `satuan_barang` varchar(20) NOT NULL,
  `stok` int(11) NOT NULL,
  `tgl_input` varchar(50) NOT NULL,
  `tgl_update` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `tgl_input`, `tgl_update`) VALUES
(1, 'BR001', 1, 'Pensil Faber Casteel', 'Faber Casteel', 3000, 3500, 'PCS', 17, '20 June 2022, 12:08', ''),
(2, 'BR002', 1, 'Penghapus Joyko', 'Joyko', 800, 1500, 'PCS', 8, '20 June 2022, 12:10', NULL),
(3, 'BR003', 2, 'Pocky Coklat', 'PT Glico Indonesia', 7000, 8500, 'PCS', 12, '20 June 2022, 12:12', '20 June 2022, 12:12'),
(4, 'BR004', 5, 'Sabun Lifeboy', 'Unilever', 2500, 4000, 'PCS', 17, '20 June 2022, 12:13', NULL),
(5, 'BR005', 3, 'Susu Bear Brand', 'Nestle', 8000, 11000, 'PCS', 21, '20 June 2022, 12:14', NULL),
(6, 'BR006', 4, 'Antangin', 'Sidomuncul', 2000, 3000, 'PCS', 15, '20 June 2022, 12:15', NULL),
(7, 'BR007', 2, 'Siipp', 'Nabati', 2000, 2500, 'PCS', 9, '20 June 2022, 12:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(64) NOT NULL,
  `tgl_input` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tgl_input`) VALUES
(1, 'ATK', '20 June 2022, 12:06'),
(2, 'Makanan', '20 June 2022, 12:06'),
(3, 'Minuman', '20 June 2022, 12:07'),
(4, 'Obat', '20 June 2022, 12:07'),
(5, 'Sabun', '20 June 2022, 12:07'),
(6, 'Sampo', '20 June 2022, 12:07');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `user` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `id_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `user`, `pass`, `id_member`) VALUES
(1, 'admin2', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `nm_member` varchar(32) NOT NULL,
  `alamat_member` text NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `email` varchar(50) NOT NULL,
  `NIK` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nm_member`, `alamat_member`, `telepon`, `email`, `NIK`) VALUES
(1, 'Niken Ayy', 'Telang Indah', '081123456781', 'nikenayy@gmail.com', '123654897');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_barang` varchar(10) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal_input` varchar(50) NOT NULL,
  `periode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`id_nota`, `id_barang`, `id_member`, `jumlah`, `total`, `tanggal_input`, `periode`) VALUES
(1, 'BR001', 1, 3, 10500, '20 May 2022, 12:19', '05-2022'),
(2, 'BR002', 1, 2, 3000, '20 May 2022, 12:20', '05-2022'),
(3, 'BR005', 1, 1, 11000, '20 June 2022, 12:28', '06-2022'),
(4, 'BR003', 1, 3, 25500, '20 June 2022, 12:31', '06-2022'),
(5, 'BR007', 1, 1, 2500, '20 June 2022, 12:46', '06-2022'),
(6, 'BR004', 1, 3, 12000, '29 June 2022, 14:30', '06-2022'),
(7, 'BR005', 1, 2, 22000, '4 July 2022, 9:10', '07-2022'),
(8, 'BR005', 1, 1, 11000, '18 December 2022, 10:38', '12-2022');

--
-- Triggers `nota`
--
DELIMITER $$
CREATE TRIGGER `updateStok` AFTER INSERT ON `nota` FOR EACH ROW BEGIN
		Update barang set stok = stok - NEW.jumlah 
		where id_barang = NEW.id_barang;
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` varchar(10) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal_input` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(32) NOT NULL,
  `alamat_toko` text NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `nama_pemilik` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `alamat_toko`, `tlp`, `nama_pemilik`) VALUES
(1, 'Toko Neka', 'Telang Indah', '087753494096', 'Niken Ayu');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_barang`
-- (See below for the actual view)
--
CREATE TABLE `v_barang` (
`id` int(11)
,`id_barang` varchar(10)
,`id_kategori` int(11)
,`nama_barang` varchar(100)
,`merk` varchar(50)
,`harga_beli` int(11)
,`harga_jual` int(11)
,`satuan_barang` varchar(20)
,`stok` int(11)
,`tgl_input` varchar(50)
,`tgl_update` varchar(50)
,`nama_kategori` varchar(64)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_laporan2`
-- (See below for the actual view)
--
CREATE TABLE `v_laporan2` (
`ID_Barang` varchar(10)
,`Nama_Barang` varchar(100)
,`Jumlah` int(11)
,`Modal` bigint(21)
,`Total` int(11)
,`Nama_Kasir` varchar(32)
,`Tanggal_Input` varchar(50)
,`Periode` varchar(20)
);

-- --------------------------------------------------------

--
-- Structure for view `v_barang`
--
DROP TABLE IF EXISTS `v_barang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang`  AS SELECT `a`.`id` AS `id`, `a`.`id_barang` AS `id_barang`, `a`.`id_kategori` AS `id_kategori`, `a`.`nama_barang` AS `nama_barang`, `a`.`merk` AS `merk`, `a`.`harga_beli` AS `harga_beli`, `a`.`harga_jual` AS `harga_jual`, `a`.`satuan_barang` AS `satuan_barang`, `a`.`stok` AS `stok`, `a`.`tgl_input` AS `tgl_input`, `a`.`tgl_update` AS `tgl_update`, `b`.`nama_kategori` AS `nama_kategori` FROM (`barang` `a` join `kategori` `b`) WHERE `a`.`id_kategori` = `b`.`id_kategori` ;

-- --------------------------------------------------------

--
-- Structure for view `v_laporan2`
--
DROP TABLE IF EXISTS `v_laporan2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_laporan2`  AS SELECT `a`.`id_barang` AS `ID_Barang`, `b`.`nama_barang` AS `Nama_Barang`, `a`.`jumlah` AS `Jumlah`, `b`.`harga_beli`* `a`.`jumlah` AS `Modal`, `a`.`total` AS `Total`, `c`.`nm_member` AS `Nama_Kasir`, `a`.`tanggal_input` AS `Tanggal_Input`, `a`.`periode` AS `Periode` FROM ((`nota` `a` join `barang` `b`) join `member` `c`) WHERE `a`.`id_barang` = `b`.`id_barang` AND `a`.`id_member` = `c`.`id_member` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
