-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2019 at 04:12 PM
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
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_uang_bimbel` (IN `id` INT(11))  NO SQL
begin
	delete from pembayaran_bimbel where pembayaran_id = id;
	delete from uang_bimbel where pembayaran_id = id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_uang_pembangunan` (IN `id` INT(11))  NO SQL
begin
	delete from pembayaran_pembangunan where pembayaran_id = id;
	delete from uang_pembangunan where pembayaran_id = id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapus_uang_pondok` (IN `id` INT(11))  begin
	delete from pembayaran_pondok where pembayaran_id = id;
	delete from uang_pondok where pembayaran_id = id;
end$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `cek_user` (`nip` VARCHAR(50), `password` VARCHAR(50)) RETURNS INT(5) begin
	declare result int(5);
    select count(pegawai_id) into result from pegawai where pegawai_id LIKE nip and pegawai_password = password;
    return result;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_data_pembayaran_bimbel` () RETURNS INT(11) NO SQL
BEGIN
	declare jumlah_data int(11);
    select count(*) into jumlah_data from uang_bimbel;
    return jumlah_data;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_data_pembayaran_pembangunan` () RETURNS INT(11) NO SQL
BEGIN
	declare jumlah_data int(11);
    select count(*) into jumlah_data from uang_pembangunan;
    return jumlah_data;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_data_pembayaran_pondok` () RETURNS INT(11) BEGIN
	declare jumlah_data int(11);
    select count(*) into jumlah_data from v_lihatpembayaranpondok;
    return jumlah_data;
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
(109, 'Tagihan Bimbel', 775000, 'Pembayaran Bimbel per Semester'),
(310, 'Tagihan Pembangunan', 6250000, 'Pembayaran Pembangunan per Tahun'),
(311, 'Tagihan SPP', 500000, 'Tagihan SPP per bulan'),
(312, 'Uang Pondok', 300000, 'Uang Pondok per Bulan');

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
(100001, 'root', 'Ananda', 'Muharriz Sinaga', '+6287898365680', 'Jl. Pala Raya No.77 Perumnas Simalingkar', 'Bendahara'),
(100002, 'root', 'Nadia', 'Nasywa', '+6285270069700', 'Jl.Marelan VII Gg.Amal I No 20', 'Staff'),
(100003, 'root', 'Rafif', 'Rasyidi', '+6282172694268', 'Jl.Gunung Tua no 45', 'Staff'),
(100004, 'root', 'Dinul ', 'Iman', '+6283167298340', 'Jl.Pancing no 37', 'Yayasan'),
(100005, 'root', 'Deby', 'Salsabila', '+6287825638729', 'Jl.Dumai no 81', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_bimbel`
--

CREATE TABLE `pembayaran_bimbel` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `potongan` int(100) NOT NULL
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
  `pegawai_id` int(11) NOT NULL,
  `potongan` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_pembangunan`
--

CREATE TABLE `pembayaran_pembangunan` (
  `pembayaran_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `potongan` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran_pembangunan`
--

INSERT INTO `pembayaran_pembangunan` (`pembayaran_id`, `jumlah`, `tgl_pembayaran`, `pegawai_id`, `potongan`) VALUES
(2, 0, '0000-00-00', 100001, 0);

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

--
-- Dumping data for table `pembayaran_pondok`
--

INSERT INTO `pembayaran_pondok` (`pembayaran_id`, `jumlah`, `tgl_pembayaran`, `pegawai_id`, `potongan`) VALUES
(1127, 250000, '2019-07-06', 100001, 50000),
(1127, 0, '2019-07-06', 100001, 0),
(1107, 300000, '2019-07-06', 100001, 0),
(1107, 250000, '2019-07-06', 100001, 50000);

--
-- Triggers `pembayaran_pondok`
--
DELIMITER $$
CREATE TRIGGER `cek_lunas` BEFORE INSERT ON `pembayaran_pondok` FOR EACH ROW begin 
	declare total_yg_sudah_dibayar int(11);
    declare total_potongan int(11);
    declare total int(11);
    declare tagihan int(11);
    select jumlah into tagihan from v_lihatpembayaranpondok where pembayaran_id = new.pembayaran_id;
    select sum(jumlah) into total_yg_sudah_dibayar from pembayaran_pondok where pembayaran_id = new.pembayaran_id;
    select sum(potongan) into total_potongan from pembayaran_pondok where pembayaran_id = new.pembayaran_id;
    set total  = total_yg_sudah_dibayar + total_potongan;
    set total = total + new.jumlah;
    set total = total + new.potongan;
    
    if(total >= tagihan) THEN
      update uang_pondok set status='lunas' where pembayaran_id = new.pembayaran_id;
    end IF;
end
$$
DELIMITER ;

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

--
-- Dumping data for table `pembayaran_spp`
--

INSERT INTO `pembayaran_spp` (`pembayaran_id`, `bulan`, `jumlah`, `pegawai_id`, `status`) VALUES
(1101, '6', 500000, 100004, 'Lunas'),
(1101, '7', 500000, 100004, 'Lunas');

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

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`pengeluaran_id`, `jumlah`, `tgl_dipakai`, `keterangan`) VALUES
(1, 350000, '2016-08-17', 'Pembelian Bangku');

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

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`NIS`, `nama`, `jenis_kelamin`, `alamat`, `tgl_masuk`, `status`) VALUES
('1214001', 'amirah husni', 'Perempuan', 'jl.sinar no 78', '2014-06-01', 'Aktif'),
('1214002', 'andieni chayakamil', 'Perempuan', 'jl.hiu no 2', '2014-06-01', 'Aktif'),
('1214003', 'azra nazifah', 'Perempuan', 'jl.dutik no 69', '2014-06-01', 'Aktif'),
('1214004', 'badzlina atika salsabila', 'Perempuan', 'jl.kupol no 91', '2014-06-01', 'Aktif'),
('1214005', 'fadilah nur', 'Perempuan', 'jl.mutiy no 7', '2014-06-01', 'Aktif'),
('1214006', 'farida azmi majdiyah', 'Perempuan', 'jl.dariu no 45', '2014-06-01', 'Aktif'),
('1214007', 'fatima azzahra', 'Perempuan', 'jl.timah no 14', '2014-06-01', 'Aktif'),
('1214008', 'habibah', 'Perempuan', 'jl.bahik no 8', '2014-06-01', 'Aktif'),
('1214009', 'havila edla anindya avis', 'Perempuan', 'jl.ikan no 17', '2014-06-01', 'Aktif'),
('1214010', 'istiqomah ridhati', 'Perempuan', 'jl.kakus no 3', '2014-06-01', 'Aktif'),
('1214011', 'jihan nazwa', 'Perempuan', 'jl.kutip no 8', '2014-06-01', 'Aktif'),
('1214012', 'lutfiah syahbi pohan', 'Perempuan', 'jl.alon no 56', '2014-06-01', 'Aktif'),
('1214013', 'muthmainnah', 'Perempuan', 'jl.dima no 48', '2014-06-01', 'Aktif'),
('1214014', 'naila husnaa', 'Perempuan', 'jl.teh no 9', '2014-06-01', 'Aktif'),
('1214015', 'najwa zhalila harmoyo', 'Perempuan', 'jl.paus no 31', '2014-06-01', 'Aktif'),
('1214016', 'nazwa nadya', 'Perempuan', 'jl.guhi no 75', '2014-06-01', 'Aktif'),
('1214017', 'nawha agla azahra', 'Perempuan', 'jl.hawa no 1', '2014-06-01', 'Aktif'),
('1214018', 'nisa adelia', 'Perempuan', 'jl.kali no 6', '2014-06-01', 'Aktif'),
('1214019', 'nurul matin', 'Perempuan', 'jl.kaus no 82', '2014-06-01', 'Aktif'),
('1214020', 'raihansyah sabrina', 'Perempuan', 'jl.ratu no 9', '2014-06-01', 'Aktif'),
('1214021', 'risya nurul sabrina siregar', 'Perempuan', 'jl.raja no 4', '2014-06-01', 'Aktif'),
('1214022', 'sarah irawan', 'Perempuan', 'jl.rahima no 67', '2014-06-01', 'Aktif'),
('1214023', 'siti asiyah zahra', 'Perempuan', 'jl.siti no 24', '2014-06-01', 'Aktif'),
('1214024', 'sofia massayu pasha dinata', 'Perempuan', 'jl.winayo no 6', '2014-06-01', 'Aktif'),
('1214025', 'syifa bilqis soraya', 'Perempuan', 'jl.balis no 69', '2014-06-01', 'Aktif'),
('1214026', 'yola a.d putri simorangkir', 'Perempuan', 'jl.cangkir no 68', '2014-06-01', 'Aktif'),
('1214027', 'yusnazla ulaya', 'Perempuan', 'jl.jus no 72', '2014-06-01', 'Aktif'),
('1214028', 'maulidia aulia', 'Perempuan', 'jl.oleh no 39', '2014-06-01', 'Aktif'),
('1214029', 'adzkania fathimah azzahra', 'Perempuan', 'jl.kulip no 16', '2014-06-01', 'Aktif'),
('1214030', 'aisya hayatun nazmi', 'Perempuan', 'jl.kopot no 9', '2014-06-01', 'Aktif'),
('1214031', 'aisyah zahra', 'Perempuan', 'jl.defut no 12', '2014-06-01', 'Aktif'),
('1214032', 'alya nadra shifa', 'Perempuan', 'jl.darah no 92', '2014-06-01', 'Aktif'),
('1214033', 'alya qurrata aini sitorus', 'Perempuan', 'jl.toru no 1', '2014-06-01', 'Aktif'),
('1214034', 'annisa nurul khasanah', 'Perempuan', 'jl.yulip no 8', '2014-06-01', 'Aktif'),
('1214035', 'aulia rizky syahfitri', 'Perempuan', 'jl.gejaha no 13', '2014-06-01', 'Aktif'),
('1214036', 'balkis olivia siregar', 'Perempuan', 'jl.sedu no 4', '2014-06-01', 'Aktif'),
('1214037', 'fadhila rahmi nasution ', 'Perempuan', 'jl.curu no 26', '2014-06-01', 'Aktif'),
('1214038', 'fadiyah maysaroh', 'Perempuan', 'jl.kutu no 17', '2014-06-01', 'Aktif'),
('1214039', 'fadhira hafiza', 'Perempuan', 'jl.rawer no 1', '2014-06-01', 'Aktif'),
('1214040', 'fakhira azzahra sarefi', 'Perempuan', 'jl.safi no 4', '2014-06-01', 'Aktif'),
('1214041', 'fatiha fayza br.gurning', 'Perempuan', 'jl.goli no 4', '2014-06-01', 'Aktif'),
('1214042', 'fatimah', 'Perempuan', 'jl.burot no 57', '2014-06-01', 'Aktif'),
('1214043', 'iftahul hazimah', 'Perempuan', 'jl.karo no 7', '2014-06-01', 'Aktif'),
('1214044', 'nadra shahira agytha', 'Perempuan', 'jl.darut no 68', '2014-06-01', 'Aktif'),
('1214045', 'naila kaltsum', 'Perempuan', 'jl.sumi no 18', '2014-06-01', 'Aktif'),
('1214046', 'nailah mumtazah', 'Perempuan', 'jl.hariu no 71', '2014-06-01', 'Aktif'),
('1214047', 'nailah mumtazah', 'Perempuan', 'jl.werup no 9', '2014-06-01', 'Aktif'),
('1214048', 'naila zahida', 'Laki laki', 'jl.zihi no 5', '2014-06-01', 'Aktif'),
('1214049', 'nazwa aulya muchtar lbs ', 'Perempuan', 'jl.satwa no 34', '2014-06-01', 'Aktif'),
('1214050', 'raisa aini hasibuan', 'Perempuan', 'jl.buani no 31', '2014-06-01', 'Aktif'),
('1214051', 'rumaisah', 'Perempuan', 'jl.gutui no 61', '2014-06-01', 'Aktif'),
('1214052', 'sausan adila', 'Perempuan', 'jl.selat no 84', '2014-06-01', 'Aktif'),
('1214053', 'shanaz kanita ilmi', 'Perempuan', 'jl.ilmu no 23', '2014-06-01', 'Aktif'),
('1214054', 'shifa munra', 'Perempuan', 'jl.muda no 35', '2014-06-01', 'Aktif'),
('1214055', 'shofiyah az zahro', 'Perempuan', 'jl.manam no 6', '2014-06-01', 'Aktif'),
('1214056', 'syifa kania ananda', 'Perempuan', 'jl.tigah no 5', '2014-06-01', 'Aktif'),
('1302001', 'annisa fitria', 'Perempuan', 'jl.kayu no 1', '2015-06-01', 'Aktif'),
('1314002', 'aprita irawan', 'Perempuan', 'jl.pojiko no 67', '2015-06-01', 'Aktif'),
('1314003', 'atha nayva haniv purba', 'Perempuan', 'jl.kupi no 78', '2015-06-01', 'Aktif'),
('1314004', 'cut  aisa azzahra', 'Perempuan', 'jl.buyu no 23', '2015-06-01', 'Aktif'),
('1314005', 'dwe andayani', 'Perempuan', 'jl.huyuto no 9', '2015-06-01', 'Aktif'),
('1314006', 'dwe delfina adelya', 'Perempuan', 'jl.polop no 90', '2015-06-01', 'Aktif'),
('1314007', 'nadia syafa athifa', 'Perempuan', 'jl.kujiko no 89', '2015-06-01', 'Aktif'),
('1314008', 'khalima tussaqdiatah', 'Perempuan', 'jl.buyuji no 7', '2015-06-01', 'Aktif'),
('1314009', 'naura al yani', 'Perempuan', 'jl.referi no 82015-06-01', '2015-06-01', 'Aktif'),
('1314010', 'nazifa salsabila', 'Perempuan', 'jl.ipolik no 24', '2015-06-01', 'Aktif'),
('1314011', 'naziha luthfiyah siregar', 'Perempuan', 'jl.guilo no 70', '2015-06-01', 'Aktif'),
('1314012', 'nazwa safira ray', 'Perempuan', 'jl.vuhijo no 65', '2015-06-01', 'Aktif'),
('1314013', 'nella angriani', 'Perempuan', 'jl.kenanga no 34', '2015-06-01', 'Aktif'),
('1314014', 'noor fahilah', 'Perempuan', 'jl.kilo no 69', '2015-06-01', 'Aktif'),
('1314015', 'noor putri salz', 'Perempuan', 'jl.federasi no 39', '2015-06-01', 'Aktif'),
('1314016', 'nur hidayah rahmadani lubis', 'Perempuan', 'jl.hengki no 67', '2015-06-01', 'Aktif'),
('1314017', 'raina seiba', 'Perempuan', 'jl.olopi no 98', '2015-06-01', 'Aktif'),
('1314018', 'riska m', 'Perempuan', 'jl.galo no 78', '2015-06-01', 'Aktif'),
('1314019', 'rona adha hadayah brt', 'Perempuan', 'jl.kolopil no 12', '2015-06-01', 'Aktif'),
('1314020', 'salabilah khodijah humairoh', 'Perempuan', 'jl.roh no 45', '2015-06-01', 'Aktif'),
('1314021', 'salwa salsabila', 'Perempuan', 'jl.satwa no 47', '2015-06-01', 'Aktif'),
('1314022', 'sykirah fatnanah', 'Perempuan', 'jl.kuloh no 13', '2015-06-01', 'Aktif'),
('1314023', 'syarafina', 'Perempuan', 'jl.surga no 95', '2015-06-01', 'Aktif'),
('1314024', 'yusriah naziha isma', 'Perempuan', 'jl.butoy no 36', '2015-06-01', 'Aktif'),
('1314025', 'ade amelia', 'Perempuan', 'jl.fades no 7', '2015-06-01', 'Aktif'),
('1314026', 'afifah azzahra', 'Perempuan', 'jl.lopil no 73', '2015-06-01', 'Aktif'),
('1314027', 'aghina humairah', 'Perempuan', 'jl.guti no 24', '2015-06-01', 'Aktif'),
('1314028', 'aisyah nurfadillah lubis', 'Perempuan', 'jl.nuri no 47', '2015-06-01', 'Aktif'),
('1314029', 'ananda dini arimby', 'Perempuan', 'jl.rohik no 89', '2015-06-01', 'Aktif'),
('1314030', 'athira salsabila', 'Perempuan', 'jl.laki no 85', '2015-06-01', 'Aktif'),
('1314031', 'audrey azhura', 'Perempuan', 'jl.kutopol no 1', '2015-06-01', 'Aktif'),
('1314032', 'faizah afifah anniasiyah', 'Perempuan', 'jl.putri no 4', '2015-06-01', 'Aktif'),
('1314033', 'fathimah', 'Perempuan', 'jl.durol no 76', '2015-06-01', 'Aktif'),
('1314034', 'hanifah nadiyah', 'Perempuan', 'jl.fuiko no 34', '2015-06-01', 'Aktif'),
('1314035', 'laras arindi', 'Perempuan', 'jl.quri no 37', '2015-06-01', 'Aktif'),
('1314036', 'mutia alfani siregar', 'Perempuan', 'jl.refai no 3', '2015-06-01', 'Aktif'),
('1314037', 'nazwa zahra tun nissa', 'Perempuan', 'jl.guyopo no 45', '2015-06-01', 'Aktif'),
('1314038', 'nur misbah delwina r.p', 'Perempuan', 'jl.sedera no 4', '2015-06-01', 'Aktif'),
('1314039', 'rahadatul aisyi harahap', 'Perempuan', 'jl.datul no 4', '2015-06-01', 'Aktif'),
('1314040', 'raihana', 'Perempuan', 'jl.reret no 7', '2015-06-01', 'Aktif'),
('1314041', 'rantya annisa', 'Perempuan', 'jl.turul no 8', '2015-06-01', 'Aktif'),
('1314042', 'rayhani anada saragih', 'Perempuan', 'jl.vutiko no 6', '2015-06-01', 'Aktif'),
('1314043', 'risa kurnilia', 'Perempuan', 'jl.reti no 6', '2015-06-01', 'Aktif'),
('1314044', 'salsabillah muthdiyah', 'Perempuan', 'jl.mutifa no 5', '2015-06-01', 'Aktif'),
('1314045', 'sultan tsabitah', 'Perempuan', 'jl.detui no 39', '2015-06-01', 'Aktif'),
('1314046', 'syifa annisa', 'Perempuan', 'jl.tuju no 8', '2015-06-01', 'Aktif'),
('1314047', 'winda saida', 'Perempuan', 'jl.hutig no 2', '2015-06-01', 'Aktif'),
('1314048', 'yasmina karma', 'Perempuan', 'jl.kurma no 15', '2015-06-01', 'Aktif'),
('1314049', 'zia syamsia balqis', 'Perempuan', 'jl.mutikas no 6', '2015-06-01', 'Aktif'),
('1314050', 'khalimatussadiah', 'Perempuan', 'jl.atus no 48', '2015-06-01', 'Aktif'),
('1402001', 'ade ermanisa', 'Perempuan', 'jl.kuyi no 76', '2016-06-01', 'Aktif'),
('1402002', 'adinda nur azizah', 'Perempuan', 'jl.tuyio no 6', '2016-06-01', 'Aktif'),
('1402003', 'adzkia khairunnisa', 'Perempuan', 'jl.tujiko no 45', '2016-06-01', 'Aktif'),
('1402004', 'ainus shafiyah', 'Perempuan', 'jl.poljio no 9', '2016-06-01', 'Aktif'),
('1402005', 'aisyah husni', 'Perempuan', 'jl.ader no 34', '2016-06-01', 'Aktif'),
('1402006', 'alifa cahya ningrum', 'Perempuan', 'jl.kuipo no 89', '2016-06-01', 'Aktif'),
('1402007', 'aisya salsabila', 'Perempuan', 'jl.buhog no 4', '2016-06-01', 'Aktif'),
('1402008', 'aini sabila al-mustaqimah', 'Perempuan', 'jl.feret no 7', '2016-06-01', 'Aktif'),
('1402009', 'dea arranoya', 'Perempuan', 'jl.liko no 1', '2016-06-01', 'Aktif'),
('1402010', 'defita azzara faiz', 'Perempuan', 'jl.fuhki no 7', '2016-06-01', 'Aktif'),
('1402011', 'era adawiyah siregar', 'Perempuan', 'jl.wereti no 56', '2016-06-01', 'Aktif'),
('1402012', 'hanifah fitri', 'Perempuan', 'jl.yutir no 90', '2016-06-01', 'Aktif'),
('1402013', 'hunaisah lubis', 'Perempuan', 'jl.giop no 78', '2016-06-01', 'Aktif'),
('1402014', 'jihan luthfiyyah nasution', 'Perempuan', 'jl.dero no 4', '2016-06-01', 'Aktif'),
('1402015', 'kaila wanda', 'Perempuan', 'jl.feredo no 65', '2016-06-01', 'Aktif'),
('1402016', 'kinzha syakriani', 'Perempuan', 'jl.tuyul no 23', '2016-06-01', 'Aktif'),
('1402017', 'liyana adriana', 'Perempuan', 'jl.yutio no 3', '2016-06-01', 'Aktif'),
('1402018', 'nazirah alzany', 'Perempuan', 'jl.hujop no 89', '2016-06-01', 'Aktif'),
('1402019', 'nurul adinda', 'Perempuan', 'jl.sered no 20', '2016-06-01', 'Aktif'),
('1402020', 'nurul balqis', 'Perempuan', 'jl.tupoj no 78', '2016-06-01', 'Aktif'),
('1402021', 'rarika khalidah shafiqoh', 'Perempuan', 'jl.qerui no 56', '2016-06-01', 'Aktif'),
('1402022', 'restu amalia majid', 'Perempuan', 'jl.mesjid no 35', '2016-06-01', 'Aktif'),
('1402023', 'shofi margarina br.simbolon', 'Perempuan', 'jl.mukip no 45', '2016-06-01', 'Aktif'),
('1402024', 'shofiyyah oriell', 'Perempuan', 'jl.jikulo no 23', '2016-06-01', 'Aktif'),
('1402025', 'suci ramadani', 'Perempuan', 'jl.sederi no 75', '2016-06-01', 'Aktif'),
('1402026', 'vania dwi aurellia', 'Perempuan', 'jl.hujikol no 96', '2016-06-01', 'Aktif'),
('1402027', 'vivi oriza syatifa', 'Perempuan', 'jl.hutuy no 86', '2016-06-01', 'Aktif'),
('1402028', 'yasmin salsabila', 'Perempuan', 'jl.salsa no 48', '2016-06-01', 'Aktif'),
('1402029', 'zahrani nabila', 'Perempuan', 'jl.nuyipo no 35', '2016-06-01', 'Aktif'),
('1514001', 'adinda khairunnisa', 'Perempuan', 'jl.guyi no 1', '2017-06-01', 'Aktif'),
('1514002', 'alya sharbina nasution', 'Perempuan', 'jl.nuh no 7', '2017-06-01', 'Aktif'),
('1514003', 'alyalova putri subroto', 'Perempuan', 'jl.muji no 7', '2017-06-01', 'Aktif'),
('1514004', 'amelya putri', 'Perempuan', 'jl.cuy no 5', '2017-06-01', 'Aktif'),
('1514005', 'amirah thoriq hamdah', 'Perempuan', 'jl.vuhi no 9', '2017-06-01', 'Aktif'),
('1514006', 'nnisa novita putri siregar', 'Perempuan', 'jl.vugo no 5', '2017-06-01', 'Aktif'),
('1514007', 'aprianan ualan dari', 'Perempuan', 'jl.ritu no 6', '2017-06-01', 'Aktif'),
('1514008', 'ayu diva adrelia', 'Perempuan', 'jl.tyui no 3', '2017-06-01', 'Aktif'),
('1514009', 'bintang annata', 'Perempuan', 'jl.koi no 78', '2017-06-01', 'Aktif'),
('1514010', 'cut nurmasyita', 'Perempuan', 'jl.buto no 89', '2017-06-01', 'Aktif'),
('1514011', 'dea annisa seswoyo', 'Perempuan', 'jl.polu no 5', '2017-06-01', 'Aktif'),
('1514012', 'dita vistasya haliza c.a.f', 'Perempuan', 'jl.lopi no 34', '2017-06-01', 'Aktif'),
('1514013', 'durra mudrika matondang', 'Perempuan', 'jl.vopo no 5', '2017-06-01', 'Aktif'),
('1514014', 'hartati olivia', 'Perempuan', 'jl.buhi no 9', '2017-06-01', 'Aktif'),
('1514015', 'lusi sinta sepriani', 'Perempuan', 'jl.creu no 76', '2017-06-01', 'Aktif'),
('1514016', 'mauiliani', 'Perempuan', 'jl.fipo no 10', '2017-06-01', 'Aktif'),
('1514017', 'nabila zata arifah', 'Perempuan', 'jl.gopil no 45', '2017-06-01', 'Aktif'),
('1514018', 'nelli aini rianti', 'Perempuan', 'jl.zuti no 6', '2017-06-01', 'Aktif'),
('1514019', 'nia wahyuni', 'Perempuan', 'jl.duri no 90', '2017-06-01', 'Aktif'),
('1514020', 'nurul rafiqah', 'Perempuan', 'jl.were no 7', '2017-06-01', 'Aktif'),
('1514021', 'salma maulidiah', 'Perempuan', 'jl.hupo no 65', '2017-06-01', 'Aktif'),
('1514022', 'salsabila', 'Perempuan', 'jl.mujik no 8', '2017-06-01', 'Aktif'),
('1514023', 'sefti anjeli lubis', 'Perempuan', 'jl.fare no 5', '2017-06-01', 'Aktif'),
('1514024', 'shafira putri zharifah', 'Perempuan', 'jl.pokilo no 2', '2017-06-01', 'Aktif'),
('1514025', 'shofi fahira azzarah', 'Perempuan', 'jl.huyi no 87', '2017-06-01', 'Aktif'),
('1514026', 'shofia hasanah', 'Perempuan', 'jl.ruyui no 67', '2017-06-01', 'Aktif'),
('1514027', 'shufiatul manira', 'Perempuan', 'jl.buty no 34', '2017-06-01', 'Aktif'),
('1514028', 'siti nazla raihana', 'Perempuan', 'jl.cuty no 34', '2017-06-01', 'Aktif'),
('1514029', 'ulfa rahma', 'Perempuan', 'jl.zery no 2', '2017-06-01', 'Aktif'),
('1514030', 'zainab', 'Perempuan', 'jl.kolop no 2', '2017-06-01', 'Aktif'),
('1514031', 'sachrani syakila', 'Perempuan', 'jl.nuto no 6', '2017-06-01', 'Aktif'),
('1514032', 'fanni dariani syah', 'Perempuan', 'jl.yuhij no 7', '2017-06-01', 'Aktif'),
('1514033', 'jihan fatma dewi', 'Perempuan', 'jl.guhop no 8', '2017-06-01', 'Aktif'),
('1614001', 'aisyah basuki', 'Perempuan', 'jl.buy no 2', '2018-06-01', 'Aktif'),
('1614002', 'albatros badrulina a.s', 'Perempuan', 'jl.vuti no 1', '2018-06-01', 'Aktif'),
('1614003', 'annisa andriani', 'Perempuan', 'jl.poyu no 4', '2018-06-01', 'Aktif'),
('1614004', 'cilvia yaohana', 'Perempuan', 'jl.jui no 3', '2018-06-01', 'Aktif'),
('1614005', 'delvi nurhaliza', 'Perempuan', 'jl.ntu no 1', '2018-06-01', 'Aktif'),
('1614006', 'dian atika sari', 'Perempuan', 'jl.ketuy no 5', '2018-06-01', 'Aktif'),
('1614007', 'ester rati boru majorang', 'Perempuan', 'jl.nyui no 6', '2018-06-01', 'Aktif'),
('1614008', 'febby sarach dita', 'Perempuan', 'jl.poki no 7', '2018-06-01', 'Aktif'),
('1614009', 'herli indah sari', 'Perempuan', 'jl.cuty no 9', '2018-06-01', 'Aktif'),
('1614010', 'nadya salsabilla purba', 'Perempuan', 'jl.buto no 10', '2018-06-01', 'Aktif'),
('1614011', 'nikmah hafizah lubis', 'Perempuan', 'jl.yuti no 1', '2018-06-01', 'Aktif'),
('1614012', 'nur zakiyah', 'Perempuan', 'jl.nuri no 76', '2018-06-01', 'Aktif'),
('1614013', 'putri intan setia wati', 'Perempuan', 'jl.hago no 65', '2018-06-01', 'Aktif'),
('1614014', 'putri nurul hidayah', 'Perempuan', 'jl.bojo no 65', '2018-06-01', 'Aktif'),
('1614015', 'rizky luthfina s', 'Perempuan', 'jl.kere no 96', '2018-06-01', 'Aktif'),
('1614016', 'siva ramadhani br pinem', 'Perempuan', 'jl.poju no 6', '2018-06-01', 'Aktif'),
('1614017', 'witri wardani', 'Perempuan', 'jl.nugu no 12', '2018-06-01', 'Aktif'),
('1614018', 'wulandari', 'Perempuan', 'jl.mopi no 34', '2018-06-01', 'Aktif'),
('1614019', 'zan clara br barus', 'Perempuan', 'jl.kopi no 5', '2018-06-01', 'Aktif'),
('1714001', 'ADZKANIA FATHIMAH AZZAHRA', 'Perempuan', 'jl.paku no 7', '2019-06-01', 'Aktif'),
('1714002', 'AISYA HAYATUN NAZMI', 'Perempuan', 'jl.gelas no 8', '2019-06-01', 'Aktif'),
('1714003', 'alma sabila', 'Perempuan', 'jl.marelan no 5', '2019-06-01', 'Aktif'),
('1714004', 'alya safira', 'Perempuan', 'jl.taru no 7', '2019-06-01', 'Aktif'),
('1714005', 'annisa humairah', 'Perempuan', 'jl.ruti no 8', '2019-06-01', 'Aktif'),
('1714006', 'aura salsabila nisa', 'Perempuan', 'jl.tuti no 9', '2019-06-01', 'Aktif'),
('1714007', 'fadhillah hasanah', 'Laki laki', 'jl.tere no 24', '2019-06-01', 'Aktif'),
('1714008', 'halimah zulfa kamila', 'Perempuan', 'jl.rere no 5', '2019-06-01', 'Aktif'),
('1714009', 'isna aprillia tambunan', 'Perempuan', 'jl.rati no 1', '2019-06-01', 'Aktif'),
('1714010', 'mellynia puri jambak', 'Perempuan', 'jl.duti no 2', '2019-06-01', 'Aktif'),
('1714011', 'monica  miranda silalahi', 'Perempuan', 'jl.deyi no 3', '2019-06-01', 'Aktif'),
('1714012', 'nargis ummu farwa', 'Perempuan', 'jl.wuti no 4', '2019-06-01', 'Aktif'),
('1714013', 'nurul fauziah', 'Perempuan', 'jl.witu no 9', '2019-06-01', 'Aktif'),
('1714014', 'RR.nabila pratiwi', 'Perempuan', 'jl.dii no 6', '2019-06-01', 'Aktif'),
('1714015', 'shafa aniyah adinda', 'Perempuan', 'jl.bitu no 2', '2019-06-01', 'Aktif'),
('1714016', 'siti nur rahma rambe', 'Perempuan', 'jl.bui no 9', '2019-06-01', 'Aktif'),
('1714017', 'syaza el-milah', 'Perempuan', 'jl.gui no 2', '2019-06-01', 'Aktif'),
('1714018', 'widya putri hidayah', 'Perempuan', 'jl.mui no 7', '2019-06-01', 'Aktif'),
('1714019', 'yusro tika affiyah', 'Perempuan', 'jl.hui no 8', '2019-06-01', 'Aktif'),
('1714020', 'annisa putri kusrini', 'Perempuan', 'jl.vui no 9', '2019-06-01', 'Aktif'),
('1714021', 'yusnia rani', 'Perempuan', 'jl.bue no 6', '2019-06-01', 'Aktif'),
('1714022', 'rosmita ragil', 'Perempuan', 'jl.kio no 4', '2019-06-01', 'Aktif'),
('1714023', 'monica ginting', 'Perempuan', 'jl.nuy no 3', '2019-06-01', 'Aktif'),
('1714024', 'fatimah zahra', 'Perempuan', 'jl.tui no 2', '2019-06-01', 'Aktif'),
('1714025', 'annisa humairah', 'Perempuan', 'jl.guy no 4', '2019-06-01', 'Aktif');

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

--
-- Dumping data for table `uang_bimbel`
--

INSERT INTO `uang_bimbel` (`pembayaran_id`, `NIS`, `tagihan_id`, `tahun_ajaran`, `semester`, `status`) VALUES
(2, '1214002', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(3, '1214003', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(4, '1214004', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(5, '1214005', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(6, '1214006', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(7, '1214007', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(8, '1214008', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(9, '1214009', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(10, '1214010', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(11, '1214011', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(12, '1214012', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(13, '1214013', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(14, '1214014', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(15, '1214015', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(16, '1214016', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(17, '1214017', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(18, '1214018', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(19, '1214019', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(20, '1214020', 109, '2014/2015', 'Ganjil', 'Belum Lunas'),
(21, '1214021', 109, '2014/2015', 'Ganjil', 'Belum Lunas');

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

--
-- Dumping data for table `uang_buku`
--

INSERT INTO `uang_buku` (`pembayaran_id`, `NIS`, `jumlah`, `tahun_ajaran`, `semester`, `status`) VALUES
(1, '1214001', 720000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(2, '1214002', 350000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(3, '1214003', 300000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(4, '1214004', 100000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(5, '1214005', 300000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(6, '1214006', 600000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(7, '1214007', 100000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(8, '1214008', 460000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(9, '1214009', 440000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(10, '1214010', 350000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(11, '1214011', 500000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(12, '1214012', 660000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(13, '1214013', 370000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(14, '1214014', 720000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(15, '1214015', 440000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(16, '1214016', 660000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(17, '1214017', 470000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(18, '1214018', 480000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(19, '1214019', 360000, '2014/2015', 'Ganjil', 'Belum Lunas'),
(20, '1214020', 740000, '2014/2015', 'Ganjil', 'Belum Lunas');

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

--
-- Dumping data for table `uang_infaq`
--

INSERT INTO `uang_infaq` (`donatur_id`, `nama_lengkap`, `jumlah`, `tanggal_diterima`, `pegawai_id`, `keterangan`) VALUES
(1, 'Udin Salahudin', 1000000, '2019-07-09', 100001, 'Infaq Rutin Bapak Salahudin'),
(2, 'Rincoe Manto', 500000, '2019-07-01', 100001, 'Infaq Dari Bapak Manto'),
(3, 'Reza Arman', 50000, '2019-06-11', 100001, 'Infaq Reza'),
(4, 'Budi Boy', 100000, '2019-07-03', 100001, 'Infaq Boy'),
(5, 'Iwan Marwan', 300000, '2019-07-03', 100001, 'Infaq Marwan'),
(6, 'Aisyah Fatimah', 500000, '2019-07-02', 100001, 'Infaq Ibu Aisyah'),
(7, 'Rizka Afkha', 100000, '2019-07-02', 100001, 'Infaq Rizka'),
(8, 'Tasya Solihudin', 2000000, '2019-07-01', 100001, 'Infaq Tasya'),
(9, 'Faturrahman ', 350000, '2019-07-01', 100001, 'Infaq Fathurrahman'),
(10, 'Sakijo Jojo', 50000, '2019-07-08', 100001, 'Infaq Sakijo'),
(11, 'Fateh Ali', 350000, '2019-07-03', 100001, 'Infaq Fateh'),
(12, 'Muhammad Imam', 100000, '2019-07-03', 100001, 'Infaq Imam'),
(13, 'Yusuf Faturrahman', 1000000, '2019-07-03', 100001, 'Infaq Yusuf'),
(14, 'Ananda Daulay', 100000, '2019-07-09', 100001, 'Infaq Daulay'),
(15, 'Rafi Rasy', 100000, '2019-07-06', 100001, 'Infaq Rasi');

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

--
-- Dumping data for table `uang_pembangunan`
--

INSERT INTO `uang_pembangunan` (`pembayaran_id`, `NIS`, `tagihan_id`, `tahun_ajaran`, `semester`, `status`) VALUES
(2, '1214002', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(3, '1214003', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(4, '1214004', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(5, '1214005', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(6, '1214006', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(7, '1214007', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(8, '1214008', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(9, '1214009', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(10, '1214010', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(11, '1214011', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(12, '1214012', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(13, '1214013', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(14, '1214014', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(15, '1214015', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(16, '1214016', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(17, '1214017', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(18, '1214018', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(19, '1214019', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(20, '1214020', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(21, '1214021', 310, '2014/2015', 'Ganjil', 'Belum Lunas'),
(22, '1214022', 310, '2014/2015', 'Ganjil', 'Belum Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `uang_pondok`
--

CREATE TABLE `uang_pondok` (
  `pembayaran_id` int(11) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `tagihan_id` int(11) NOT NULL DEFAULT '312',
  `tahun` int(5) NOT NULL,
  `bulan` int(5) NOT NULL,
  `status` enum('Lunas','Belum Lunas') NOT NULL DEFAULT 'Belum Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uang_pondok`
--

INSERT INTO `uang_pondok` (`pembayaran_id`, `NIS`, `tagihan_id`, `tahun`, `bulan`, `status`) VALUES
(1107, '1214007', 312, 2014, 6, 'Lunas'),
(1109, '1214009', 312, 2014, 6, 'Belum Lunas'),
(1110, '1214010', 312, 2014, 6, 'Belum Lunas'),
(1111, '1214011', 312, 2014, 6, 'Belum Lunas'),
(1112, '1214012', 312, 2014, 6, 'Belum Lunas'),
(1113, '1214013', 312, 2014, 6, 'Belum Lunas'),
(1114, '1214014', 312, 2014, 6, 'Belum Lunas'),
(1115, '1214015', 312, 2014, 6, 'Belum Lunas'),
(1116, '1214016', 312, 2014, 6, 'Belum Lunas'),
(1117, '1214017', 312, 2014, 6, 'Belum Lunas'),
(1118, '1214018', 312, 2014, 6, 'Belum Lunas'),
(1119, '1214019', 312, 2014, 6, 'Belum Lunas'),
(1120, '1214020', 312, 2014, 6, 'Belum Lunas'),
(1121, '1214021', 312, 2014, 6, 'Belum Lunas'),
(1122, '1214022', 312, 2014, 6, 'Belum Lunas'),
(1123, '1214023', 312, 2014, 6, 'Belum Lunas'),
(1124, '1214024', 312, 2014, 6, 'Belum Lunas'),
(1125, '1214025', 312, 2014, 6, 'Belum Lunas'),
(1127, '1214001', 312, 2014, 6, 'Lunas');

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
-- Dumping data for table `uang_spp`
--

INSERT INTO `uang_spp` (`pembayaran_id`, `NIS`, `tagihan_id`, `tahun_ajaran`, `semester`) VALUES
(1101, '1214001', 311, '2014/2015', 'Ganjil'),
(1102, '1214002', 311, '2014/2015', 'Ganjil'),
(1103, '1214003', 311, '2014/2015', 'Ganjil'),
(1104, '1214004', 311, '2014/2015', 'Ganjil'),
(1105, '1214005', 311, '2014/2015', 'Ganjil'),
(1106, '1214006', 311, '2014/2015', 'Ganjil'),
(1107, '1214007', 311, '2014/2015', 'Ganjil'),
(1108, '1214008', 311, '2014/2015', 'Ganjil'),
(1109, '1214009', 311, '2014/2015', 'Ganjil'),
(1110, '1214010', 311, '2014/2015', 'Ganjil'),
(1111, '1214011', 311, '2014/2015', 'Ganjil'),
(1112, '1214012', 311, '2014/2015', 'Ganjil'),
(1113, '1214013', 311, '2014/2015', 'Ganjil'),
(1114, '1214014', 311, '2014/2015', 'Ganjil'),
(1115, '1214015', 311, '2014/2015', 'Ganjil'),
(1116, '1214016', 311, '2014/2015', 'Ganjil'),
(1117, '1214017', 311, '2014/2015', 'Ganjil'),
(1118, '1214018', 311, '2014/2015', 'Ganjil'),
(1119, '1214019', 311, '2014/2015', 'Ganjil'),
(1120, '1214020', 311, '2014/2015', 'Ganjil'),
(1121, '1214021', 311, '2014/2015', 'Ganjil'),
(1122, '1214022', 311, '2014/2015', 'Ganjil'),
(1123, '1214023', 311, '2014/2015', 'Ganjil'),
(1124, '1214024', 311, '2014/2015', 'Ganjil'),
(1125, '1214025', 311, '2014/2015', 'Ganjil');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_lihatpembayaranbimbel`
-- (See below for the actual view)
--
CREATE TABLE `v_lihatpembayaranbimbel` (
`pembayaran_id` int(11)
,`NIS` varchar(16)
,`nama` varchar(60)
,`tahun_ajaran` varchar(9)
,`semester` enum('Genap','Ganjil')
,`jumlah` int(11)
,`status` enum('Lunas','Belum Lunas')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_lihatpembayaranpembangunan`
-- (See below for the actual view)
--
CREATE TABLE `v_lihatpembayaranpembangunan` (
`pembayaran_id` int(11)
,`NIS` varchar(16)
,`nama` varchar(60)
,`tahun_ajaran` varchar(9)
,`semester` enum('Ganjil','Genap')
,`jumlah` int(11)
,`status` enum('Lunas','Belum Lunas')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_lihatpembayaranpondok`
-- (See below for the actual view)
--
CREATE TABLE `v_lihatpembayaranpondok` (
`pembayaran_id` int(11)
,`NIS` varchar(16)
,`nama` varchar(60)
,`tahun` int(5)
,`bulan` int(5)
,`jumlah` int(11)
,`status` enum('Lunas','Belum Lunas')
);

-- --------------------------------------------------------

--
-- Structure for view `v_lihatpembayaranbimbel`
--
DROP TABLE IF EXISTS `v_lihatpembayaranbimbel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lihatpembayaranbimbel`  AS  select `uang_bimbel`.`pembayaran_id` AS `pembayaran_id`,`siswa`.`NIS` AS `NIS`,`siswa`.`nama` AS `nama`,`uang_bimbel`.`tahun_ajaran` AS `tahun_ajaran`,`uang_bimbel`.`semester` AS `semester`,`jenis_tagihan`.`jumlah` AS `jumlah`,`uang_bimbel`.`status` AS `status` from ((`uang_bimbel` join `siswa`) join `jenis_tagihan` on(((`uang_bimbel`.`NIS` = `siswa`.`NIS`) and (`uang_bimbel`.`tagihan_id` = `jenis_tagihan`.`tagihan_id`)))) order by `siswa`.`NIS` ;

-- --------------------------------------------------------

--
-- Structure for view `v_lihatpembayaranpembangunan`
--
DROP TABLE IF EXISTS `v_lihatpembayaranpembangunan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lihatpembayaranpembangunan`  AS  select `uang_pembangunan`.`pembayaran_id` AS `pembayaran_id`,`siswa`.`NIS` AS `NIS`,`siswa`.`nama` AS `nama`,`uang_pembangunan`.`tahun_ajaran` AS `tahun_ajaran`,`uang_pembangunan`.`semester` AS `semester`,`jenis_tagihan`.`jumlah` AS `jumlah`,`uang_pembangunan`.`status` AS `status` from ((`uang_pembangunan` join `siswa`) join `jenis_tagihan` on(((`uang_pembangunan`.`NIS` = `siswa`.`NIS`) and (`uang_pembangunan`.`tagihan_id` = `jenis_tagihan`.`tagihan_id`)))) order by `siswa`.`NIS` ;

-- --------------------------------------------------------

--
-- Structure for view `v_lihatpembayaranpondok`
--
DROP TABLE IF EXISTS `v_lihatpembayaranpondok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lihatpembayaranpondok`  AS  select `uang_pondok`.`pembayaran_id` AS `pembayaran_id`,`siswa`.`NIS` AS `NIS`,`siswa`.`nama` AS `nama`,`uang_pondok`.`tahun` AS `tahun`,`uang_pondok`.`bulan` AS `bulan`,`jenis_tagihan`.`jumlah` AS `jumlah`,`uang_pondok`.`status` AS `status` from ((`uang_pondok` join `siswa`) join `jenis_tagihan` on(((`uang_pondok`.`NIS` = `siswa`.`NIS`) and (`uang_pondok`.`tagihan_id` = `jenis_tagihan`.`tagihan_id`)))) order by `siswa`.`NIS` ;

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
  MODIFY `tagihan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `pegawai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100006;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `pengeluaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uang_bimbel`
--
ALTER TABLE `uang_bimbel`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `uang_buku`
--
ALTER TABLE `uang_buku`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `uang_infaq`
--
ALTER TABLE `uang_infaq`
  MODIFY `donatur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `uang_pembangunan`
--
ALTER TABLE `uang_pembangunan`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `uang_pondok`
--
ALTER TABLE `uang_pondok`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1128;

--
-- AUTO_INCREMENT for table `uang_spp`
--
ALTER TABLE `uang_spp`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1126;

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
