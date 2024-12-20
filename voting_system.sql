-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 12:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting system`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `id` varchar(8) NOT NULL,
  `motto` text NOT NULL,
  `size` varchar(48) NOT NULL DEFAULT 'col-4 col-md-2',
  `campaign` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` varchar(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pfp` varchar(255) NOT NULL,
  `dept` enum('Computer Department','IT Department','Mechanical Department','Electrical Department','EXTC Department') NOT NULL,
  `post` enum('General Secretary','Joint Secretary','Sports Secretary','Cultural Secretary') NOT NULL,
  `reason` text NOT NULL,
  `cgpa` decimal(5,3) NOT NULL,
  `achieve` text NOT NULL,
  `club` text NOT NULL,
  `cert` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `comments` text NOT NULL,
  `attempts` int(1) NOT NULL,
  `voteCount` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `sr` int(5) NOT NULL,
  `id` varchar(8) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pw` varchar(8) NOT NULL,
  `voteStatus` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`sr`);

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `sr` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
