-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 04:08 AM
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
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `department`) VALUES
(1, 'admin', '12345', 'admin.dasmo@gmail.com', 'DASMO'),
(4, 'admin1', 'qwerty', 'admin@dasmo@ilogov.ph', 'DASMO');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(8) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `middle_name` varchar(200) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `sex` enum('Female','Male') NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(500) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(200) NOT NULL,
  `civil_status` enum('Single','Married','Divorced','Seperated','Widowed') NOT NULL,
  `hiring_date` date NOT NULL,
  `contact_number` int(11) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `status` enum('Working','On Break','On Leave','Available') NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `middle_name`, `suffix`, `sex`, `birthdate`, `address`, `religion`, `position`, `department`, `civil_status`, `hiring_date`, `contact_number`, `email_address`, `status`, `photo_path`, `created_at`) VALUES
(1, 'Lovelynne Heart', 'Tabunlupa', 'Esmaya', '', 'Female', '2024-12-12', 'Brgy. Mohon, Arevalo', '', 'Project Manager', 'DASMO', 'Divorced', '2003-10-25', 2147483647, 'lala@gmail.com', 'Working', '', '2025-02-13 01:41:13'),
(2, 'Mary Hope', 'Tabunlupa', 'Esmaya', '', 'Female', '2025-02-02', 'Brgy. Mohon, Arevalo', '', 'Intern', 'DASMO', 'Single', '2001-10-12', 2147483647, 'haha@gmail.com', 'Working', 'emp_profile/Mary Hope_Tabunlupa/405926370_682761940679973_6049967254190273880_n.jpg', '2025-02-13 02:17:44'),
(3, 'Carla Mae', 'Carlos', 'Pa', '', 'Female', '2025-02-12', 'Concepcion, Iloilo', '', 'Intern', 'DASMO', '', '2000-12-10', 2147483647, 'vv@gmail.com', 'Working', 'emp_profile/Carla Mae_Carlos/TABUNLUPA_MARY HOPE.png', '2025-02-13 02:44:35'),
(4, 'Rod Albert', 'Aspera', 'Paw', '', 'Male', '2002-02-02', 'Sara, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Married', '2025-02-02', 2147483647, 'rod@gmail.com', 'Working', 'emp_profile/default.png', '2025-02-19 01:26:00'),
(5, 'Jormy Faith', 'Tajanlangit', 'Umahag', '', 'Female', '2002-09-12', 'Jaro, Iloilo City', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-10-01', 2147483647, 'jormy@gmail.com', 'Working', 'emp_profile/default.png', '2025-02-19 01:27:42'),
(6, 'Grade', 'Sara', 'Req', '', 'Female', '2002-12-10', 'Oton, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-02-01', 2147483647, 'grace@gmail.com', 'Working', 'emp_profile/Grade_Sara/WIN_20230124_14_40_11_Pro.jpg', '2025-02-19 01:31:38'),
(7, 'Grace', 'Sara', 'Req', '', 'Female', '2002-03-02', 'Oton, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-12-12', 2147483647, 'grace.10@gmail.com', 'Working', 'emp_profile/Grace_Sara/WIN_20221203_11_37_27_Pro.jpg', '2025-02-19 02:14:54'),
(8, 'Archel', 'Aranda', 'Que', '', 'Female', '2003-04-04', 'Sara, Iloilo', 'Christianity', 'Secretary', 'DASMO', 'Single', '2025-02-01', 2147483647, 'archel@gmail.com', 'Working', 'emp_profile/Archel_Aranda/WIN_20221203_11_37_32_Pro.jpg', '2025-02-19 02:17:12');

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
  `role` varchar(25) NOT NULL,
  `service_status` enum('Ongoing','Completed','Cancelled') NOT NULL DEFAULT 'Ongoing',
  `time_started` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_ended` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deadline` datetime NOT NULL,
  `completion_time` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`record_number`, `employee_id`, `service`, `location`, `role`, `service_status`, `time_started`, `time_ended`, `deadline`, `completion_time`, `remarks`) VALUES
('', 2, 'Data Recovery, Printer Setup', 'CHO', 'main', 'Ongoing', '2025-02-18 00:54:51', '2025-02-18 08:54:51', '2025-02-18 17:00:00', NULL, NULL),
('67b58f15c3a05', 8, 'Virus/Malware Removal', 'LEDIPO', 'main', 'Ongoing', '2025-02-18 23:58:13', NULL, '2025-02-19 17:00:00', NULL, NULL),
('67b591897ca30', 3, 'Router Setup', 'CTO', 'main', 'Ongoing', '2025-02-19 00:08:41', NULL, '2025-02-19 17:00:00', NULL, NULL),
('hjkg45465', 3, 'Computer Repair, Computer Upgrade', 'City Health Office', 'main', 'Ongoing', '2025-02-16 23:17:14', '2025-02-17 07:17:14', '2025-02-17 06:05:00', NULL, NULL);

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
  ADD PRIMARY KEY (`id`) KEY_BLOCK_SIZE=8,
  ADD UNIQUE KEY `unique_email` (`email_address`);

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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
