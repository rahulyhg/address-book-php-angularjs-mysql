/*
SQLyog Community v10.3 
MySQL - 5.5.24-log : Database - employeedirectory_db
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=``*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=`NO_AUTO_VALUE_ON_ZERO` */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`employeedirectory_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `employeedirectory_db`;

--
-- Database: `employeedirectory_db`
--


--
-- Create user apps for dbname
--
GRANT USAGE ON *.* TO `employeedirectory_db_user`@`localhost`;
DROP USER `employeedirectory_db_user`@`localhost`;
FLUSH PRIVILEGES;

CREATE USER `employeedirectory_db_user`@`localhost` IDENTIFIED BY 'employeedirectory_db_$ecure';


GRANT SELECT, INSERT, UPDATE, DELETE ON `employeedirectory_db`.*    TO `employeedirectory_db_user`@`localhost`;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `toid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'U',
`id` int(11) NOT NULL,
  `fromid` int(11) NOT NULL,
  `emptestid` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`roleid` int(6) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `roles`
--

-- INSERT INTO `roles` (`roleid`, `role`) VALUES
-- (99, 'admin'),
-- (100, 'employer'),
-- (101, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `smsendsms`
--

CREATE TABLE IF NOT EXISTS `smsendsms` (
  `fromId` int(11) NOT NULL,
  `toId` int(11) NOT NULL,
  `smstype` varchar(20) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'N',
`id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `employeetestid` int(11) DEFAULT NULL,
  `employerid` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE IF NOT EXISTS `userroles` (
`id` int(11) NOT NULL,
  `userid` int(6) NOT NULL,
  `roleid` int(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10006 ;

--
-- Dumping data for table `userroles`
--

-- INSERT INTO `userroles` (`id`, `userid`, `roleid`) VALUES
-- (9999, 999, 99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(90) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(20) NOT NULL DEFAULT 'en',
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `contactno` varchar(20) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `security_code` bigint(5) NOT NULL,
  `random_number` varchar(10) NOT NULL,
  `gender` char(6) NOT NULL,
  `sms_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sms_count` int(1) NOT NULL DEFAULT '0',
  `email_verified` char(1) NOT NULL DEFAULT 'N',
  `adminverified` varchar(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1046 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `smsendsms`
--
ALTER TABLE `smsendsms`
 ADD PRIMARY KEY (`id`), ADD KEY `emp_test_fk1` (`employeetestid`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
 ADD PRIMARY KEY (`id`), ADD KEY `user` (`userid`), ADD KEY `role` (`roleid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `roleid` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `smsendsms`
--
ALTER TABLE `smsendsms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10006;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1046;
--
-- Constraints for dumped tables
--

--
-- create users and roles sql goes here.
--
