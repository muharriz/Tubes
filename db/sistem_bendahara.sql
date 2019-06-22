-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2019 at 06:51 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_bendahara`
--

-- --------------------------------------------------------

--
-- Table structure for table `cicilan_bimbel`
--

CREATE TABLE `cicilan_bimbel` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `cicilan_bimbel`
--
DELIMITER $$
CREATE TRIGGER `tr_cek_lunas_cicilan_bimbel` AFTER INSERT ON `cicilan_bimbel` FOR EACH ROW BEGIN
	declare total int(11);
    declare total_cicilan int(11);
    select jumlah into total from v_lihatpembayaranbimbel;
    select sum(jumlah) into total_cicilan from cicilan_bimbel where pembayaran_id = new.pembayaran_id;
    
    if(total = total_cicilan) THEN
    	update pembayaran_bimbel set status = 'Lunas' where pembayaran_id = new.pembayaran_id;
    end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_tagihan`
--

CREATE TABLE `jenis_tagihan` (
  `tagihan_id` int(11) NOT NULL,
  `nama_tagihan` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan_tagihan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_tagihan`
--

INSERT INTO `jenis_tagihan` (`tagihan_id`, `nama_tagihan`, `jumlah`, `keterangan_tagihan`) VALUES
(101, 'Tagihan Bimbel', 500000, 'Pembayaran Bimbel per Semester');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(25) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `no_handphone` varchar(14) NOT NULL,
  `alamat` text NOT NULL,
  `level` enum('Bendahara','Staff','Yayasan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama_depan`, `nama_belakang`, `no_handphone`, `alamat`, `level`) VALUES
(100001, 'Ananda', 'Muharriz Sinaga', '+6287898365680', 'Jl. Pala Raya No.77 Perumnas Simalingkar', 'Bendahara');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_bimbel`
--

CREATE TABLE `pembayaran_bimbel` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `NIS` varchar(16) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `jenis_kelamin` enum('Laki laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `tgl_masuk` date NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_lihatpembayaranbimbel`
-- (See below for the actual view)
--
CREATE TABLE `v_lihatpembayaranbimbel` (
`pembayaran_id` int(11)
,`nama` varchar(60)
,`jumlah` int(11)
,`status` enum('Lunas','Belum Lunas')
);

-- --------------------------------------------------------

--
-- Structure for view `v_lihatpembayaranbimbel`
--
DROP TABLE IF EXISTS `v_lihatpembayaranbimbel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lihatpembayaranbimbel`  AS  select `pembayaran_bimbel`.`pembayaran_id` AS `pembayaran_id`,`siswa`.`nama` AS `nama`,`jenis_tagihan`.`jumlah` AS `jumlah`,`pembayaran_bimbel`.`status` AS `status` from ((`pembayaran_bimbel` join `siswa`) join `jenis_tagihan` on(((`pembayaran_bimbel`.`NIS` = `siswa`.`NIS`) and (`pembayaran_bimbel`.`tagihan_id` = `jenis_tagihan`.`tagihan_id`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cicilan_bimbel`
--
ALTER TABLE `cicilan_bimbel`
  ADD KEY `constraint_cb_1` (`pegawai_id`),
  ADD KEY `constraint_cb_2` (`pembayaran_id`);

--
-- Indexes for table `jenis_tagihan`
--
ALTER TABLE `jenis_tagihan`
  ADD PRIMARY KEY (`tagihan_id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran_bimbel`
--
ALTER TABLE `pembayaran_bimbel`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `constraint_pb_1` (`NIS`),
  ADD KEY `constraint_pb_2` (`tagihan_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NIS`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_tagihan`
--
ALTER TABLE `jenis_tagihan`
  MODIFY `tagihan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100002;

--
-- AUTO_INCREMENT for table `pembayaran_bimbel`
--
ALTER TABLE `pembayaran_bimbel`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cicilan_bimbel`
--
ALTER TABLE `cicilan_bimbel`
  ADD CONSTRAINT `constraint_cb_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_cb_2` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran_bimbel` (`pembayaran_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_bimbel`
--
ALTER TABLE `pembayaran_bimbel`
  ADD CONSTRAINT `constraint_pb_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_pb_2` FOREIGN KEY (`tagihan_id`) REFERENCES `jenis_tagihan` (`tagihan_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
