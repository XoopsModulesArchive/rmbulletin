CREATE TABLE `rmb_boletines` (
  `id_bol` int(11) NOT NULL auto_increment,
  `titulo` varchar(255) NOT NULL default '',
  `introduccion` text NOT NULL,
  `fecha` int(11) NOT NULL default '0',
  `eliminar` tinyint(1) NOT NULL default '0',
  `fechaeliminar` int(11) NOT NULL default '0',
  `sended` tinyint(1) NOT NULL default '0',
  `plantilla` VARCHAR(255) NOT NULL default '',
  `fechaenvio` INT(11) NOT NULL default '0',
  PRIMARY KEY  (`id_bol`)
) TYPE=MyISAM;

CREATE TABLE `rmb_configoptions` (
	`id_opt` INT(11) NOT NULL auto_increment,
	`id_conf` INT(11) NOT NULL DEFAULT '0',
	`caption` VARCHAR(255) NOT NULL DEFAULT '',
	`value` TEXT NOT NULL DEFAULT '',
	PRIMARY KEY (`id_opt`)	
) TYPE=MyISAM;

CREATE TABLE `rmb_configs` (
	`id_cnf` INT(11) NOT NULL auto_increment,
	`name` VARCHAR(100) NOT NULL default '',
	`caption` VARCHAR(255) NOT NULL default '',
	`desc` VARCHAR(255) NOT NULL default '',
	`plugin` VARCHAR(150) NOT NULL default '',
	`conf_value` TEXT NOT NULL DEFAULT '',
	`valuetype` VARCHAR(30) NOT NULL DEFAULT '',
	`fieldtype` VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY (`id_cnf`)
) TYPE=MyISAM;

CREATE TABLE `rmb_content` (
  `id_item` INT(11) NOT NULL auto_increment,
  `plugin` VARCHAR(100) NOT NULL DEFAULT '',
  `params` TEXT NOT NULL default '',
  `id_bol` INT(11) NOT NULL,
  `section` INT(11) NOT NULL,
  PRIMARY KEY (`id_item`)
) TYPE=MyISAM;

CREATE TABLE `rmb_emails` (
  `id_mail` int(11) NOT NULL auto_increment,
  `smtp` VARCHAR(255) NOT NULL default '',
  `user` VARCHAR(150) NOT NULL default '',
  `password` VARCHAR(50) NOT NULL default '',
  `from` VARCHAR(200) NOT NULL,
  `limit` INT(11) NOT NULL DEFAULT '100',
  `used` INT(5) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id_mail`)
) TYPE=MyISAM;

CREATE TABLE `rmb_plugins` (
  `id_plug` int(11) NOT NULL auto_increment PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL default '',
  `dir` VARCHAR(100) NOT NULL default '',
  `active` TINYINT(1) NOT NULL default 1,
  INDEX (`dir`)
) TYPE=MyISAM;

CREATE TABLE `rmb_sections` (
  `id_sec` INT(11) NOT NULL auto_increment,
  `titulo` VARCHAR(255) NOT NULL default '',
  `id_b` INT(11) NOT NULL DEFAULT '0',
  `order` INT(11) NOT NULL default '0',
  PRIMARY KEY (`id_sec`)
) TYPE=MyISAM;

CREATE TABLE `rmb_users` (
  `id_user` INT(11) NOT NULL auto_increment,
  `uid` INT(11) NOT NULL default '0',
  `alta` INT(11) NOT NULL DEFAULT '0',
  `registered` TINYINT(1) NOT NULL default '0',
  `email` VARCHAR(255) NOT NULL default '',
  `code` VARCHAR(50) NOT NULL default '',
  PRIMARY KEY (`id_user`)
) TYPE=MyISAM;
