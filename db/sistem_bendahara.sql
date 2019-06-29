-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2019 at 11:53 AM
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `cek_user` (`nip` VARCHAR(50), `password` VARCHAR(50)) RETURNS INT(5) begin
	declare result int(5);
    select count(pegawai_id) into result from pegawai where pegawai_id = nip and pegawai_password = password;
    return result;
end$$

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
  `pegawai_id` int(11) NOT NULL,
  `pegawai_password` varchar(50) NOT NULL,
  `nama_depan` varchar(25) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `no_handphone` varchar(14) NOT NULL,
  `alamat` text NOT NULL,
  `level` enum('Bendahara','Staff','Yayasan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`pegawai_id`, `pegawai_password`, `nama_depan`, `nama_belakang`, `no_handphone`, `alamat`, `level`) VALUES
(100001, 'root', 'Ananda', 'Muharriz Sinaga', '+6287898365680', 'Jl. Pala Raya No.77 Perumnas Simalingkar', 'Bendahara');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_bimbel`
--

CREATE TABLE `pembayaran_bimbel` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `pembayaran_bimbel`
--
DELIMITER $$
CREATE TRIGGER `tr_cek_lunas_cicilan_bimbel` AFTER INSERT ON `pembayaran_bimbel` FOR EACH ROW BEGIN
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
-- Table structure for table `pembayaran_buku`
--

CREATE TABLE `pembayaran_buku` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_pembangunan`
--

CREATE TABLE `pembayaran_pembangunan` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_pondok`
--

CREATE TABLE `pembayaran_pondok` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `potongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_spp`
--

CREATE TABLE `pembayaran_spp` (
  `pembayaran_id` int(11) NOT NULL,
  `bulan` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `pengeluaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_dipakai` date NOT NULL,
  `keterangan` varchar(100) NOT NULL
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
-- Table structure for table `uang_bimbel`
--

CREATE TABLE `uang_bimbel` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `semester` enum('Genap','Ganjil') NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uang_buku`
--

CREATE TABLE `uang_buku` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uang_infaq`
--

CREATE TABLE `uang_infaq` (
  `donatur_id` int(11) NOT NULL,
  `nama_lengkap` varchar(60) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_diterima` date NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uang_pembangunan`
--

CREATE TABLE `uang_pembangunan` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uang_pondok`
--

CREATE TABLE `uang_pondok` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `tahun` int(5) NOT NULL,
  `bulan` int(5) NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uang_spp`
--

CREATE TABLE `uang_spp` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_tagihan`
--
ALTER TABLE `jenis_tagihan`
  ADD PRIMARY KEY (`tagihan_id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`pegawai_id`);

--
-- Indexes for table `pembayaran_bimbel`
--
ALTER TABLE `pembayaran_bimbel`
  ADD KEY `constraint_cb_1` (`pegawai_id`),
  ADD KEY `constraint_cb_2` (`pembayaran_id`);

--
-- Indexes for table `pembayaran_buku`
--
ALTER TABLE `pembayaran_buku`
  ADD KEY `pembayaran_buku_constraint_1` (`pegawai_id`),
  ADD KEY `pembayaran_buku_constraint_2` (`pembayaran_id`);

--
-- Indexes for table `pembayaran_pembangunan`
--
ALTER TABLE `pembayaran_pembangunan`
  ADD KEY `pembayaran_pembangunan_1` (`pembayaran_id`),
  ADD KEY `pembayaran_pembangunan_2` (`pegawai_id`);

--
-- Indexes for table `pembayaran_pondok`
--
ALTER TABLE `pembayaran_pondok`
  ADD KEY `pembayaran_pondok_constraint_1` (`pegawai_id`),
  ADD KEY `pembayaran_pondok_constraint_2` (`pembayaran_id`);

--
-- Indexes for table `pembayaran_spp`
--
ALTER TABLE `pembayaran_spp`
  ADD KEY `pembayaran_spp_constraint_1` (`pembayaran_id`),
  ADD KEY `pembayaran_spp_constraint_2` (`pegawai_id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`pengeluaran_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NIS`);

--
-- Indexes for table `uang_bimbel`
--
ALTER TABLE `uang_bimbel`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `constraint_pb_1` (`NIS`),
  ADD KEY `constraint_pb_2` (`tagihan_id`);

--
-- Indexes for table `uang_buku`
--
ALTER TABLE `uang_buku`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `uang_buku_constraint_1` (`NIS`);

--
-- Indexes for table `uang_infaq`
--
ALTER TABLE `uang_infaq`
  ADD PRIMARY KEY (`donatur_id`),
  ADD KEY `uang_infaq_constraint_1` (`pegawai_id`);

--
-- Indexes for table `uang_pembangunan`
--
ALTER TABLE `uang_pembangunan`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `uang_pembangunan_constraint_1` (`NIS`),
  ADD KEY `uang_pembangunan_constraint_2` (`tagihan_id`);

--
-- Indexes for table `uang_pondok`
--
ALTER TABLE `uang_pondok`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `uang_pondok_constraint_1` (`NIS`),
  ADD KEY `uang_pondok_constraint_2` (`tagihan_id`);

--
-- Indexes for table `uang_spp`
--
ALTER TABLE `uang_spp`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `uang_spp_constraint_1` (`NIS`),
  ADD KEY `uang_spp_constraint_2` (`tagihan_id`);

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
  MODIFY `pegawai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100002;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `pengeluaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_bimbel`
--
ALTER TABLE `uang_bimbel`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_buku`
--
ALTER TABLE `uang_buku`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_infaq`
--
ALTER TABLE `uang_infaq`
  MODIFY `donatur_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_pembangunan`
--
ALTER TABLE `uang_pembangunan`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_pondok`
--
ALTER TABLE `uang_pondok`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_spp`
--
ALTER TABLE `uang_spp`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran_bimbel`
--
ALTER TABLE `pembayaran_bimbel`
  ADD CONSTRAINT `constraint_cb_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_cb_2` FOREIGN KEY (`pembayaran_id`) REFERENCES `uang_bimbel` (`pembayaran_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_buku`
--
ALTER TABLE `pembayaran_buku`
  ADD CONSTRAINT `pembayaran_buku_constraint_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_buku_constraint_2` FOREIGN KEY (`pembayaran_id`) REFERENCES `uang_buku` (`pembayaran_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_pembangunan`
--
ALTER TABLE `pembayaran_pembangunan`
  ADD CONSTRAINT `pembayaran_pembangunan_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `uang_pembangunan` (`pembayaran_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_pembangunan_2` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_pondok`
--
ALTER TABLE `pembayaran_pondok`
  ADD CONSTRAINT `pembayaran_pondok_constraint_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_pondok_constraint_2` FOREIGN KEY (`pembayaran_id`) REFERENCES `uang_pondok` (`pembayaran_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran_spp`
--
ALTER TABLE `pembayaran_spp`
  ADD CONSTRAINT `pembayaran_spp_constraint_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `uang_spp` (`pembayaran_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_spp_constraint_2` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_bimbel`
--
ALTER TABLE `uang_bimbel`
  ADD CONSTRAINT `constraint_pb_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_pb_2` FOREIGN KEY (`tagihan_id`) REFERENCES `jenis_tagihan` (`tagihan_id`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_buku`
--
ALTER TABLE `uang_buku`
  ADD CONSTRAINT `uang_buku_constraint_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_infaq`
--
ALTER TABLE `uang_infaq`
  ADD CONSTRAINT `uang_infaq_constraint_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`pegawai_id`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_pembangunan`
--
ALTER TABLE `uang_pembangunan`
  ADD CONSTRAINT `uang_pembangunan_constraint_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `uang_pembangunan_constraint_2` FOREIGN KEY (`tagihan_id`) REFERENCES `jenis_tagihan` (`tagihan_id`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_pondok`
--
ALTER TABLE `uang_pondok`
  ADD CONSTRAINT `uang_pondok_constraint_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `uang_pondok_constraint_2` FOREIGN KEY (`tagihan_id`) REFERENCES `jenis_tagihan` (`tagihan_id`) ON UPDATE CASCADE;

--
-- Constraints for table `uang_spp`
--
ALTER TABLE `uang_spp`
  ADD CONSTRAINT `uang_spp_constraint_1` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON UPDATE CASCADE,
  ADD CONSTRAINT `uang_spp_constraint_2` FOREIGN KEY (`tagihan_id`) REFERENCES `jenis_tagihan` (`tagihan_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
