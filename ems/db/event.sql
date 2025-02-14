-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2017 at 12:54 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `eve_avai_date`
--

CREATE TABLE IF NOT EXISTS `eve_avai_date` (
  `ava_id` int(15) NOT NULL AUTO_INCREMENT,
  `event_id` int(20) NOT NULL,
  `ava_start_time` datetime NOT NULL,
  `ava_end_time` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ava_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `eve_avai_date`
--

INSERT INTO `eve_avai_date` (`ava_id`, `event_id`, `ava_start_time`, `ava_end_time`, `create_date`) VALUES
(1, 4, '2017-09-22 07:00:00', '2017-09-22 15:00:00', '2017-09-19 07:28:48'),
(2, 6, '2017-10-12 07:00:00', '2017-10-12 13:30:00', '2017-09-20 06:12:16'),
(3, 6, '2017-09-23 08:30:00', '2017-09-23 09:00:00', '2017-09-20 06:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `eve_booking`
--

CREATE TABLE IF NOT EXISTS `eve_booking` (
  `booking_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `person` int(20) NOT NULL,
  `booking_date` date NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `eve_booking`
--

INSERT INTO `eve_booking` (`booking_id`, `user_id`, `event_id`, `person`, `booking_date`, `create_date`) VALUES
(1, 6, 3, 3, '2017-09-19', '2017-09-19 10:23:53'),
(2, 6, 4, 7, '2017-09-19', '2017-09-19 10:37:21'),
(3, 6, 6, 200, '2017-09-20', '2017-09-20 06:13:54'),
(4, 6, 3, 8, '2017-09-20', '2017-09-20 06:47:30'),
(5, 6, 3, 1, '2017-09-20', '2017-09-20 06:47:46'),
(6, 6, 4, 343, '2017-09-20', '2017-09-20 10:24:17'),
(7, 6, 5, 110, '2017-09-20', '2017-09-20 10:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `eve_component`
--

CREATE TABLE IF NOT EXISTS `eve_component` (
  `component_id` int(11) NOT NULL AUTO_INCREMENT,
  `component_name` varchar(250) NOT NULL,
  PRIMARY KEY (`component_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eve_config`
--

CREATE TABLE IF NOT EXISTS `eve_config` (
  `co_id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(20) NOT NULL,
  `co_logo` varchar(255) NOT NULL,
  `co_image` varchar(255) NOT NULL,
  `co_mobile` varchar(25) NOT NULL,
  `co_website` varchar(255) NOT NULL,
  `co_direction` text NOT NULL,
  `co_open_hours` varchar(255) NOT NULL,
  `co_about` text NOT NULL,
  `co_general` text NOT NULL,
  `fb_link` text NOT NULL,
  `gg_link` text NOT NULL,
  `tw_link` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_desc` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`co_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `eve_config`
--

INSERT INTO `eve_config` (`co_id`, `event_id`, `co_logo`, `co_image`, `co_mobile`, `co_website`, `co_direction`, `co_open_hours`, `co_about`, `co_general`, `fb_link`, `gg_link`, `tw_link`, `meta_title`, `meta_keyword`, `meta_desc`, `create_date`) VALUES
(1, 4, '1.png', '1.jpg', '+91 99791 05467', 'http://rudleo.com/', 'direction ', 'Moday to Saturday 8:00am To 7:00pm', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum ', 'https://www.facebook.com/', 'https://plus.google.com/discover', 'https://twitter.com/', '', '', '', '2017-09-09 06:48:31'),
(2, 3, '2.png', '2.jpg', '+91 99791 05467', 'http://rudleo.com/', 'kk ', 'Moday to Saturday 8:00am To 7:00pm', 'lllll', 'oooo', 'https://www.facebook.com/', 'https://plus.google.com/discover', 'https://twitter.com/', 'Event Title', 'Event , Keyword,', 'Event Description for your event''s description', '2017-09-19 11:39:37'),
(3, 5, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2017-09-19 12:28:54'),
(4, 6, '4.png', '4.jpg', '9601261768', 'http://rudleo.com/', 'hfkj', '10:00 AM', 'dfdf', 'dfg', 'https://www.facebook.com/', 'https://plus.google.com/discover', 'https://twitter.com/', 'Event Solution', 'garvi gujarat', 'avajo gujrat', '2017-09-20 06:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `eve_customer`
--

CREATE TABLE IF NOT EXISTS `eve_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_first_name` varchar(100) DEFAULT NULL,
  `customer_last_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_password` varchar(500) DEFAULT NULL,
  `customer_birthdate` date DEFAULT '0000-00-00',
  `customer_gender` enum('Male','Female') DEFAULT 'Male',
  `customer_address` varchar(500) DEFAULT NULL,
  `customer_city` varchar(100) DEFAULT NULL,
  `customer_state` varchar(100) DEFAULT NULL,
  `customer_zipcode` char(10) DEFAULT NULL,
  `customer_country` varchar(100) DEFAULT NULL,
  `customer_phone` char(255) DEFAULT NULL,
  `customer_is_active` char(3) DEFAULT 'yes',
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_logged_in` char(1) NOT NULL DEFAULT '0' COMMENT '0=n,1=y',
  `login_date_time` datetime NOT NULL,
  `logout_date_time` datetime NOT NULL,
  `isFirstTime` varchar(255) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `eve_customer`
--

INSERT INTO `eve_customer` (`customer_id`, `customer_first_name`, `customer_last_name`, `customer_email`, `customer_password`, `customer_birthdate`, `customer_gender`, `customer_address`, `customer_city`, `customer_state`, `customer_zipcode`, `customer_country`, `customer_phone`, `customer_is_active`, `create_date`, `is_logged_in`, `login_date_time`, `logout_date_time`, `isFirstTime`) VALUES
(6, 'mehul patel', NULL, 'mehul@gmail.com', '123', '0000-00-00', 'Male', 'Amreli', 'rajkot', NULL, '360001', NULL, '9601261768', 'yes', '2017-09-09 05:23:24', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(9, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-14 09:23:13', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(10, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-14 09:23:51', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(11, 'Mehul Thummar', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '1234567890', 'yes', '2017-09-14 09:27:27', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(12, 'first service', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-14 09:31:50', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(13, 'Mehul Thummar', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:02:56', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(14, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:03:55', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(15, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:04:41', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(16, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:06:04', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(17, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:07:34', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(18, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:08:19', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(19, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:14:10', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(20, 'Mehul Patel', NULL, 'mehul@patel.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-15 10:16:10', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(21, 'Mehul Thummar', NULL, 'mehulthummar44@gmail.com', NULL, '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, '9601261768', 'yes', '2017-09-16 05:08:04', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `eve_event`
--

CREATE TABLE IF NOT EXISTS `eve_event` (
  `event_id` int(20) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_add` text NOT NULL,
  `event_date` date NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `event_person` int(20) NOT NULL,
  `event_is_active` enum('yes','no') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `eve_event`
--

INSERT INTO `eve_event` (`event_id`, `event_name`, `event_add`, `event_date`, `event_image`, `event_person`, `event_is_active`, `create_date`) VALUES
(3, 'first event', 'first event', '2017-09-19', '3.jpg', 12, 'yes', '2017-09-19 06:26:00'),
(4, 'second event', 'second event', '2017-09-22', '6.jpg', 350, 'yes', '2017-09-19 06:49:43'),
(5, 'thired event', 'thired event', '2017-09-23', '5.jpg', 120, 'yes', '2017-09-19 12:28:54'),
(6, 'forth event', 'rajkot', '2017-10-28', '6.jpg', 200, 'yes', '2017-09-20 06:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `eve_host`
--

CREATE TABLE IF NOT EXISTS `eve_host` (
  `host_id` int(20) NOT NULL AUTO_INCREMENT,
  `host_name` text NOT NULL,
  `host_user_name` text NOT NULL,
  `host_user_pass` text NOT NULL,
  PRIMARY KEY (`host_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `eve_host`
--

INSERT INTO `eve_host` (`host_id`, `host_name`, `host_user_name`, `host_user_pass`) VALUES
(1, 'webmail.rudleobulksms.in', 'cloud@rudleobulksms.in', 'cloud@123');

-- --------------------------------------------------------

--
-- Table structure for table `eve_message`
--

CREATE TABLE IF NOT EXISTS `eve_message` (
  `m_id` int(15) NOT NULL AUTO_INCREMENT,
  `m_message` text NOT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `eve_message`
--

INSERT INTO `eve_message` (`m_id`, `m_message`) VALUES
(1, 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `eve_person`
--

CREATE TABLE IF NOT EXISTS `eve_person` (
  `p_id` int(15) NOT NULL AUTO_INCREMENT,
  `event_id` int(20) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_desc` text NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `eve_person`
--

INSERT INTO `eve_person` (`p_id`, `event_id`, `p_name`, `p_image`, `p_desc`) VALUES
(27, 0, 'Mitesh Goswami', 'appoint.png', 'Software Developer at rudleo.com'),
(28, 0, 'Bhavin Goswami', 'appoint.png', 'Software Back end Program Developer at rudleo.com'),
(29, 0, '1', 'appoint.png', '1'),
(30, 0, '1', 'appoint1.png', '1'),
(31, 0, '1', 'Chrysanthemum.jpg', '1'),
(32, 2, '1', 'Desert.jpg', '1'),
(33, 1, '2', 'Jellyfish.jpg', '2'),
(34, 4, '12121', 'appoint1.png', '12121');

-- --------------------------------------------------------

--
-- Table structure for table `eve_photos`
--

CREATE TABLE IF NOT EXISTS `eve_photos` (
  `pp_id` int(15) NOT NULL AUTO_INCREMENT,
  `event_id` int(20) NOT NULL,
  `pp_name` varchar(255) NOT NULL,
  `pp_image` varchar(255) NOT NULL,
  PRIMARY KEY (`pp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `eve_photos`
--

INSERT INTO `eve_photos` (`pp_id`, `event_id`, `pp_name`, `pp_image`) VALUES
(5, 0, 'First Image', 'demo.jpg'),
(6, 0, 'Second Iamge', 'demo_2.jpg'),
(7, 0, 'Third Image', 'demo_3.jpg'),
(8, 2, '1', 'Hydrangeas.jpg'),
(9, 1, '2', 'Koala.jpg'),
(10, 4, '121212', 'Lighthouse.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `eve_rights`
--

CREATE TABLE IF NOT EXISTS `eve_rights` (
  `rights_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `rights` varchar(250) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eve_users`
--

CREATE TABLE IF NOT EXISTS `eve_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_active` enum('yes','no') NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `eve_users`
--

INSERT INTO `eve_users` (`user_id`, `user_group_id`, `user_name`, `password`, `user_active`, `create_date`) VALUES
(1, 1, 'admin', 'YWRtaW4=', 'yes', '2017-04-06 09:58:37');

-- --------------------------------------------------------

--
-- Table structure for table `eve_users_group`
--

CREATE TABLE IF NOT EXISTS `eve_users_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(100) DEFAULT NULL,
  `user_group_active` char(3) NOT NULL DEFAULT 'yes',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `eve_users_group`
--

INSERT INTO `eve_users_group` (`user_group_id`, `user_group_name`, `user_group_active`, `create_date`) VALUES
(1, 'Administrator', 'yes', '2015-09-03 06:57:24'),
(3, 'User', 'yes', '2017-03-31 05:45:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
