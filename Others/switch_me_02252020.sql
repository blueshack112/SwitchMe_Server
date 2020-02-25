-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2020 at 04:44 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `switch_me`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE `tbl_log` (
  `id` int(11) NOT NULL,
  `relay_id` int(11) NOT NULL,
  `started_at` datetime NOT NULL,
  `ended_at` datetime DEFAULT NULL,
  `energy_usage` float DEFAULT NULL,
  `transaction_status` varchar(254) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_log`
--

INSERT INTO `tbl_log` (`id`, `relay_id`, `started_at`, `ended_at`, `energy_usage`, `transaction_status`) VALUES
(1, 1, '2020-02-23 07:39:00', '2020-02-23 07:39:00', 0, 'complete'),
(2, 1, '2020-02-23 07:39:00', '2020-02-23 07:39:00', 40.8, 'complete'),
(3, 1, '2020-02-23 05:21:00', '2020-02-23 07:39:00', 40.8, 'complete'),
(4, 1, '2020-01-23 08:30:48', '2020-01-23 08:32:51', 40.8, 'complete'),
(5, 1, '2020-01-24 07:48:28', '2020-01-24 07:48:32', 40.8, 'complete'),
(6, 1, '2020-01-24 08:10:54', '2020-01-24 08:11:18', 40.8, 'complete'),
(7, 1, '2020-01-24 04:52:17', '2020-01-24 04:52:24', 40.8, 'complete'),
(8, 2, '2020-01-24 04:52:32', '2020-01-24 04:53:14', 31.88, 'complete'),
(9, 3, '2020-01-24 05:01:11', '2020-01-24 05:01:17', 0, 'complete'),
(10, 3, '2020-01-24 05:02:05', '2020-01-24 05:02:50', 55.35, 'complete'),
(11, 3, '2020-01-24 05:11:42', '2020-01-24 05:11:43', 55.35, 'complete'),
(12, 3, '2020-01-24 05:11:43', '2020-01-24 05:11:44', 55.35, 'complete'),
(13, 1, '2020-01-24 05:11:58', '2020-01-24 05:11:59', 40.8, 'complete'),
(14, 1, '2020-01-24 05:12:02', '2020-01-24 05:14:45', 40.8, 'complete'),
(15, 1, '2020-01-24 05:15:25', '2020-01-24 05:15:44', 0.02, 'complete'),
(16, 1, '2020-01-24 05:15:53', '2020-01-24 05:15:54', 0.02, 'complete'),
(17, 1, '2020-01-24 05:15:57', '2020-01-24 05:15:59', 0, 'complete'),
(18, 1, '2020-01-24 05:16:03', '2020-01-24 05:16:06', 0.02, 'complete'),
(19, 1, '2020-01-25 00:55:07', '2020-01-25 00:55:15', 0.02, 'complete'),
(20, 1, '2020-01-25 00:55:18', '2020-01-25 00:55:23', 0.02, 'complete'),
(21, 1, '2020-01-25 00:58:41', '2020-01-25 00:58:43', 0.02, 'complete'),
(22, 1, '2020-01-25 01:00:47', '2020-01-25 01:01:21', 0, 'complete'),
(23, 1, '2020-02-25 14:19:00', '2020-01-25 01:19:13', 87.68, 'complete'),
(24, 1, '2020-01-25 01:20:15', '2020-01-25 01:20:20', 87.68, 'complete'),
(25, 1, '2020-01-25 01:20:41', '2020-01-25 01:20:42', 0, 'complete'),
(26, 1, '2020-01-25 01:20:47', '2020-01-25 01:22:15', 0.4, 'complete'),
(27, 1, '2020-01-25 01:22:17', '2020-01-25 01:24:59', 0.4, 'complete'),
(28, 1, '2020-01-25 01:26:09', '2020-01-25 01:26:24', 0.4, 'complete'),
(29, 1, '2020-02-25 14:28:00', '2020-01-25 02:00:05', 0.4, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `id` int(11) NOT NULL,
  `relay_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `id` int(11) NOT NULL,
  `col_state` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `volts` float NOT NULL DEFAULT '0',
  `amps` float NOT NULL DEFAULT '0',
  `power` float NOT NULL DEFAULT '0',
  `energy` float DEFAULT '0',
  `cost` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `col_state`, `created_at`, `volts`, `amps`, `power`, `energy`, `cost`) VALUES
(1, 'ON', '2020-02-25 19:05:00', 247, 0.17, 433, 1850.32, 0.71),
(2, 'ON', '2020-02-25 19:20:12', 220, 40, 800, 31.88, 500),
(3, 'ON', '2020-01-24 05:11:44', 220, 4, 800, 55.35, 550);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `relay_id` (`relay_id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
