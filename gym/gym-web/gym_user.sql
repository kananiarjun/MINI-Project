-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 03:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$/P5uc10wyz.mFtuwynCQC.aEV/RhIUMO7ObQ/Ej7rT7M68xeG4oAu', 'admin@example.com'),
(2, 'gymadmin', '$2y$10$qnA3w8Vz55t0rsWs4Fs6rONeJHdAhEvVUibm3i1Met1Jfj2Blgb.G', 'gymsupport@gmail.com'),
(3, 'admin23', '$2y$10$6KZk5IVCzBbB.NmPxxXjM.SGZVz3kEReWdn59i5zBdgFK36FRXtTW', 'gymsupportcentre@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `SR_NO` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `card_number` int(16) NOT NULL,
  `expiry` varchar(16) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `plan_price` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `monday` varchar(50) DEFAULT NULL,
  `tuesday` varchar(50) DEFAULT NULL,
  `wednesday` varchar(50) DEFAULT NULL,
  `thursday` varchar(50) DEFAULT NULL,
  `friday` varchar(50) DEFAULT NULL,
  `saturday` varchar(50) DEFAULT NULL,
  `sunday` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `user`, `time`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(1, '', '06:00:00', 'boxing', 'fitness', 'yoga', 'fitness', 'boxing', 'boxing', ''),
(2, '', '06:00:00', 'cardio', '', 'weight_loss', '', 'yoga', '', ''),
(3, 'demo7', '06:00:00', 'cardio', 'fitness', 'fitness', 'boxing', 'weight_loss', 'cardio', 'Rest Day');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `sr_no` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pass` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL,
  `b_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`sr_no`, `uname`, `pass`, `email`, `b_date`) VALUES
(1, 'pr1', '$2y$10$wTbz1AjVzesmLGtKqQ784.fzvt1HPRg2jZreik14vE.Psc4rokcnq', 'kunal@gmail.com', '1999-02-03'),
(2, 'demo7', '$2y$10$Qz9jy4kT1tPnJu34pTiG2OWsctiIJs8aujvoA4Fd3X0/JWA2ALb86', 'demo30@gmail.com', '2015-02-08'),
(3, 'James', '$2y$10$R2q9PkNWXm24BWNWP45QTe0jK1ipJzJTu5KS2GKu1110YwlvB8Xci', 'james@gmail.com', '2001-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback`
--

CREATE TABLE `user_feedback` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `comment` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_types`
--

CREATE TABLE `workout_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_types`
--

INSERT INTO `workout_types` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Boxing', NULL, '2025-03-20 14:19:26'),
(2, 'Yoga', NULL, '2025-03-20 14:19:26'),
(3, 'Cardio', NULL, '2025-03-20 14:19:26'),
(4, 'Fitness', NULL, '2025-03-20 14:19:26'),
(5, 'Weight Loss', NULL, '2025-03-20 14:19:26'),
(6, 'Boxing', NULL, '2025-03-21 02:58:11'),
(7, 'Yoga', NULL, '2025-03-21 02:58:11'),
(8, 'Cardio', NULL, '2025-03-21 02:58:11'),
(9, 'Fitness', NULL, '2025-03-21 02:58:11'),
(10, 'Weight Loss', NULL, '2025-03-21 02:58:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`SR_NO`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `workout_types`
--
ALTER TABLE `workout_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `SR_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_feedback`
--
ALTER TABLE `user_feedback`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `workout_types`
--
ALTER TABLE `workout_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
