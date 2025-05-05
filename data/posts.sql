-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2025 at 04:34 PM
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
-- Database: `jianga42_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `ovation` float NOT NULL DEFAULT 0,
  `price` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `username`, `title`, `content`, `date`, `ovation`, `price`, `stock`) VALUES
(16, 'testing', 'test image', 'test test ttes tst st t g4eroij', '2025-04-08 16:37:14', 0, NULL, NULL),
(19, 'ameyag', 'napoleon', 'this painting kinda 🔥', '2025-04-12 10:08:58', 0, NULL, NULL),
(29, 'azeen', 'no image', 'no wares', '2025-04-12 10:16:14', 0, NULL, NULL),
(31, 'ameyag', 'image and wares', 'so many wares', '2025-04-12 10:18:25', 0, 1, 12),
(39, 'ameyag', 'more posts for me', 'yum', '2025-04-12 10:28:21', 0, 12, 12),
(40, 'testing', 'another post', 'help', '2025-04-12 10:29:07', 0, 1, 1),
(41, 'testing', 'MOREEE', 'joiegrejiorgegorij', '2025-04-12 10:29:18', 0, NULL, NULL),
(43, 'ameyag', 'More posts', 'more', '2025-04-12 10:32:34', 0, 12, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
