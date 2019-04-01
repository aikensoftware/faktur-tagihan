-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2018 at 04:54 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `data` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `data`) VALUES
(1, 1, 'a:3:{s:3:"uri";a:12:{i:0;s:9:"/welcome/";i:1;s:6:"/home/";i:2;s:21:"/tag_pelanggan/index/";i:3;s:25:"/tag_pelanggan/cari_data/";i:4;s:20:"/tag_pelanggan/read/";i:5;s:22:"/tag_pelanggan/create/";i:6;s:29:"/tag_pelanggan/create_action/";i:7;s:22:"/tag_pelanggan/update/";i:8;s:29:"/tag_pelanggan/update_action/";i:9;s:22:"/tag_pelanggan/_rules/";i:10;s:21:"/tag_pelanggan/excel/";i:11;s:28:"/tag_pelanggan/cetak_faktur/";}s:4:"edit";s:1:"1";s:6:"delete";s:0:"";}'),
(2, 2, 'a:2:{s:4:"edit";s:1:"1";s:6:"delete";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'User'),
(2, 0, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tag_layanan`
--

CREATE TABLE IF NOT EXISTS `tag_layanan` (
  `id_layanan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `ket` varchar(100) NOT NULL,
  `urutan` int(2) NOT NULL,
  PRIMARY KEY (`id_layanan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tag_layanan`
--

INSERT INTO `tag_layanan` (`id_layanan`, `nama`, `harga`, `ket`, `urutan`) VALUES
(1, 'Hemat', 100000, 'Paket internet 1 MBps', 1),
(2, 'Pangkal', 250000, 'Paket internet 3 MBps', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tag_patner`
--

CREATE TABLE IF NOT EXISTS `tag_patner` (
  `id_patner` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `acak` varchar(60) NOT NULL,
  PRIMARY KEY (`id_patner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tag_patner`
--

INSERT INTO `tag_patner` (`id_patner`, `kode`, `nama`, `alamat`, `telp`, `acak`) VALUES
(1, 'R001', 'Joko widodo', 'Selo - Balerejo -Kec kebonsari', '123', ''),
(2, 'R002', 'Elly dwi cahyono', 'Musir dagangan madiun', '930393', ''),
(4, 'R0004', 'Rudi cahyono', 'JL.Indah permai 234 Madiun', '3383033', '');

-- --------------------------------------------------------

--
-- Table structure for table `tag_pelanggan`
--

CREATE TABLE IF NOT EXISTS `tag_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_patner` int(11) NOT NULL,
  `in_pajak` int(1) NOT NULL,
  `tanggal_pasang` date NOT NULL,
  `status` int(1) NOT NULL,
  `acak` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tag_pelanggan`
--

INSERT INTO `tag_pelanggan` (`id_pelanggan`, `kode`, `nama`, `alamat`, `telp`, `id_layanan`, `id_patner`, `in_pajak`, `tanggal_pasang`, `status`, `acak`) VALUES
(1, 'P0001', 'AGUNG WICAKSONO', 'JL. TAWANG KRIDA NO 34 MADIUN', '93039', 1, 1, 2, '2017-12-17', 1, ''),
(2, 'P0002', 'EKO WAHYUONO', 'JL. MERAK BANTEN PEMALANG', '393039', 2, 2, 1, '2017-12-11', 1, ''),
(3, 'P0003', 'niken yeviningtyas', 'Jl.bandar gebang', '90000', 1, 2, 2, '2017-12-06', 1, ''),
(4, 'P0004', 'Imaman supangat', 'JL.kendal ngawi', '39303930', 2, 1, 2, '2017-12-12', 2, ''),
(5, 'P0005', 'Joni pedrosa', 'asdf', 'asd', 1, 3, 2, '2018-01-02', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tag_tagihan`
--

CREATE TABLE IF NOT EXISTS `tag_tagihan` (
  `id_tagihan` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `periode` varchar(30) NOT NULL,
  `no_transaksi` varchar(30) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `total_tagihan` int(11) NOT NULL,
  `pokok` decimal(16,2) NOT NULL,
  `pajak` decimal(16,2) NOT NULL,
  `status` int(2) NOT NULL,
  `user_buat` int(11) NOT NULL,
  PRIMARY KEY (`id_tagihan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tag_tagihan`
--

INSERT INTO `tag_tagihan` (`id_tagihan`, `tanggal`, `periode`, `no_transaksi`, `id_pelanggan`, `total_tagihan`, `pokok`, `pajak`, `status`, `user_buat`) VALUES
(46, '2018-01-02 04:35:44', '', 'BITS4568', 1, 100000, '100000.00', '10000.00', 0, 1),
(47, '2018-01-02 04:35:44', '', 'BITS4569', 2, 250000, '225000.00', '25000.00', 0, 1),
(48, '2018-01-02 04:35:44', '', 'BITS4570', 3, 100000, '100000.00', '10000.00', 0, 1),
(49, '2018-01-02 04:35:44', '', 'BITS4571', 5, 100000, '100000.00', '10000.00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tag_usaha`
--

CREATE TABLE IF NOT EXISTS `tag_usaha` (
  `id_usaha` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `ket` varchar(100) NOT NULL,
  PRIMARY KEY (`id_usaha`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tag_usaha`
--

INSERT INTO `tag_usaha` (`id_usaha`, `nama`, `alamat`, `telp`, `ket`) VALUES
(1, 'PT. BINA INFORMATIKA SOLUSI', 'Jl.Rawa bhakti No.60C Madiun', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `id_parent` int(10) NOT NULL,
  `level` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `tingkat` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `title`, `url`, `icon`, `id_parent`, `level`, `urutan`, `tingkat`) VALUES
(95, 'Master Data', '#', '', 0, 2, 1, 2),
(96, 'item barang', '#', '', 95, 2, 1, 1),
(97, 'item barang Tambah', '#', '', 95, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `password` varchar(34) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `newpass` varchar(34) COLLATE utf8_bin DEFAULT NULL,
  `newpass_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_patner` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `email`, `banned`, `ban_reason`, `newpass`, `newpass_key`, `newpass_time`, `last_ip`, `last_login`, `created`, `modified`, `id_patner`) VALUES
(1, 2, 'admin', '$1$S14.z8/.$JkIqwCrnSSH6HlK4ulKpR1', 'admin@localhost.com', 0, NULL, NULL, NULL, NULL, '::1', '2018-01-02 04:04:33', '2008-11-30 04:56:32', '2018-01-02 03:04:33', 0),
(2, 1, 'user', '$1$S14.z8/.$JkIqwCrnSSH6HlK4ulKpR1', 'user@localhost.com', 0, NULL, NULL, NULL, NULL, '127.0.0.1', '2008-12-01 14:04:14', '2008-12-01 14:01:53', '2017-12-14 07:58:36', 0),
(3, 1, 'elly', '$1$S14.z8/.$JkIqwCrnSSH6HlK4ulKpR1', 'elly@localhost.com', 0, NULL, NULL, NULL, NULL, '::1', '2018-01-01 10:11:20', '2017-08-03 23:07:18', '2018-01-01 09:11:20', 2),
(4, 1, 'joko', '$1$S14.z8/.$JkIqwCrnSSH6HlK4ulKpR1', 'joko@localhost.com', 0, NULL, NULL, NULL, NULL, '::1', '2018-01-01 09:26:45', '2017-08-07 19:03:02', '2018-01-01 08:26:45', 1),
(5, 1, '0003', '$1$0s1.HA1.$LbpaUHzFOUA86f3C/h5vl.', '0003@localhost.com', 0, NULL, NULL, NULL, NULL, '::1', '2018-01-02 03:37:31', '2018-01-02 03:36:49', '2018-01-02 02:37:31', 3),
(6, 1, 'R0004', '$1$6H1.VZ/.$6GWpSxang6kPqJfCKk0pf0', 'R0004@localhost.com', 0, NULL, NULL, NULL, NULL, '::1', '2018-01-02 04:00:06', '2018-01-02 03:52:20', '2018-01-02 03:00:06', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `country`, `website`) VALUES
(1, 1, NULL, NULL),
(2, 3, NULL, NULL),
(3, 4, NULL, NULL),
(4, 5, NULL, NULL),
(5, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_temp`
--

CREATE TABLE IF NOT EXISTS `user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(34) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activation_key` varchar(50) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
