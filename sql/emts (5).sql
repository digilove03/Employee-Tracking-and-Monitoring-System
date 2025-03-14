-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 03:57 AM
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
  `contact_number2` int(11) DEFAULT NULL,
  `landline` int(10) DEFAULT NULL,
  `email_address` varchar(200) NOT NULL,
  `status` enum('Working','On Break','On Leave','Available') NOT NULL DEFAULT 'Available',
  `photo_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `middle_name`, `suffix`, `sex`, `birthdate`, `address`, `religion`, `position`, `department`, `civil_status`, `hiring_date`, `contact_number`, `contact_number2`, `landline`, `email_address`, `status`, `photo_path`, `created_at`) VALUES
(1, 'Lovelynne Heart', 'Tabunlupa', 'Esmaya', '', 'Female', '2024-12-12', 'Brgy. Mohon, Arevalo', '', 'Technician I', 'DASMO', 'Married', '2003-10-25', 2147483647, 947483647, 0, 'lala@gmail.com', 'On Leave', 'emp_profile/Lovelynne Heart_Tabunlupa/5.jpg', '2025-02-13 01:41:13'),
(2, 'Mary Hope', 'Tabunlupa', 'Esmaya', '', 'Female', '2025-02-02', 'Arevalo, Iloilo City', '', 'Technician I', 'DASMO', 'Single', '2001-10-12', 2147483647, 0, 0, 'haha@gmail.com', 'Available', 'emp_profile/Mary Hope_Tabunlupa/405926370_682761940679973_6049967254190273880_n.jpg', '2025-02-13 02:17:44'),
(3, 'Carla Mae', 'Carlos', 'Pa', '', 'Female', '2025-02-12', 'Concepcion, Iloilo', '', 'Intern', 'DASMO', '', '2000-12-10', 2147483647, 0, 0, 'vv@gmail.com', 'Working', 'emp_profile/Carla Mae_Carlos/TABUNLUPA_MARY HOPE.png', '2025-02-13 02:44:35'),
(4, 'Rod Albert', 'Aspera', 'Paw', '', 'Male', '2002-02-02', 'Sara, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Married', '2025-02-02', 2147483647, NULL, NULL, 'rod@gmail.com', 'Working', 'emp_profile/default.png', '2025-02-19 01:26:00'),
(5, 'Jormy Faith', 'Tajanlangit', 'Umahag', '', 'Female', '2002-09-12', 'Jaro, Iloilo City', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-10-01', 2147483647, NULL, NULL, 'jormy@gmail.com', 'Available', 'emp_profile/default.png', '2025-02-19 01:27:42'),
(6, 'Grade', 'Sara', 'Req', '', 'Female', '2002-12-10', 'Oton, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-02-01', 2147483647, NULL, NULL, 'grace@gmail.com', 'On Break', 'emp_profile/Grade_Sara/WIN_20230124_14_40_11_Pro.jpg', '2025-02-19 01:31:38'),
(7, 'Grace', 'Sara', 'Req', '', 'Female', '2002-03-02', 'Oton, Iloilo', 'Christianity', 'Job Hire', 'DASMO', 'Single', '2025-12-12', 2147483647, 0, 0, 'grace.10@gmail.com', 'Available', 'emp_profile/Grace_Sara/3.jpg', '2025-02-19 02:14:54'),
(8, 'Archel', 'Aranda', 'Que', '', 'Female', '2003-04-04', 'Sara, Iloilo', 'Christianity', 'Secretary', 'DASMO', 'Single', '2025-02-01', 2147483647, 0, 0, 'archel@gmail.com', 'Available', 'emp_profile/Archel_Aranda/2.jpg', '2025-02-19 02:17:12'),
(9, 'Ask', 'Santos', 'Hi', '', 'Male', '2003-12-25', 'Brgy. Mohon, Arevalo, Iloilo City', 'Hinduism', 'Job Hire', 'DASMO', 'Divorced', '2025-02-21', 2147483647, 0, 0, 'santos@gmail.com', 'Available', 'emp_profile/Ask_Santos/4.jpg', '2025-02-28 00:50:35'),
(10, 'Ashley', 'Trevino', 'Nunu', '', 'Female', '1977-05-03', 'Molo, Iloilo City', 'Buddhism', 'Technician II', 'DASMO', 'Divorced', '2025-03-02', 2147483647, NULL, NULL, 'ash@gmail.com', 'Available', 'emp_profile/Ashley_Trevino/5.jpg', '2025-03-11 06:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status_log`
--

CREATE TABLE `employee_status_log` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_end` datetime DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_status_log`
--

INSERT INTO `employee_status_log` (`id`, `employee_id`, `status`, `start_time`, `status_end`, `duration`) VALUES
(1, 5, 'On Break', '2025-03-14 01:51:28', '2025-03-14 10:35:07', '00:43:39'),
(2, 7, 'Available', '2025-03-14 02:00:36', NULL, NULL),
(3, 3, 'Working', '2025-03-14 02:01:12', '2025-03-14 10:26:55', '-06:34:17'),
(4, 2, 'Working', '2025-03-14 02:01:38', '2025-03-14 03:26:08', '-06:35:30'),
(5, 8, 'On Leave', '2025-03-14 02:24:34', '2025-03-14 03:24:52', '-06:59:42'),
(6, 8, 'Working', '2025-03-14 02:24:52', '2025-03-14 03:25:31', '-06:59:21'),
(7, 8, 'Available', '2025-03-14 02:25:31', NULL, NULL),
(8, 1, 'Available', '2025-03-14 02:25:47', '2025-03-14 03:28:47', '-06:57:00'),
(9, 2, 'Available', '2025-03-14 02:26:08', NULL, NULL),
(10, 3, 'Available', '2025-03-14 02:26:55', '2025-03-14 03:28:27', '-06:58:28'),
(11, 3, 'On Leave', '2025-03-14 02:28:27', '2025-03-14 10:35:43', '00:07:16'),
(12, 1, 'On Leave', '2025-03-14 02:28:47', NULL, NULL),
(13, 4, 'Working', '2025-03-14 02:29:33', NULL, NULL),
(14, 5, 'Available', '2025-03-14 02:35:07', NULL, NULL),
(15, 3, 'Working', '2025-03-14 02:35:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(12) NOT NULL,
  `employee_id` int(8) NOT NULL,
  `record_number` int(10) UNSIGNED ZEROFILL NOT NULL,
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
  `record_number` int(10) UNSIGNED ZEROFILL NOT NULL,
  `employee_id` int(8) NOT NULL,
  `service` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `role` enum('Main','Assistant','Substitute Supervisor','Substitute Main','Substitute Assistant','Supervisor') NOT NULL,
  `service_status` enum('Ongoing','Completed','Cancelled') NOT NULL DEFAULT 'Ongoing',
  `time_started` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_ended` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deadline` datetime NOT NULL,
  `completion_time` time DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `delay` enum('Yes','No') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`record_number`, `employee_id`, `service`, `location`, `role`, `service_status`, `time_started`, `time_ended`, `deadline`, `completion_time`, `remarks`, `delay`) VALUES
(0000000002, 3, 'Computer Repair', 'CHO', 'Main', 'Completed', '2025-02-27 21:05:57', '2025-03-06 06:32:51', '2025-02-28 13:00:00', '00:00:00', 'No Remarks.', NULL),
(0000000003, 8, 'Change Hardware', 'LEDIPO', 'Main', 'Cancelled', '2025-02-27 22:15:33', '2025-03-06 06:40:50', '2025-02-28 15:00:00', NULL, 'No Remarks.', NULL),
(0000000004, 6, 'Data Recovery', 'PDAO', 'Main', 'Cancelled', '2025-02-27 22:16:37', '2025-03-06 06:47:47', '2025-02-28 14:30:00', '00:00:00', 'No Remarks.', NULL),
(0000000005, 1, 'Change Hardware, Virus/Malware Removal', 'OSCA', 'Main', 'Completed', '2025-03-02 22:48:56', '2025-03-11 06:46:58', '2025-03-03 15:00:00', '00:00:00', 'No Remarks.', NULL),
(0000000006, 4, 'Computer Format', 'CHO', 'Substitute Main', 'Completed', '2025-03-05 17:02:48', '2025-03-06 07:12:14', '2025-03-06 14:00:00', '00:08:49', 'Noice.', NULL),
(0000000007, 9, 'Data Recovery, Change Hardware, Computer Repair, Virus/Malware Removal', 'PDAO', 'Main', 'Completed', '2025-03-06 01:16:40', '2025-03-06 07:10:57', '2025-03-06 12:00:00', '00:03:54', 'No Remarks.', NULL),
(0000000008, 7, 'Data Recovery, Computer Format, Change Hardware', 'PDAO', 'Main', 'Completed', '2025-03-07 08:40:25', '2025-03-07 08:40:55', '2025-03-07 17:00:00', '00:00:00', 'No Remarks.', NULL),
(0000000009, 7, 'Data Recovery, Virus/Malware Removal', 'LEDIPO', 'Main', 'Cancelled', '2025-03-11 06:56:13', '2025-03-11 07:01:43', '2025-03-11 17:00:00', '00:00:05', 'No Remarks.', NULL),
(0000000010, 10, 'Data Recovery', 'PDAO', 'Main', 'Completed', '2025-03-11 07:02:35', '2025-03-12 01:08:45', '2025-03-11 17:00:00', '00:00:00', 'No Remarks.', NULL),
(0000000011, 5, 'Computer Repair', 'DASMO', 'Main', 'Completed', '2025-03-12 06:19:46', '2025-03-12 06:30:14', '2025-03-12 14:30:00', '00:10:28', 'No Remarks.', 'No'),
(0000000012, 9, 'Virus/Malware Removal, Computer Repair', 'DASMO', 'Main', 'Completed', '2025-03-12 06:20:41', '2025-03-12 07:14:53', '2025-03-12 14:30:00', '00:54:12', 'No Remarks.', 'Yes'),
(0000000013, 10, 'Computer Format', 'CHO', 'Main', 'Cancelled', '2025-03-12 06:46:08', '2025-03-12 07:15:19', '2025-03-12 14:00:00', '00:29:11', 'No Remarks.', 'Yes'),
(0000000014, 7, 'Computer Format', 'LEDIPO', 'Main', 'Cancelled', '2025-03-14 01:53:56', '2025-03-14 02:00:36', '2025-03-14 12:00:00', '00:06:40', 'No Remarks.', 'No'),
(0000000015, 3, 'Data Recovery', 'CHO', 'Main', 'Completed', '2025-03-14 02:01:12', '2025-03-14 02:26:55', '2025-03-14 12:00:00', '00:25:43', 'No Remarks.', 'No'),
(0000000016, 4, 'Virus/Malware Removal', 'LEDIPO', 'Main', 'Ongoing', '2025-03-14 02:29:33', NULL, '2025-03-14 12:00:00', NULL, NULL, NULL);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_status_log`
--
ALTER TABLE `employee_status_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `record_number` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_status_log`
--
ALTER TABLE `employee_status_log`
  ADD CONSTRAINT `employee_status_log_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE;

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
