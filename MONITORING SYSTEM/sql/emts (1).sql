-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 03:47 AM
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
-- Database: `emts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `department`) VALUES
(1, 'admin', '12345', 'admin.dasmo@gmail.com', 'DASMO');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(8) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `middle_name` varchar(200) NOT NULL,
  `sex` enum('Female','Male') NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(500) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(200) NOT NULL,
  `civil_status` enum('Single','Married','Divorced','Seperated','Widowed') NOT NULL,
  `hiring_date` date NOT NULL,
  `contact_number` int(11) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `status` enum('Working','On Break','On Leave','Available') NOT NULL,
  `age` int(11) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `middle_name`, `sex`, `birthdate`, `address`, `position`, `department`, `civil_status`, `hiring_date`, `contact_number`, `email_address`, `status`, `age`, `photo_path`, `created_at`) VALUES
(1, 'Lovelynne Heart', 'Tabunlupa', 'Esmaya', 'Female', '2024-12-12', 'Brgy. Mohon, Arevalo', 'Project Manager', 'DASMO', 'Divorced', '2003-10-25', 2147483647, 'lala@gmail.com', 'Working', 21, '', '2025-02-13 01:41:13'),
(2, 'Mary Hope', 'Tabunlupa', 'Esmaya', 'Female', '2025-02-02', 'Brgy. Mohon, Arevalo', 'Intern', 'DASMO', 'Single', '2001-10-12', 2147483647, 'haha@gmail.com', 'Working', 12, 'emp_profile/Mary Hope_Tabunlupa/405926370_682761940679973_6049967254190273880_n.jpg', '2025-02-13 02:17:44'),
(3, 'Carla Mae', 'Carlos', 'Pa', 'Female', '2025-02-12', 'Concepcion, Iloilo', 'Intern', 'DASMO', '', '2000-12-10', 2147483647, 'vv@gmail.com', 'Working', 24, 'emp_profile/Carla Mae_Carlos/TABUNLUPA_MARY HOPE.png', '2025-02-13 02:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status_log`
--

CREATE TABLE `employee_status_log` (
  `id` int(16) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `status` enum('Working','On Break','On Leave','Available') NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NULL DEFAULT current_timestamp(),
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(12) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `record_number` varchar(16) NOT NULL,
  `date_generated` timestamp NOT NULL DEFAULT current_timestamp(),
  `task_group` varchar(75) NOT NULL,
  `total_tasks` int(11) NOT NULL,
  `completed_tasks` int(11) NOT NULL,
  `ongoing_tasks` int(11) NOT NULL,
  `cancelled_tasks` int(11) NOT NULL,
  `average_duration` int(11) NOT NULL,
  `remarks` int(11) NOT NULL,
  `efficiency_score` float NOT NULL,
  `employee_performance` enum('Outstanding','Very Satisfactory','Satisfactory','Fair','Poor') NOT NULL,
  `delay` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `record_number` varchar(16) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `service` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `service_status` enum('Ongoing','Completed','Cancelled') NOT NULL,
  `time_started` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_ended` timestamp NULL DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL,
  `completion_time` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`) KEY_BLOCK_SIZE=4,
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`) KEY_BLOCK_SIZE=8;

--
-- Indexes for table `employee_status_log`
--
ALTER TABLE `employee_status_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `record_number` (`record_number`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD UNIQUE KEY `record_number` (`record_number`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_status_log`
--
ALTER TABLE `employee_status_log`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_status_log`
--
ALTER TABLE `employee_status_log`
  ADD CONSTRAINT `employee_status_log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`record_number`) REFERENCES `tasks` (`record_number`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
