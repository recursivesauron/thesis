-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2016 at 04:49 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thesis`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `daily_refresh`()
BEGIN
	DECLARE done int DEFAULT 0;
	DECLARE userId int;

	/*for each user, give 3 random dailies that aren't still in their completed list*/
	DECLARE user_cursor CURSOR FOR 
		SELECT user_id FROM users;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

	DELETE FROM user_complete_dailies WHERE DATE(completed) < DATE(DATE_SUB(NOW(), INTERVAL 3 DAY));
	DELETE FROM user_active_dailies WHERE daily_id >= 1;

	

	OPEN user_cursor;
	FETCH user_cursor INTO userId;
	
	set_dailies: LOOP
		IF done THEN
			LEAVE set_dailies;
		END IF;

		INSERT INTO user_active_dailies (SELECT DISTINCT userId, daily_id FROM dailies WHERE daily_id NOT IN (SELECT daily_id FROM user_complete_dailies WHERE user_id = userId) ORDER BY RAND() LIMIT 3);
		
		FETCH user_cursor INTO userId;
	END LOOP set_dailies;
	CLOSE user_cursor;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `achievement_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` char(1) NOT NULL,
  `requirement` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`achievement_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`achievement_id`, `name`, `description`, `type`, `requirement`, `image_path`) VALUES
(1, 'Smitty Werbenjagermanjensen', 'You are #1', 'a', 0, './images/meat boy.jpg'),
(2, 'Stage 1 Points', 'Reached 500 Points!', 'a', 500, './images/borderlands.jpg'),
(3, 'Stage 2 Points', 'Reached 1000 Points!', 'a', 1000, './images/gwent.jpg'),
(4, 'Stage 3 Points', 'Reached 2500 Points!', 'a', 2500, './images/meat boy.jpg'),
(5, 'TEST ACHIEVEMENT', 'TESTING STUFF', 'r', 100, './images/rocket-league.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `community_habits`
--

CREATE TABLE IF NOT EXISTS `community_habits` (
  `community_habit_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `karma_points` int(11) NOT NULL,
  PRIMARY KEY (`community_habit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `community_habits`
--

INSERT INTO `community_habits` (`community_habit_id`, `title`, `description`, `karma_points`) VALUES
(3, 'uluru', 'test', 10),
(4, 'ULURURU', 'ocean man', 10),
(5, 'ULLULULULULULURU', 'ocean man take me by the hand to the land that you understand', 7),
(8, 'TEST', 'uluru', 10),
(9, 'moonmoon', 'reinhardt', 3),
(10, 'test', 'ululululluru', 10),
(11, 'test habit', 'ululululullullur', 5),
(12, 'NEW HABIT', 'asdfadf', 10),
(13, 'boom', 'nailed it', 10),
(14, 'heyo', 'le mayo', 7),
(15, 'new habit', 'recycle empty cans', 5),
(16, 'Tree planting', 'planted trees for 20 minutes', 10),
(17, 'Recycle cans', 'sample desc', 10);

-- --------------------------------------------------------

--
-- Table structure for table `dailies`
--

CREATE TABLE IF NOT EXISTS `dailies` (
  `daily_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `karma_points` int(11) NOT NULL,
  PRIMARY KEY (`daily_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `dailies`
--

INSERT INTO `dailies` (`daily_id`, `title`, `description`, `karma_points`) VALUES
(1, 'Lone driver', 'Carpool, take public transport, or walk to get around today', 75),
(2, 'One Bottle', 'Reuse a bottle for the whole day, don''t buy any liquids in a different bottle.', 50),
(3, 'Mind the Lights', 'Turn off any lights you don''t need to use today', 50),
(4, 'TEST 1', 'DESC 1', 75),
(5, 'TEST 2', 'DESC 2', 50),
(6, 'TEST 3', 'DESC 3', 50);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('ryant', '$2a$10$Ekbc/CXmkEs.V45LZYp7WOD52TC1CDetL3R414oWvzOpwcOjUjWae'),
('sample', '$2a$10$f6l/9QcL63eQVliha6JwIOhCFPPfGiyIjO.mxITXNJP2Hngz7DSGq');

-- --------------------------------------------------------

--
-- Table structure for table `login_tracking`
--

CREATE TABLE IF NOT EXISTS `login_tracking` (
  `ip` varchar(20) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `blockUntil` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_tracking`
--

INSERT INTO `login_tracking` (`ip`, `lastLogin`, `blockUntil`) VALUES
('::1', '2016-06-26 12:35:20', '2016-06-26 01:35:20'),
('::1', '2016-06-26 12:35:40', '2016-06-26 01:35:40'),
('::1', '2016-06-26 12:35:55', '2016-06-26 01:35:55'),
('208.96.82.127', '2016-07-13 09:19:27', '2016-07-13 10:19:27'),
('208.96.82.127', '2016-07-13 09:19:43', '2016-07-13 10:19:43'),
('208.96.82.127', '2016-07-13 09:19:57', '2016-07-13 10:19:57'),
('208.96.82.127', '2016-07-13 09:20:05', '2016-07-13 10:20:05'),
('208.96.82.127', '2016-07-13 09:20:33', '2016-07-13 10:20:33'),
('208.96.82.127', '2016-07-13 09:20:46', '2016-07-13 10:20:46'),
('::1', '2016-09-24 04:11:04', '2016-09-24 05:11:04'),
('::1', '2016-10-12 03:49:38', '2016-10-12 04:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `karma_points` int(11) NOT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`task_id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `user_id`, `title`, `description`, `karma_points`, `is_complete`) VALUES
(3, 1, 'What up task', 'asdf', 10, 0),
(4, 1, 'test', 'sample text', 10, 0),
(5, 8, 'Sample task', 'desc', 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(30) NOT NULL,
  `opt_out` tinyint(1) NOT NULL DEFAULT '0',
  `karma_points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `alias`, `opt_out`, `karma_points`) VALUES
(1, 'ryant', 0, 490),
(2, 'test', 0, 99),
(8, 'sample', 0, 490);

-- --------------------------------------------------------

--
-- Table structure for table `user_active_achievements`
--

CREATE TABLE IF NOT EXISTS `user_active_achievements` (
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `is_tracked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`achievement_id`),
  KEY `achievement_id` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_active_achievements`
--

INSERT INTO `user_active_achievements` (`user_id`, `achievement_id`, `is_tracked`) VALUES
(1, 1, 0),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(8, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_active_dailies`
--

CREATE TABLE IF NOT EXISTS `user_active_dailies` (
  `user_id` int(11) NOT NULL,
  `daily_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`daily_id`),
  KEY `daily_id` (`daily_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_active_dailies`
--

INSERT INTO `user_active_dailies` (`user_id`, `daily_id`) VALUES
(8, 2),
(1, 3),
(2, 3),
(2, 4),
(1, 5),
(2, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_complete_achievements`
--

CREATE TABLE IF NOT EXISTS `user_complete_achievements` (
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `time_completed` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`achievement_id`),
  KEY `achievement_id` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_complete_dailies`
--

CREATE TABLE IF NOT EXISTS `user_complete_dailies` (
  `user_id` int(11) NOT NULL,
  `daily_id` int(11) NOT NULL,
  `completed` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`daily_id`),
  KEY `daily_id` (`daily_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_complete_dailies`
--

INSERT INTO `user_complete_dailies` (`user_id`, `daily_id`, `completed`) VALUES
(8, 1, '2016-10-12 15:58:52'),
(8, 3, '2016-10-15 20:15:27'),
(8, 4, '2016-10-12 15:59:36'),
(8, 5, '2016-10-12 15:59:33'),
(8, 6, '2016-10-12 15:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_habits`
--

CREATE TABLE IF NOT EXISTS `user_habits` (
  `user_id` int(11) NOT NULL,
  `community_habit_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `karma_points` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`community_habit_id`),
  KEY `community_habit_id` (`community_habit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_habits`
--

INSERT INTO `user_habits` (`user_id`, `community_habit_id`, `title`, `description`, `karma_points`) VALUES
(1, 12, 'WWWWWWWWWW WWWWWWWWWW', 'asdfadf', 10),
(1, 14, 'heyo', 'le mayo', 7),
(1, 17, 'Recycle boxes', 'sample desc', 10),
(8, 3, 'uluru', 'test', 10),
(8, 4, 'ULURURU', 'ocean man', 10);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_active_achievements`
--
ALTER TABLE `user_active_achievements`
  ADD CONSTRAINT `user_active_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_active_achievements_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`achievement_id`);

--
-- Constraints for table `user_active_dailies`
--
ALTER TABLE `user_active_dailies`
  ADD CONSTRAINT `user_active_dailies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_active_dailies_ibfk_2` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`daily_id`);

--
-- Constraints for table `user_complete_achievements`
--
ALTER TABLE `user_complete_achievements`
  ADD CONSTRAINT `user_complete_achievements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_complete_achievements_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`achievement_id`);

--
-- Constraints for table `user_complete_dailies`
--
ALTER TABLE `user_complete_dailies`
  ADD CONSTRAINT `user_complete_dailies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_complete_dailies_ibfk_2` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`daily_id`);

--
-- Constraints for table `user_habits`
--
ALTER TABLE `user_habits`
  ADD CONSTRAINT `user_habits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_habits_ibfk_2` FOREIGN KEY (`community_habit_id`) REFERENCES `community_habits` (`community_habit_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `daily_refresh_event` ON SCHEDULE EVERY 1 MINUTE STARTS '2016-10-22 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Calls daily refresh' DO CALL daily_refresh()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
