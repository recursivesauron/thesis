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
(1, 'Smitty Werbenjagermanjensen', 'You are #1 (in the leaderboard)', 'a', 0, './images/7.png'),
(2, 'Expert Steward', 'Reach 500 Points!', 'a', 500, './images/pts3.png'),
(3, 'Master Steward', 'Reach 1000 Points!', 'a', 1000, './images/pts2.png'),
(4, 'Grand Master Steward', 'Reach 2500 Points!', 'a', 2500, './images/pts1.png'),
(5, 'Save the bees!', 'Make a Bee habitat', 'r', 0, './images/1.png'),
(6, 'Reduced, Reused, Recycled', 'Reduce wasted produced from an entire week into the volume of a mason jar', 'r', 0, './images/3.png'),
(7, 'Home Grown', 'Only buy food from Ontario for a whole week ', 'r', 0, './images/2.png'),
(8, 'My Magic Shoes', 'Don''t use a motorized vehicle for a whole week', 'r', 0, './images/4.png'),
(9, 'The Perfect Temp', 'Avoid using heat or air conditioning for a whole week', 'r', 0, './images/5.png'),
(10, 'From the Source', 'Only drink local water for a whole week (no water bottles or other drinks)', 'r', 0, './images/6.png');

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

INSERT INTO `community_habits` VALUES
(1, 'Recycle Cans', 'Remember to recycle my pop cans', 5),
(2, 'Turn off the lights', 'Don''t forget to turn off the lights when leaving for work', 5),
(3, 'Shut off monitors', 'Remember to shut off computer monitors before going to bed, or when leaving desk for a few minutes', 5),
(4, 'Brush teeth with tap off', 'Don''t leave the tap running when brushing my teeth', 10),
(5, 'Do laundry with cold water', 'Use cold water detergent if needed, and wash laundry in the cold cycle', 15);
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
(1, 'Don''t have a cow', 'Avoid eating beef and dairy for today', 125),
(2, 'Powered By the People', 'Walk, bike, or use group transportation today', 125),
(3, 'Quick Shower', 'Make today''s shower no more than 5 minutes', 125),
(4, 'Don''t run the tap', 'Avoid leaving the tap running when you don''t need to', 100),
(5, 'Clean More with Less', 'Soak your dishes in a small amount of water instead of running the tap', 100),
(6, 'Fix that leak!', 'Check your pipes at home for leaks (and fix them)', 175),
(7, 'The ''Rain'' Bucket', 'Put a bucket under your shower faucet, and reuse the water it catches', 200),
(8, 'Cooler than Cool', 'Avoid using hot water today', 200),
(9, 'Powered Down', 'Turn off all electronics when not in use', 100),
(10, 'Find the Phantoms', 'Find stray chargers, or electronics on standby and unplug them', 150),
(11, 'AFK', 'Avoid unnecessary computer/internet use today', 100),
(12, 'Nothing Beats a Knee Blanket', 'Avoid using heaters or fans today', 100),
(13, 'On Tap Special', 'Don''t buy any bottled liquids today', 100),
(14, 'A Snappy Container', 'Use a reusable food storage container today', 100),
(15, 'Even Ate the Veggies', 'Don''t throw away any edible food scraps today', 100),
(16, 'Brought my bags', 'Use reusable shopping bags instead of plastic ones (counts for whole week)', 125),
(17, 'Trash Filter', 'Recycle 5 different things today', 100),
(18, 'Sign me Up', 'Support an environmental petition', 150),
(19, 'Part of the Club', 'Join an environmental action club (or look into starting one!)', 200),
(20, 'Cooking Cold Turkey', 'Eat meals prepared without use of a stove or oven today', 100),
(21, 'I Stepped Up', 'Avoid using elevators or escalators today', 125),
(22, 'Action Stems Change', 'Plant a tree, or house a small plant', 200),
(23, 'Electronic Scrap', 'Sort through old electronics and recycle them at the depot', 200);

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
('ryant', '$2a$10$Ekbc/CXmkEs.V45LZYp7WOD52TC1CDetL3R414oWvzOpwcOjUjWae');

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
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tasks`
--

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
(1, 'ryant', 0, 0);

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
(1, 5, 0),
(1, 6, 0),
(1, 7, 0),
(1, 8, 0),
(1, 9, 0),
(1, 10, 0);

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
CREATE DEFINER=`root`@`localhost` EVENT `daily_refresh_event` ON SCHEDULE EVERY 24 HOUR STARTS '2016-10-22 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Calls daily refresh' DO CALL daily_refresh()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
