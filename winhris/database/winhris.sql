-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
-- 
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 04:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `winhris`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `log_type` tinyint(1) NOT NULL COMMENT '1 = AM IN,2 = AM out, 3= PM IN, 4= PM out\r\n',
  `datetime_log` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(20) NOT NULL,
  `employee_no` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_no`, `firstname`, `middlename`, `lastname`, `department`, `position`, `birthday`) VALUES
(2, '2020-3438', 'Mario', '', 'Speedwagon', 'IT', 'Programmer', NULL),
(3, '2020-5819', 'John', '', 'Smith', 'IT', 'Programmer', NULL),
(5, '2020-2677', 'Paige', '', 'Turner', 'IT', 'Admin', NULL),
(6, '2020-3002', 'Bob', '', 'Frapples', 'HR', 'Staff', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin', 'admin123', 'Admin', 'Administrator'),
(2, 'Sample', 'sample123', 'Sample', 'Sample');

--
-- Indexes for dumped tables
--

-- Indexes for table `attendance`
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `employee`
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `events`
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

-- AUTO_INCREMENT for table `attendance`
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table `employee`
ALTER TABLE `employee`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- AUTO_INCREMENT for table `events`
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `users`
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- --------------------------------------------------------

-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `employee_id` int(20) NOT NULL,  -- Reference to the employee creating the announcement
  `created_by` int(20) NOT NULL,   -- Reference to the user who created the announcement (if different)
  `announcement_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('active', 'inactive') DEFAULT 'active',  -- Announcement status
  FOREIGN KEY (`employee_id`) REFERENCES `employee`(`id`),  -- Linking to employee table
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)      -- Optional: Linking to users table
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Dumping data for table `announcements`
-- Sample data (if any)
INSERT INTO `announcements` (`id`, `title`, `description`, `employee_id`, `created_by`, `announcement_date`, `status`) VALUES
(1, 'New Policy Update', 'The company policy has been updated...', 2, 1, '2024-11-17 14:30:00', 'active'),
(2, 'Holiday Notice', 'Office will be closed on the upcoming holiday.', 3, 2, '2024-11-16 09:00:00', 'active');

-- --------------------------------------------------------

-- Indexes for table `announcements`
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for table `announcements`
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
