-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2019 at 06:34 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exponential_smoothing`
--

-- --------------------------------------------------------

--
-- Table structure for table `datalatih`
--

CREATE TABLE `datalatih` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `hasil_penjualan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `datalatih`
--

INSERT INTO `datalatih` (`id`, `tgl`, `hasil_penjualan`) VALUES
(1, '2017-08-28', 40220000),
(2, '2017-09-04', 43750000),
(3, '2017-09-17', 52111000),
(4, '2017-09-24', 24640000),
(5, '2017-09-25', 15492000),
(6, '2017-10-02', 19555000),
(7, '2017-10-09', 22266000),
(8, '2017-10-16', 20798000),
(9, '2017-10-23', 12335000),
(10, '2017-10-30', 13205000),
(11, '2017-11-06', 11846000),
(12, '2017-11-13', 17490000),
(13, '2017-11-20', 29278000),
(14, '2017-11-27', 24365000),
(15, '2017-12-04', 16688000),
(16, '2017-12-11', 8300000),
(17, '2017-12-18', 22395000),
(18, '2017-12-25', 46290000),
(19, '2018-01-01', 26832000),
(20, '2018-01-08', 21390000),
(21, '2018-01-15', 1960000),
(22, '2018-01-22', 17585000),
(23, '2018-01-29', 10865000),
(24, '2018-02-05', 7402000),
(25, '2018-02-12', 16375000),
(26, '2018-02-19', 11065000),
(27, '2018-02-26', 8995000),
(28, '2018-03-05', 15000000),
(29, '2018-03-12', 20260000),
(30, '2018-03-19', 16355000),
(31, '2018-03-26', 13510000),
(32, '2018-04-02', 10180000),
(33, '2018-04-09', 11935000),
(34, '2018-04-16', 6570000),
(35, '2018-04-23', 7960000),
(36, '2018-04-30', 29465000),
(37, '2018-05-07', 21123000),
(38, '2018-05-14', 44449000),
(39, '2018-05-21', 16740000);

-- --------------------------------------------------------

--
-- Table structure for table `datauji`
--

CREATE TABLE `datauji` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `hasil_penjualan` double NOT NULL,
  `bulan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `datauji`
--

INSERT INTO `datauji` (`id`, `tgl`, `hasil_penjualan`, `bulan`) VALUES
(1, '2018-05-28', 9535000, 'Mei'),
(2, '2018-06-04', 53729000, 'Juni'),
(3, '2018-06-11', 45601000, 'Juni'),
(4, '2018-06-18', 36988000, 'Juni'),
(5, '2018-06-25', 46908000, 'Juni'),
(6, '2018-07-02', 37845000, 'Juli'),
(7, '2018-07-09', 33204000, 'Juli'),
(8, '2018-07-16', 20714000, 'Juli'),
(9, '2018-07-23', 16823000, 'Juli'),
(10, '2018-07-30', 9660000, 'Juli'),
(11, '2018-08-06', 21580000, 'Agustus'),
(12, '2018-08-13', 16788000, 'Agustus'),
(13, '2018-08-20', 7200000, 'Agustus'),
(14, '2018-08-27', 7800000, 'Agustus'),
(15, '2018-09-03', 8600000, 'September'),
(16, '2018-09-10', 10074000, 'September'),
(17, '2018-09-17', 5420000, 'September'),
(18, '2018-09-24', 6965000, 'September'),
(19, '2018-10-01', 66512000, 'Oktober'),
(20, '2018-10-08', 4830000, 'Oktober'),
(21, '2018-10-15', 44930000, 'Oktober'),
(22, '2018-10-22', 47430000, 'Oktober'),
(23, '2018-10-29', 48748000, 'Oktober'),
(24, '2018-11-05', 55535000, 'November'),
(25, '2018-11-12', 53020000, 'November'),
(26, '2018-11-19', 41700000, ''),
(27, '2018-11-26', 45140000, ''),
(28, '2018-12-03', 52590000, ''),
(29, '2018-12-10', 41367000, ''),
(30, '2018-12-17', 42703000, ''),
(31, '2018-12-24', 39675000, ''),
(32, '2018-12-31', 34512000, ''),
(33, '2019-01-07', 48070000, ''),
(34, '2019-01-14', 43960000, ''),
(35, '2019-01-21', 20673000, ''),
(36, '2019-01-28', 71597000, ''),
(37, '2019-02-04', 59883700, ''),
(38, '2019-02-11', 80721000, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datalatih`
--
ALTER TABLE `datalatih`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datauji`
--
ALTER TABLE `datauji`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datalatih`
--
ALTER TABLE `datalatih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `datauji`
--
ALTER TABLE `datauji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
