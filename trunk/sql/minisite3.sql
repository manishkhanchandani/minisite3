-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2009 at 04:42 AM
-- Server version: 5.1.30
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `minisite3`
--

-- --------------------------------------------------------

--
-- Table structure for table `ccategory`
--

DROP TABLE IF EXISTS `ccategory`;
CREATE TABLE IF NOT EXISTS `ccategory` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `category` varchar(200) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `ref_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filerealname` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `fileext` varchar(15) DEFAULT NULL,
  `filetype` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `album_id` int(11) NOT NULL,
  `hosttype` enum('Image','File','Music','Video','CategoryImage') NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `charges` float DEFAULT NULL,
  `pages` text,
  `setting_category_type` enum('Single','Multiple','None') DEFAULT NULL,
  `setting_category_image` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_price` float DEFAULT NULL,
  `order_shipping` float DEFAULT NULL,
  `order_total` float DEFAULT NULL,
  `order_ip` varchar(20) DEFAULT NULL,
  `status` enum('Not Paid','Pending','Processed','Delivered','Cancelled') NOT NULL DEFAULT 'Not Paid',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

DROP TABLE IF EXISTS `orders_detail`;
CREATE TABLE IF NOT EXISTS `orders_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `netprice` float DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_description` text,
  `price` float NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products_cat_rel`
--

DROP TABLE IF EXISTS `products_cat_rel`;
CREATE TABLE IF NOT EXISTS `products_cat_rel` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

DROP TABLE IF EXISTS `products_images`;
CREATE TABLE IF NOT EXISTS `products_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `image_date` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_realname` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_size` int(11) DEFAULT NULL,
  `image_ext` varchar(10) DEFAULT NULL,
  `image_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products_settings`
--

DROP TABLE IF EXISTS `products_settings`;
CREATE TABLE IF NOT EXISTS `products_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `shipping` float DEFAULT NULL,
  `currency_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile1`
--

DROP TABLE IF EXISTS `profile1`;
CREATE TABLE IF NOT EXISTS `profile1` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `gender` enum('Male','Female','Couple') DEFAULT NULL,
  `bDay` int(2) DEFAULT NULL,
  `bMonth` int(2) DEFAULT NULL,
  `bYear` int(4) DEFAULT NULL,
  `marital_status` int(2) DEFAULT NULL,
  `religion` int(4) DEFAULT NULL,
  `caste` int(4) DEFAULT NULL,
  `height` int(4) DEFAULT NULL,
  `build` int(4) DEFAULT NULL,
  `looks` int(4) DEFAULT NULL,
  `eyecolor` int(4) DEFAULT NULL,
  `haircolor` int(4) DEFAULT NULL,
  `bestfeature` int(4) DEFAULT NULL,
  `income` int(2) DEFAULT NULL,
  `educationLevel` int(4) DEFAULT NULL,
  `profession` int(4) DEFAULT NULL,
  `country_id` int(4) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `zipcode_id` int(11) NOT NULL,
  `smoking` int(1) DEFAULT NULL,
  `drinking` int(1) DEFAULT NULL,
  `food` int(1) DEFAULT NULL,
  `friends` int(1) DEFAULT NULL,
  `activity_partners` int(1) DEFAULT NULL,
  `business_networking` int(1) DEFAULT NULL,
  `dating` int(1) DEFAULT NULL,
  `dating_type` int(1) DEFAULT NULL,
  `living` int(1) DEFAULT NULL,
  `pets` int(1) NOT NULL DEFAULT '0',
  `sexual_orientation` int(1) DEFAULT NULL,
  `children` int(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profile2`
--

DROP TABLE IF EXISTS `profile2`;
CREATE TABLE IF NOT EXISTS `profile2` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `aboutme` text,
  `myfamily` text,
  `image` text,
  `highschool` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `im_yahoo` varchar(255) DEFAULT NULL,
  `im_msn` varchar(255) DEFAULT NULL,
  `im_gmail` varchar(255) DEFAULT NULL,
  `im_jabber` varchar(255) DEFAULT NULL,
  `im_other` varchar(255) DEFAULT NULL,
  `homephone` varchar(50) DEFAULT NULL,
  `cellphone` varchar(50) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `headline` varchar(200) DEFAULT NULL,
  `firstthing` varchar(255) DEFAULT NULL,
  `firstdate` text,
  `pastrelation` text,
  `fivethings` text,
  `bedroomthings` text,
  `idealmatch` text,
  `occupation` varchar(200) DEFAULT NULL,
  `industry` int(4) DEFAULT NULL,
  `company_webpage` varchar(255) DEFAULT NULL,
  `company_title` varchar(200) DEFAULT NULL,
  `job_description` text,
  `workphone` varchar(50) DEFAULT NULL,
  `work_email` varchar(150) DEFAULT NULL,
  `career_skills` text,
  `career_interests` text,
  `hometown` varchar(100) DEFAULT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `sports` text,
  `activities` text,
  `books` text,
  `music` text,
  `tvshows` text,
  `movies` text,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sitebaseurl` varchar(50) DEFAULT NULL,
  `siteurl` varchar(255) DEFAULT NULL,
  `sitepath` varchar(255) DEFAULT NULL,
  `siteemail` varchar(150) DEFAULT NULL,
  `docpath` varchar(255) DEFAULT NULL,
  `template` text,
  `css` text,
  `js` text,
  `paypal_email` varchar(150) DEFAULT NULL,
  `charges` float DEFAULT NULL,
  `next_payment_date` bigint(20) DEFAULT NULL,
  `status` enum('Not Paid','Paid','Cancelled') NOT NULL DEFAULT 'Not Paid',
  PRIMARY KEY (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sites_history`
--

DROP TABLE IF EXISTS `sites_history`;
CREATE TABLE IF NOT EXISTS `sites_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `charges` float DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_modules`
--

DROP TABLE IF EXISTS `site_modules`;
CREATE TABLE IF NOT EXISTS `site_modules` (
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `verify_code` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('Admin','Moderator','User') NOT NULL DEFAULT 'User',
  `status` int(1) NOT NULL DEFAULT '0',
  `lastlogin` int(11) DEFAULT NULL,
  `online` int(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `deleted_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users2`
--

DROP TABLE IF EXISTS `users2`;
CREATE TABLE IF NOT EXISTS `users2` (
  `xid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `xtra_field` varchar(255) DEFAULT NULL,
  `xtra_field_label` varchar(255) DEFAULT NULL,
  `xtra_field_value` text,
  PRIMARY KEY (`xid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_ratings`
--

DROP TABLE IF EXISTS `users_ratings`;
CREATE TABLE IF NOT EXISTS `users_ratings` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `rating` int(2) NOT NULL DEFAULT '0',
  `from_user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rating_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `users_settings`
--

DROP TABLE IF EXISTS `users_settings`;
CREATE TABLE IF NOT EXISTS `users_settings` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `registerfields` text,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
