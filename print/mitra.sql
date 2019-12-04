-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2018 at 12:10 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitra`
--

-- --------------------------------------------------------

--
-- Table structure for table `surat_penawaran`
--

CREATE TABLE `surat_penawaran` (
  `id_sp` int(9) NOT NULL,
  `tanggal_buat` date NOT NULL,
  `nama_p` varchar(50) NOT NULL,
  `periode_surat` int(1) NOT NULL,
  `harga_pokok` int(10) NOT NULL,
  `diskon` double NOT NULL,
  `harga_dasar` double NOT NULL,
  `ppn` double NOT NULL,
  `pbbkb` double NOT NULL,
  `pbbkb_m` int(1) NOT NULL,
  `pph_migas` double NOT NULL,
  `oat` int(5) NOT NULL,
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_penawaran`
--

INSERT INTO `surat_penawaran` (`id_sp`, `tanggal_buat`, `nama_p`, `periode_surat`, `harga_pokok`, `diskon`, `harga_dasar`, `ppn`, `pbbkb`, `pbbkb_m`, `pph_migas`, `oat`, `total`) VALUES
(201808001, '2018-08-09', 'PT Coba sadja', 1, 11600, 3375.243, 8392.1234, 839.12345, 538.4321123, 3, 32.8392, 125, 9500),
(201808002, '0000-00-00', 'PT.INDOFOOD', 1, 12000, 3375.4480286738, 8624.5519713262, 862.45519713262, 112.11917562724, 2, 25.873655913978, 125, 9750),
(201808003, '2018-08-12', 'PT.INDOFOOD', 1, 13000, 4285.8422939068, 8714.1577060932, 871.41577060932, 113.28405017921, 1, 26.14247311828, 125, 9850),
(201808004, '2018-08-12', 'PT.INDOFOOD', 1, 13000, 4285.8422939068, 8714.1577060932, 871.41577060932, 113.28405017921, 1, 26.14247311828, 125, 9850),
(201808005, '2018-08-12', 'PT.MELLYFOOD', 1, 11530, 3219.0681003584, 8310.9318996416, 831.09318996416, 108.04211469534, 1, 24.932795698925, 500, 9775),
(201808009, '2018-08-13', 'tes', 2, 9420, 2807.9928315412, 6612.0071684588, 661.20071684588, 85.956093189964, 1, 19.836021505376, 121, 7500),
(201808010, '2018-08-13', 'gg', 2, 10000, 2025.0896057348, 7974.9103942652, 797.49103942652, 103.67383512545, 1, 23.924731182796, 100, 9000),
(201808011, '2018-08-14', 'aa', 1, 12000, 3935.4838709677, 8064.5161290323, 806.45161290323, 104.83870967742, 1, 24.193548387097, 500, 9500);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(1) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `nama` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`) VALUES
(1, 'admin', 'pass123', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surat_penawaran`
--
ALTER TABLE `surat_penawaran`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
