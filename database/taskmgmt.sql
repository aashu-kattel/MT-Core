-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2024 at 03:38 PM
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
-- Database: `taskmgmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `clocked`
--

CREATE TABLE `clocked` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `timestamps` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clocked`
--

INSERT INTO `clocked` (`id`, `user_id`, `start_datetime`, `end_datetime`, `timestamps`) VALUES
(1, 3, '2024-07-16 14:38:32', '2024-07-16 14:39:13', '2024-07-16 08:53:32'),
(2, 5, '2024-07-16 14:58:09', NULL, '2024-07-16 09:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `timestamps` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `subtitle`, `short_description`, `status`, `timestamps`) VALUES
(5, 3, 'TAsk 1', 'mini task', 'assigned to me ...', 'In Progress', '2024-07-16 08:42:42'),
(6, 3, 'new task', 'new', 'assigned', 'Completed', '2024-07-16 08:49:39'),
(7, 3, 'clock task', 'ck', 'ck', 'Not Started', '2024-07-16 08:53:32'),
(8, 5, '2 task', '22task', '22', 'Completed', '2024-07-16 09:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `online_status` tinyint(1) DEFAULT NULL,
  `timestamps` timestamp NOT NULL DEFAULT current_timestamp(),
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `Password`, `online_status`, `timestamps`, `isAdmin`) VALUES
(2, 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 0, '2024-07-16 11:23:51', 1),
(3, 'user1', 'last name', 'user1@gmail.com', '24c9e15e52afc47c225b757e7bee1f9d', NULL, '2024-07-16 11:24:16', 0),
(5, 'user2', 'user2', 'user2@gmail.com', '7e58d63b60197ceb55a1c487989a3720', NULL, '2024-07-16 11:56:17', 0),
(6, 'user3', 'user3', 'user3@gmail.com', '92877af70a45fd6a2ed7fe81e1236b78', NULL, '2024-07-16 11:56:38', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clocked`
--
ALTER TABLE `clocked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clocked`
--
ALTER TABLE `clocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clocked`
--
ALTER TABLE `clocked`
  ADD CONSTRAINT `clocked_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
