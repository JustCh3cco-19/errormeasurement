-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 08:33 PM
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
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `username`, `email`, `password`, `user_type`) VALUES
(1, 'Francesco', 'f.zompanti@gmail.com', 'e8916a05f86514473d6b4dd6a541e39b', 'user'),
(2, 'Gianni', 'ciaociao@gmail.com', '$2y$10$yf.jhvs5VHlM9CObdD1/YuTm8Dglco4po0xKxE3ker7TjD29dNmgm', 'user'),
(3, 'Harold', 'harold@gmail.com', '$2y$10$qnVJfRmHQy8K13SYnVkyvuLkdqAXp.6m5vg0I2AXos4KOcRNmfKwS', 'user'),
(4, 'Francescopo', 'lucarossi@gmail.com', '$2y$10$9G2c4j2AjWAMPwJcaaRz0OSDiG3bIxegQoqU.oCHliSD/7aQtpWDi', 'user'),
(5, 'Leopoldo', 'leo@gmail.com', '$2y$10$ZmvP46jyOQhO/.xlQuhcTu37K0hdTjRSLxFB84fKwUNaVHcCX2rIu', 'user'),
(8, 'dbsvjbsdjkvbik', 'provaprovapr@gmail.com', '$2y$10$MFDuJjFZk7d9HZb2QBnBC.wvSCwzVq/ps8/QN0Hwr3lB53Fv8eSbS', 'user'),
(9, 'admin', 'ass@gmail.com', '$2y$10$VGJmroZ07r8d9sYKlY9A5e41xaQVISUkbQQvYO/A8.J/J6RVDYTFq', 'user'),
(17, 'Andrea ', 'andrea@gmail.com', '$2y$10$hStelLQWCTNwWN9sagBbeuvOlqWeR8sYdZc6Fh2w5yb9kjLxb1fMK', 'user'),
(20, 'Test', 'test@gmail.com', '$2y$10$7/sR4eEcqzO/3FDaKPWQWeyHLjpWY3EGguFNq7Boi6CyQ7Ooc8MN6', 'user'),
(21, 'ciao', 'cacacacaca@hotmail.com', '$2y$10$zWx91Z95fn2Vd/s4Oo9DnOxlSeaWL9NPI1IMCFQh634BI1BxIb2zm', 'user'),
(23, 'jusaaa', 'f.za@gmail.com', '$2y$10$vc6nOtDb6z/aMwcCprd6RedvPby.T3s1FcWslKHF6azLjssXC0Uvq', 'user'),
(24, 'loop', 'loop@gmail.com', '$2y$10$qEXXxLdNPTM5D.9Gfgqguu3/O9TEOpE/2FDNPIm3Gxj.O/fvMc/42', 'user'),
(26, 'Elio', 'elio.zompanti@gmail.com', '$2y$10$XePGhX7SPtLu846zOJCz7e1DRQOir.c2dKpTWOjWlpMXzTAAiNEzW', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD UNIQUE KEY `name` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
