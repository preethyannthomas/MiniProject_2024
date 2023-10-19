-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2022 at 08:22 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `court`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sign_in`
--

CREATE TABLE `tbl_sign_in` (
  `adh_no` varchar(15) NOT NULL,
  `pass` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sign_in`
--

INSERT INTO `tbl_sign_in` (`adh_no`, `pass`) VALUES
('3586 4991 3783', '12345678'),
('358649913782', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sign_up`
--

CREATE TABLE `tbl_sign_up` (
  `name` varchar(20) NOT NULL,
  `adh_no` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `pass` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sign_up`
--

INSERT INTO `tbl_sign_up` (`name`, `adh_no`, `email`, `pass`) VALUES
('', '', '', ''),
('Preethy', '3586 4991 3785', 'ghjghjghj', 'preethy@gmail.co'),
('Preethy', '3586 4991 3799', 'dfgdfgdfg', 'preethy@gmail.co'),
('Preethy', '358649913782', 'preethy@gmail.com', '12345678'),
('Preethy', '6345 3457 2354', 'sdfsdfsdf', 'preethy@gmail.co');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_sign_in`
--
ALTER TABLE `tbl_sign_in`
  ADD PRIMARY KEY (`adh_no`);

--
-- Indexes for table `tbl_sign_up`
--
ALTER TABLE `tbl_sign_up`
  ADD PRIMARY KEY (`adh_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
