-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2023 at 11:56 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oks`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `type` varchar(300) NOT NULL,
  `amount` varchar(300) NOT NULL,
  `rdate` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `balance` varchar(200) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `email`, `balance`, `amount`) VALUES
(1, 'adenijijerry@gmail.com', 'nairab', 0),
(2, 'adenijijerry@gmail.com', 'naira', 0),
(3, 'adenijijerry@gmail.com', 'dollar', 0),
(4, 'adenijijerry@gmail.com', 'inv', 0);

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `code` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dataplans`
--

CREATE TABLE `dataplans` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `amt` varchar(300) NOT NULL,
  `type` varchar(300) NOT NULL,
  `rank` varchar(11) NOT NULL,
  `network` varchar(100) NOT NULL,
  `value` varchar(465) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `fee` varchar(200) NOT NULL,
  `rank` varchar(200) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `name`, `fee`, `rank`, `min`, `max`, `duration`) VALUES
(16, 'savings', '9', 'Student', 20000, 90000, 0),
(17, 'savings', '19', 'Business', 100000, 150000, 0),
(18, 'savings', '10', 'Money market', 10000, 400000, 0),
(19, 'Loan', '10', '', 0, 0, 0),
(20, 'card fee', '0.8', '', 0, 0, 0),
(21, 'investment', '2', 'real estate', 10000, 50000, 4),
(22, 'investment', '5', 'agriculture', 100000, 800000, 5),
(23, 'investment', '5', 'transportation', 1000000, 5000000, 3),
(24, 'savings', '600', 'dollarate', 500000, 1000000, 0),
(25, 'savings', '30', 'dollar', 20000, 90000, 0),
(26, 'investment', '9', 'bitcoin', 20000, 900000, 3),
(39, 'dollar', '5', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `plan` varchar(300) NOT NULL,
  `amount` varchar(300) NOT NULL,
  `interest` varchar(300) NOT NULL,
  `mature` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `date` varchar(300) NOT NULL,
  `intw` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `amount` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `address` varchar(300) NOT NULL,
  `bvn` varchar(300) NOT NULL,
  `adate` varchar(200) NOT NULL,
  `repay` varchar(100) NOT NULL,
  `repayd` varchar(100) NOT NULL,
  `repayamt` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `role`) VALUES
(17, 'admin', 'test1', 'admin'),
(23, 'test@gmail.com', 'testtest', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `main` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` int(11) NOT NULL,
  `plan` varchar(300) NOT NULL,
  `amount` varchar(300) NOT NULL,
  `interest` varchar(300) NOT NULL,
  `mature` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `date` varchar(300) NOT NULL,
  `intw` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `cat` varchar(300) NOT NULL,
  `amount` varchar(300) NOT NULL,
  `type` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `rdate` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(300) NOT NULL,
  `last_name` varchar(300) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `address` varchar(300) NOT NULL,
  `bvn` varchar(300) NOT NULL,
  `jdate` varchar(300) NOT NULL,
  `rank` varchar(1) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `emailv` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `email`, `address`, `bvn`, `jdate`, `rank`, `pin`, `emailv`) VALUES
(1, 'test', '', '08063509221', 'test@gmail.com', ' ', '', '2023-08-11', '1', 'null', '1');

-- --------------------------------------------------------

--
-- Table structure for table `vaccounts`
--

CREATE TABLE `vaccounts` (
  `id` int(11) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `bank` varchar(300) NOT NULL,
  `number` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `waccount`
--

CREATE TABLE `waccount` (
  `id` int(11) NOT NULL,
  `phone` varchar(300) NOT NULL,
  `bank` varchar(300) NOT NULL,
  `number` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `number` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataplans`
--
ALTER TABLE `dataplans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccounts`
--
ALTER TABLE `vaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waccount`
--
ALTER TABLE `waccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dataplans`
--
ALTER TABLE `dataplans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vaccounts`
--
ALTER TABLE `vaccounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
