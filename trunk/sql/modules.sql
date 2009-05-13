-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2009 at 04:49 AM
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

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `ref`, `active`, `charges`, `pages`, `setting_category_type`, `setting_category_image`) VALUES
(1, 'Shopping Cart', 'cart', 1, 9.99, '{"1":"index","2":"addtocart","3":"checkout","4":"failure","5":"mycart","6":"myorders","7":"products","8":"payment","9":"success","10":"admin\\/orders","11":"admin\\/products","12":"admin\\/category"}', 'Multiple', 0),
(2, 'Life Reminder', 'lifereminder', 1, 1.99, NULL, NULL, 0),
(3, 'Seo', 'seo', 1, 9.99, NULL, NULL, 0),
(4, 'Clinic', 'clinic', 1, 9.99, NULL, NULL, 0);
