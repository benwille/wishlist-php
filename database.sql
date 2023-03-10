-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2023 at 03:22 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `wishlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `street`, `city`, `state`, `zip`) VALUES
(1, '11403 S Skylux Ave', 'South Jordan', 'UT', '84009'),
(2, '1167 E Murray Holladay Rd #9', 'Salt Lake City', 'Utah', '84017');

-- --------------------------------------------------------

--
-- Table structure for table `address_meta`
--

CREATE TABLE `address_meta` (
  `meta_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address_meta`
--

INSERT INTO `address_meta` (`meta_id`, `address_id`, `user_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(5, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `exchange`
--

CREATE TABLE `exchange` (
  `id` int(11) NOT NULL,
  `year` int(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exchange`
--

INSERT INTO `exchange` (`id`, `year`, `user_id`, `match_id`) VALUES
(13, 2022, 2, 4),
(14, 2022, 1, 5),
(15, 2022, 6, 3),
(16, 2022, 7, 2),
(17, 2022, 8, 1),
(18, 2022, 5, 6),
(19, 2022, 4, 8),
(20, 2022, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` int(11) NOT NULL,
  `family_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `description` text,
  `link` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `year_added` int(4) DEFAULT NULL,
  `purchased` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `list`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `family` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `family`, `email`, `username`, `hashed_password`, `type`, `is_admin`) VALUES
(1, 'Ben', 'Wille', NULL, 'ben.wille@gmail.com', 'bwille', '$2y$10$f91AWvXMa0IIGm6Zwz4xW.y0zeMvx1NHEyB6qsQ3zH/oKPTefKrxG', 1, 1),
(2, 'Xandra', 'Wille', NULL, 'xandra.wille@gmail.com', 'xandra', NULL, 1, 0),
(3, 'Jessica', 'Peterson', NULL, NULL, 'jessica', NULL, 1, 0),
(4, 'Victoria', 'Olson', NULL, NULL, 'victoria', NULL, 1, 0),
(5, 'Danny', 'Jorgensen', NULL, NULL, 'danny', '$2y$10$atOZNcT4RLrvRYYo/qPI6ef4/BKoTTobpNW97o.HkRgMu4c6Wxmvq', NULL, 0),
(6, 'Chip', 'Reichanadter', NULL, NULL, 'choochie', '$2y$10$mmfPfYGys60BWEH/NP55TOle2D3rFhv.gQTk1PmyTP40csCJyH49W', NULL, 0),
(7, 'Chad', 'Reichanadter', NULL, NULL, 'chad', '$2y$10$Pu9/4B.iD3EaxlFUGtHrwuRSXk5fHgld1db2QCSav/zUD8nubQmhW', NULL, 0),
(8, 'Katie', 'Jorgensen', NULL, NULL, 'katie', '$2y$10$528zolpbTpsDurrJu1e99eiBbcGydeDLFE/JTQVZrn28hYULtjH1K', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address_meta`
--
ALTER TABLE `address_meta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `fk_address` (`address_id`),
  ADD KEY `fk_user_address` (`user_id`);

--
-- Indexes for table `exchange`
--
ALTER TABLE `exchange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_family` (`family`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `address_meta`
--
ALTER TABLE `address_meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exchange`
--
ALTER TABLE `exchange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_meta`
--
ALTER TABLE `address_meta`
  ADD CONSTRAINT `fk_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_address` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_family` FOREIGN KEY (`family`) REFERENCES `families` (`id`) ON UPDATE NO ACTION;