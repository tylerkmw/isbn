-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2017 at 03:57 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wholesale`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `isbn` varchar(36) NOT NULL,
  `booknum` varchar(36) NOT NULL,
  `title` varchar(128) NOT NULL,
  `author` varchar(128) NOT NULL,
  `publisher` varchar(36) NOT NULL,
  `year` int(4) NOT NULL,
  `format` varchar(36) NOT NULL,
  `mark` varchar(36) NOT NULL,
  `hurt` varchar(36) NOT NULL,
  `pubprice` decimal(19,2) NOT NULL,
  `srp` decimal(19,2) NOT NULL,
  `avail` decimal(19,2) NOT NULL,
  `isupdated` int(2) NOT NULL,
  `downloaded` int(2) NOT NULL,
  `salesrank` int(36) NOT NULL,
  `lowest_new_price_fba` decimal(19,2) NOT NULL,
  `lowest_new_price_merchant` decimal(19,2) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `value_of_book` decimal(19,2) NOT NULL,
  `profit_margin` decimal(19,2) NOT NULL,
  `profit_margin_roi` decimal(19,2) NOT NULL,
  `cond` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5355;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
