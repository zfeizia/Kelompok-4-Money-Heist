-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 10:44 PM
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
-- Database: `money_heist`
--

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `crew_count` int(11) DEFAULT NULL,
  `strategy` text DEFAULT NULL,
  `current_phase` enum('Planning','Execution','Negotiation','Escape') DEFAULT 'Planning',
  `status_mission` enum('Active','Completed','Failed') DEFAULT 'Active',
  `option_a_text` varchar(255) DEFAULT 'Menunggu Instruksi...',
  `option_b_text` varchar(255) DEFAULT 'Menunggu Instruksi...',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `planning_a` text DEFAULT NULL,
  `planning_b` text DEFAULT NULL,
  `execution_a` text DEFAULT NULL,
  `execution_b` text DEFAULT NULL,
  `negotiation_a` text DEFAULT NULL,
  `negotiation_b` text DEFAULT NULL,
  `escape_a` text DEFAULT NULL,
  `escape_b` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `title`, `location`, `crew_count`, `strategy`, `current_phase`, `status_mission`, `option_a_text`, `option_b_text`, `created_at`, `planning_a`, `planning_b`, `execution_a`, `execution_b`, `negotiation_a`, `negotiation_b`, `escape_a`, `escape_b`) VALUES
(3, 'operasi Bank indonesia', 'bank indonesia, jakarta', 3, 'MENCURI DENGAN HATI HATI', 'Planning', 'Active', 'Menunggu Instruksi...', 'Menunggu Instruksi...', '2025-12-15 21:13:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mission_logs`
--

CREATE TABLE `mission_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `phase` varchar(20) DEFAULT NULL,
  `choice` char(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codename` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('professor','crew') DEFAULT 'crew',
  `avatar` varchar(50) DEFAULT 'tokyo.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `codename`, `password`, `role`, `avatar`) VALUES
(1, 'professor@heist.com', 'PROFESSOR', 'admint', 'professor', 'professor.png'),
(11, 'TOKYO@HEIST.COM', 'TOKYO', '123', 'crew', 'tokyo-face.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mission_logs`
--
ALTER TABLE `mission_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mission_logs`
--
ALTER TABLE `mission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
