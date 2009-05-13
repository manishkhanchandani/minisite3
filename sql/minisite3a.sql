/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.0.67 : Database - minisite3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `ccategory` */

DROP TABLE IF EXISTS `ccategory`;

CREATE TABLE `ccategory` (
  `category_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL default '0',
  `category` varchar(200) default NULL,
  `parent_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `ref_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `ccategory` */

insert  into `ccategory`(`category_id`,`site_id`,`category`,`parent_id`,`module_id`,`ref_id`,`user_id`) values (1,1,' Shop by Occasion',0,1,0,0),(2,1,'Shop by Product',0,1,0,0),(3,1,'Love N Romance',1,1,0,0),(4,1,'Mother\\\'s Day',1,1,0,0),(5,1,'Sympathy Flowers',1,1,0,0),(6,1,'Get Well Soon',1,1,0,0),(7,1,'Thank You',1,1,0,0),(8,1,'Congratulations',1,1,0,0),(9,1,'Wedding',1,1,0,0),(10,1,'Housewarming',1,1,0,0),(11,1,'New Baby',1,1,0,0),(12,1,'Anniversary',1,1,0,0),(13,1,'Birthday',1,1,0,0),(14,1,'Exclusive/ Unique Arrangements',2,1,0,0),(15,1,'Flowers Bunches',2,1,0,0),(16,1,'Flowers in Vase',2,1,0,0),(17,1,'Flower Hampers',2,1,0,0),(18,1,'Flower Baskets',2,1,0,0),(19,1,'For All Occasions',2,1,0,0),(20,1,'Exotic Flowers',2,1,0,0);

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `filename` varchar(255) default NULL,
  `filerealname` varchar(255) default NULL,
  `filepath` varchar(255) default NULL,
  `filesize` int(11) default NULL,
  `fileext` varchar(15) default NULL,
  `filetype` varchar(200) default NULL,
  `created` datetime default NULL,
  `album_id` int(11) NOT NULL,
  `hosttype` enum('Image','File','Music','Video','CategoryImage') NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `files` */

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL auto_increment,
  `module_name` varchar(100) default NULL,
  `ref` varchar(50) default NULL,
  `active` int(1) NOT NULL default '1',
  `charges` float default NULL,
  `pages` text,
  PRIMARY KEY  (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `modules` */

insert  into `modules`(`module_id`,`module_name`,`ref`,`active`,`charges`,`pages`) values (1,'Shopping Cart','cart',1,9.99,'{\"1\":\"index\",\"2\":\"addtocart\",\"3\":\"checkout\",\"4\":\"failure\",\"5\":\"mycart\",\"6\":\"myorders\",\"7\":\"products\",\"8\":\"payment\",\"9\":\"success\",\"10\":\"admin\\/orders\",\"11\":\"admin\\/products\",\"12\":\"admin\\/category\",\"13\":\"admin\\/index\"}'),(2,'Life Reminder','lifereminder',1,1.99,NULL),(3,'Seo','seo',1,9.99,NULL),(4,'Clinic','clinic',1,9.99,NULL);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `order_date` datetime default NULL,
  `order_price` float default NULL,
  `order_shipping` float default NULL,
  `order_total` float default NULL,
  `order_ip` varchar(20) default NULL,
  `status` enum('Not Paid','Pending','Processed','Delivered','Cancelled') NOT NULL default 'Not Paid',
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `orders` */

/*Table structure for table `orders_detail` */

DROP TABLE IF EXISTS `orders_detail`;

CREATE TABLE `orders_detail` (
  `detail_id` int(11) NOT NULL auto_increment,
  `order_id` int(11) default NULL,
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `product_id` int(11) default NULL,
  `user_id` int(11) default NULL,
  `qty` int(11) default NULL,
  `price` float default NULL,
  `netprice` float default NULL,
  PRIMARY KEY  (`detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `orders_detail` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `product_name` varchar(100) default NULL,
  `product_description` text,
  `price` float NOT NULL,
  `created` datetime NOT NULL,
  `featured` int(1) NOT NULL default '0',
  `startdate` datetime default NULL,
  `enddate` datetime default NULL,
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `products` */

/*Table structure for table `products_cat_rel` */

DROP TABLE IF EXISTS `products_cat_rel`;

CREATE TABLE `products_cat_rel` (
  `product_id` int(11) NOT NULL default '0',
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `category_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `products_cat_rel` */

/*Table structure for table `products_images` */

DROP TABLE IF EXISTS `products_images`;

CREATE TABLE `products_images` (
  `image_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `image_date` datetime NOT NULL,
  `image` varchar(255) default NULL,
  `image_realname` varchar(255) default NULL,
  `image_path` varchar(255) default NULL,
  `image_size` int(11) default NULL,
  `image_ext` varchar(10) default NULL,
  `image_type` varchar(50) default NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `products_images` */

/*Table structure for table `products_settings` */

DROP TABLE IF EXISTS `products_settings`;

CREATE TABLE `products_settings` (
  `setting_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) default NULL,
  `module_id` int(11) default NULL,
  `shipping` float default NULL,
  `currency_type` varchar(10) default NULL,
  PRIMARY KEY  (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `products_settings` */

/*Table structure for table `profile1` */

DROP TABLE IF EXISTS `profile1`;

CREATE TABLE `profile1` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `gender` enum('Male','Female','Couple') default NULL,
  `bDay` int(2) default NULL,
  `bMonth` int(2) default NULL,
  `bYear` int(4) default NULL,
  `marital_status` int(2) default NULL,
  `religion` int(4) default NULL,
  `caste` int(4) default NULL,
  `height` int(4) default NULL,
  `build` int(4) default NULL,
  `looks` int(4) default NULL,
  `eyecolor` int(4) default NULL,
  `haircolor` int(4) default NULL,
  `bestfeature` int(4) default NULL,
  `income` int(2) default NULL,
  `educationLevel` int(4) default NULL,
  `profession` int(4) default NULL,
  `country_id` int(4) default NULL,
  `province_id` int(11) default NULL,
  `city_id` int(11) default NULL,
  `zipcode_id` int(11) NOT NULL,
  `smoking` int(1) default NULL,
  `drinking` int(1) default NULL,
  `food` int(1) default NULL,
  `friends` int(1) default NULL,
  `activity_partners` int(1) default NULL,
  `business_networking` int(1) default NULL,
  `dating` int(1) default NULL,
  `dating_type` int(1) default NULL,
  `living` int(1) default NULL,
  `pets` int(1) NOT NULL default '0',
  `sexual_orientation` int(1) default NULL,
  `children` int(1) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `profile1` */

/*Table structure for table `profile2` */

DROP TABLE IF EXISTS `profile2`;

CREATE TABLE `profile2` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `aboutme` text,
  `myfamily` text,
  `image` text,
  `highschool` varchar(255) default NULL,
  `college` varchar(255) default NULL,
  `company` varchar(255) default NULL,
  `im_yahoo` varchar(255) default NULL,
  `im_msn` varchar(255) default NULL,
  `im_gmail` varchar(255) default NULL,
  `im_jabber` varchar(255) default NULL,
  `im_other` varchar(255) default NULL,
  `homephone` varchar(50) default NULL,
  `cellphone` varchar(50) default NULL,
  `address1` varchar(255) default NULL,
  `address2` varchar(255) default NULL,
  `headline` varchar(200) default NULL,
  `firstthing` varchar(255) default NULL,
  `firstdate` text,
  `pastrelation` text,
  `fivethings` text,
  `bedroomthings` text,
  `idealmatch` text,
  `occupation` varchar(200) default NULL,
  `industry` int(4) default NULL,
  `company_webpage` varchar(255) default NULL,
  `company_title` varchar(200) default NULL,
  `job_description` text,
  `workphone` varchar(50) default NULL,
  `work_email` varchar(150) default NULL,
  `career_skills` text,
  `career_interests` text,
  `hometown` varchar(100) default NULL,
  `webpage` varchar(255) default NULL,
  `sports` text,
  `activities` text,
  `books` text,
  `music` text,
  `tvshows` text,
  `movies` text,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `profile2` */

/*Table structure for table `site_modules` */

DROP TABLE IF EXISTS `site_modules`;

CREATE TABLE `site_modules` (
  `site_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `setting_category_type` enum('Single','Multiple','None') default NULL,
  `setting_category_image` int(1) NOT NULL default '0',
  PRIMARY KEY  (`site_id`,`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `site_modules` */

insert  into `site_modules`(`site_id`,`module_id`,`user_id`,`setting_category_type`,`setting_category_image`) values (1,1,1,'Multiple',0);

/*Table structure for table `sites` */

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `site_id` int(11) NOT NULL auto_increment,
  `sitename` varchar(50) default NULL,
  `user_id` int(11) default NULL,
  `sitebaseurl` varchar(50) default NULL,
  `siteurl` varchar(255) default NULL,
  `sitepath` varchar(255) default NULL,
  `siteemail` varchar(150) default NULL,
  `docpath` varchar(255) default NULL,
  `template` text,
  `css` text,
  `js` text,
  `paypal_email` varchar(150) default NULL,
  `charges` float default NULL,
  `next_payment_date` bigint(20) default NULL,
  `status` enum('Not Paid','Paid','Cancelled') NOT NULL default 'Not Paid',
  PRIMARY KEY  (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sites` */

insert  into `sites`(`site_id`,`sitename`,`user_id`,`sitebaseurl`,`siteurl`,`sitepath`,`siteemail`,`docpath`,`template`,`css`,`js`,`paypal_email`,`charges`,`next_payment_date`,`status`) values (1,'Gift Flowers',1,'http://','mkgalaxy.com',NULL,'admin@mkgalaxy.com','/home37b/sub004/sc29722-KLXJ/www/minisite3',NULL,NULL,NULL,NULL,NULL,NULL,'Not Paid');

/*Table structure for table `sites_history` */

DROP TABLE IF EXISTS `sites_history`;

CREATE TABLE `sites_history` (
  `history_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) default NULL,
  `charges` float default NULL,
  `paid_date` datetime default NULL,
  PRIMARY KEY  (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sites_history` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `email` varchar(150) default NULL,
  `password` varchar(50) default NULL,
  `name` varchar(100) default NULL,
  `verify_code` varchar(100) default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `role` enum('Admin','Moderator','User') NOT NULL default 'User',
  `status` int(1) NOT NULL default '0',
  `lastlogin` int(11) default NULL,
  `online` int(1) NOT NULL default '0',
  `deleted` int(1) NOT NULL default '0',
  `deleted_dt` datetime default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*Table structure for table `users_ratings` */

DROP TABLE IF EXISTS `users_ratings`;

CREATE TABLE `users_ratings` (
  `rating_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `rating` int(2) NOT NULL default '0',
  `from_user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rating_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

/*Data for the table `users_ratings` */

/*Table structure for table `users_settings` */

DROP TABLE IF EXISTS `users_settings`;

CREATE TABLE `users_settings` (
  `sid` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL default '0',
  `registerfields` text,
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_settings` */

/*Table structure for table `users2` */

DROP TABLE IF EXISTS `users2`;

CREATE TABLE `users2` (
  `xid` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `xtra_field` varchar(255) default NULL,
  `xtra_field_label` varchar(255) default NULL,
  `xtra_field_value` text,
  PRIMARY KEY  (`xid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users2` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;