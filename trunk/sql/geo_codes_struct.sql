CREATE TABLE IF NOT EXISTS `geo_codes` (
  `code_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `con_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `code` varchar(250) NOT NULL DEFAULT '',
  `latitude` float NOT NULL DEFAULT '0',
  `longitude` float NOT NULL DEFAULT '0',
  `cty_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sta_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`code_id`),
  UNIQUE KEY `con_id` (`con_id`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;