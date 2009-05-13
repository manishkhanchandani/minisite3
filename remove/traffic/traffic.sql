-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 07, 2008 at 05:01 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.0
-- 
-- Database: `june2007`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `traffic_account`
-- 

DROP TABLE IF EXISTS `traffic_account`;
CREATE TABLE `traffic_account` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) collate latin1_general_ci default NULL,
  `password` varchar(50) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `traffic_sites`
-- 

DROP TABLE IF EXISTS `traffic_sites`;
CREATE TABLE `traffic_sites` (
  `site_id` int(11) NOT NULL auto_increment,
  `id` int(11) NOT NULL default '0',
  `sitename` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`site_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

-- 
-- Table structure for table `traffic_stats`
-- 

DROP TABLE IF EXISTS `traffic_stats`;
CREATE TABLE `traffic_stats` (
  `sid` int(11) NOT NULL auto_increment,
  `id` int(11) NOT NULL default '0',
  `site_id` int(11) NOT NULL default '0',
  `page_url` text collate latin1_general_ci,
  `referrer` text collate latin1_general_ci,
  `cdate` datetime default NULL,
  `ctime` bigint(20) NOT NULL default '0',
  `cday` int(2) NOT NULL default '0',
  `cmonth` int(2) NOT NULL default '0',
  `cyear` int(4) NOT NULL default '0',
  `ip` varchar(20) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

