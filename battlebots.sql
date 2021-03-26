-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2021 at 02:47 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `battlebots`
--

-- --------------------------------------------------------

--
-- Table structure for table `livedata`
--

CREATE TABLE `livedata` (
  `type` varchar(255) NOT NULL,
  `json` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `livedata`
--

INSERT INTO `livedata` (`type`, `json`) VALUES
('scheme', '{\"11\":[\"Steen papier schaar Knockout\",\"10:13\",\"ALL\"],\"22\":[\"Doolhof\",\"BOT1\"],\"12\":[\"Race\",\"10:18\",\"BOT3\"],\"23\":[\"Doolhof\",\"BOT2\"],\"13\":[\"Race\",\"10:23\",\"BOT5\"],\"14\":[\"Race\",\"10:28\",\"BOT1\"],\"15\":[\"Race\",\"10:33\",\"BOT4\"],\"16\":[\"Race\",\"10:38\",\"BOT2\"],\"17\":[\"Tekening\",\"10:43\",\"ALL\"],\"18\":[\"Tekening\",\"10:48\",\"ALL\"],\"19\":[\"Tekening\",\"10:53\",\"ALL\"],\"1\":[\"Steen papier schaar\",\"09:23\",\"BOT1\",\"BOT2\"],\"2\":[\"Steen papier schaar\",\"09:28\",\"BOT1\",\"BOT3\"],\"3\":[\"Steen papier schaar\",\"09:33\",\"BOT1\",\"BOT4\"],\"4\":[\"Steen papier schaar\",\"09:38\",\"BOT1\",\"BOT5\"],\"5\":[\"Steen papier schaar\",\"09:43\",\"BOT2\",\"BOT3\"],\"6\":[\"Steen papier schaar\",\"09:48\",\"BOT2\",\"BOT4\"],\"7\":[\"Steen papier schaar\",\"09:53\",\"BOT2\",\"BOT5\"],\"8\":[\"Steen papier schaar\",\"09:58\",\"BOT3\",\"BOT4\"],\"9\":[\"Steen papier schaar\",\"10:03\",\"BOT3\",\"BOT5\"],\"20\":[\"Tekening\",\"10:58\",\"ALL\"],\"10\":[\"Steen papier schaar\",\"10:08\",\"BOT4\",\"BOT5\"],\"21\":[\"Tekening\",\"11:03\",\"ALL\"]}'),
('score', '{\"doolhof\":[{\"ready\":true,\"finished\":true,\"team\":\"BOT1\",\"time\":\"00:00.700\",\"matchId\":21},{\"ready\":true,\"finished\":true,\"team\":\"BOT2\",\"time\":\"00:00.557\",\"matchId\":22}]}');

-- --------------------------------------------------------

--
-- Table structure for table `punten`
--

CREATE TABLE `punten` (
  `game` varchar(255) NOT NULL,
  `robot` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `punten`
--

INSERT INTO `punten` (`game`, `robot`, `score`) VALUES
('doolhof', 'BOT1', 20),
('doolhof', 'BOT2', 25);

-- --------------------------------------------------------

--
-- Table structure for table `resultaat`
--

CREATE TABLE `resultaat` (
  `game` varchar(255) NOT NULL,
  `robot` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `resultaat`
--

INSERT INTO `resultaat` (`game`, `robot`, `score`) VALUES
('doolhof', 'BOT1', '00:00.700'),
('doolhof', 'BOT2', '00:00.557');

-- --------------------------------------------------------

--
-- Table structure for table `speelschema`
--

CREATE TABLE `speelschema` (
  `spel_naam` varchar(100) NOT NULL,
  `robot_1` varchar(100) NOT NULL,
  `robot_2` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `TeamID` varchar(2) NOT NULL,
  `TeamDesc` longtext NOT NULL,
  `RobotName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`TeamID`, `TeamDesc`, `RobotName`) VALUES
('1A', 'Test', 'Test'),
('1B', 'Test', 'Test'),
('1C', 'Test', 'Test'),
('1D', 'Test', 'Test'),
('1E', 'Test', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `team` char(2) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(2) NOT NULL,
  `deleted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `voornaam`, `achternaam`, `team`, `level`, `lang`, `deleted_at`) VALUES
(1, 'Remco', 'test', '', '', NULL, 2, 'nl', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `livedata`
--
ALTER TABLE `livedata`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `punten`
--
ALTER TABLE `punten`
  ADD PRIMARY KEY (`game`,`robot`);

--
-- Indexes for table `resultaat`
--
ALTER TABLE `resultaat`
  ADD PRIMARY KEY (`game`,`robot`);

--
-- Indexes for table `speelschema`
--
ALTER TABLE `speelschema`
  ADD PRIMARY KEY (`spel_naam`),
  ADD KEY `fk_speelschema_spel1_idx` (`spel_naam`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`TeamID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `UserTeam` (`team`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `UserTeam` FOREIGN KEY (`team`) REFERENCES `teams` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
