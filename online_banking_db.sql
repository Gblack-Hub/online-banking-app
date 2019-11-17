-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2019 at 05:00 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_banking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_tb`
--

CREATE TABLE `account_tb` (
  `id` int(5) NOT NULL,
  `acct_number` int(20) NOT NULL,
  `acct_type_id` int(5) NOT NULL,
  `acct_status` varchar(15) NOT NULL,
  `acct_balance` int(10) NOT NULL,
  `opening_date` varchar(15) NOT NULL,
  `user_id` int(5) NOT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` datetime(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_type_tb`
--

CREATE TABLE `account_type_tb` (
  `id` int(5) NOT NULL,
  `acct_type` int(20) NOT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` datetime(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_tb`
--

CREATE TABLE `transactions_tb` (
  `id` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `credit` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `acct_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_date` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `user_id` int(5) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `date_of_birth` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `passport` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`user_id`, `firstname`, `lastname`, `email`, `password`, `date_of_birth`, `phone_number`, `gender`, `passport`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'john@gmail.com', 'john', '2019-11-06', '097883', 'male', '0', '2019-11-17 01:53:47', '2019-11-17 01:53:47'),
(2, 'Ola', 'Wale', 'ola@gmail.com', 'ola', '2019-11-06', '097883', 'female', '0', '2019-11-17 01:55:01', '2019-11-17 01:55:01'),
(3, 'Olu', 'Ade', 'olu@gmail.com', 'olu', '1999-06-05', '34567890', 'male', '0', '2019-11-17 02:00:28', '2019-11-17 02:00:28'),
(15, 'Olu', 'Ade', 'oluade@gmail.com', 'olu', '1999-06-05', '34567890', 'male', '0', '2019-11-17 02:20:38', '2019-11-17 02:20:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_tb`
--
ALTER TABLE `account_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_type_tb`
--
ALTER TABLE `account_type_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_tb`
--
ALTER TABLE `account_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_type_tb`
--
ALTER TABLE `account_type_tb`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
