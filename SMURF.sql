-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2012 at 09:25 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `SMURF`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminswitchboard`
--

CREATE TABLE IF NOT EXISTS `adminswitchboard` (
  `adminPageID` int(11) NOT NULL AUTO_INCREMENT,
  `adminPageName` varchar(40) NOT NULL,
  `adminShortURL` varchar(150) NOT NULL,
  `adminFullURL` varchar(150) NOT NULL,
  `adminPanel` tinyint(1) NOT NULL,
  `showOnAdminPanel` tinyint(1) NOT NULL,
  `adminSecurity` tinyint(1) NOT NULL,
  PRIMARY KEY (`adminPageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `adminswitchboard`
--

INSERT INTO `adminswitchboard` (`adminPageID`, `adminPageName`, `adminShortURL`, `adminFullURL`, `adminPanel`, `showOnAdminPanel`, `adminSecurity`) VALUES
(3, '', 'login', 'modules/admin/account/login.php', 0, 0, -1),
(-1, '', 'logout', 'modules/admin/account/logout.php', 0, 0, 0),
(5, 'User Management', 'account', 'modules/admin/account/index.php', 1, 1, 4),
(6, '', 'panel', 'modules/admin/panel.php', 1, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cronjobs`
--

CREATE TABLE IF NOT EXISTS `cronjobs` (
  `jobID` int(11) NOT NULL AUTO_INCREMENT,
  `minute` varchar(5) NOT NULL,
  `hour` varchar(5) NOT NULL,
  `day` varchar(5) NOT NULL,
  `month` varchar(5) NOT NULL,
  `weekday` varchar(5) NOT NULL,
  `page` varchar(150) NOT NULL,
  PRIMARY KEY (`jobID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE IF NOT EXISTS `menuitems` (
  `menuID` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  PRIMARY KEY (`menuID`,`pageID`),
  KEY `pageID` (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`menuID`, `pageID`, `rank`, `title`) VALUES
(0, 0, 0, 'Home');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `menuID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`menuID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menuID`, `name`) VALUES
(10, 'Site Menu');

-- --------------------------------------------------------

--
-- Table structure for table `pageContent`
--

CREATE TABLE IF NOT EXISTS `pageContent` (
  `pageID` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pageContent`
--

INSERT INTO `pageContent` (`pageID`, `content`) VALUES
(0, '<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3> Morbi consequat est et velit congue vulputate. Nullam auctor dolor id est varius lobortis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed a orci eu sapien porttitor venenatis ut ut orci. Praesent et felis sed mi varius sodales a eu sem. Proin fringilla, nibh non elementum vulputate, diam ligula faucibus quam, sed posuere nisl augue ut orci. Donec eget purus nec est convallis ornare id in ante. Fusce semper venenatis risus vitae malesuada. Donec quam magna, tincidunt quis convallis bibendum, feugiat eu sem.');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageID` int(11) NOT NULL AUTO_INCREMENT,
  `shortURL` varchar(150) NOT NULL,
  `fullURL` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `parentID` int(11) NOT NULL,
  `menuID` int(11) NOT NULL,
  `cols` int(11) NOT NULL,
  `dbContent` tinyint(1) NOT NULL,
  PRIMARY KEY (`pageID`),
  KEY `urlID` (`pageID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageID`, `shortURL`, `fullURL`, `title`, `parentID`, `menuID`, `cols`, `dbContent`) VALUES
(0, '', 'pages/home.php', 'Home', -1, -1, 1, 1),
(16, 'admin', 'modules/admin/index.php', 'Admin', 0, -1, 1, 0),
(17, 'json', 'modules/json/index.php', 'JSON', -1, -1, 0, 0),
(24, 'account', 'pages/account.php', 'Account', 0, -1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE IF NOT EXISTS `slides` (
  `slideID` int(4) NOT NULL AUTO_INCREMENT,
  `slideshowID` int(11) NOT NULL,
  `imageName` varchar(40) NOT NULL,
  `link` varchar(40) NOT NULL,
  `rank` varchar(4) NOT NULL,
  PRIMARY KEY (`slideID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`slideID`, `slideshowID`, `imageName`, `link`, `rank`) VALUES
(1, 1, 'slide1.jpg', '/contactUs', '0'),
(2, 1, 'slide2.jpg', '/contactUs', '1'),
(3, 1, 'slide3.jpg', '/contactUs', '2');

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE IF NOT EXISTS `slideshows` (
  `slideshowID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `seconds` int(11) NOT NULL,
  PRIMARY KEY (`slideshowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideshows`
--

INSERT INTO `slideshows` (`slideshowID`, `title`, `width`, `height`, `seconds`) VALUES
(1, 'Home', 600, 400, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `securityLevel` tinyint(1) NOT NULL DEFAULT '0',
  `temp` tinyint(1) NOT NULL DEFAULT '0',
  `joinDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sGUID` varchar(32) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `username`, `password`, `email`, `securityLevel`, `temp`, `joinDate`, `sGUID`, `lastLogin`) VALUES
(0, 'SMURF Admin', '', 'admin', 'cf79aac5143ed792268bf520cb4b2ca5ae330f54', 'email@smurfsite.com', 0, 0, '2012-01-24 04:36:54', '7788ae1a8652536887f15a4087f4b5f2', '2012-01-29 17:54:23');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
