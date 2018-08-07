/**
 * [创建数据库]
 * @Author: Fu Xiaochun
 * @Email:  f2e.xiaochun@gmail.com
 * @Link:   www.fuxiaochun.com
 */
CREATE DATABASE `xouting` CHARSET=utf8mb4;

/*管理员表*/
create table `manager`(
	`id` int unsigned auto_increment primary key,
	`user` varchar(20) unique key not null,
	`password` char(32) not null,
	`captcha` varchar(20) not null,
	`level` tinyint(1) unsigned not null,
	`email` varchar(100) default '',
	`tel` varchar(20) default '',
	`del` tinyint(1) default 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

insert into manager values(null, 'admin', md5('admin023'), '023', 0, '','', 0);

/*网站信息表*/
create table `site_info`(
	`id` tinyint(1) unsigned auto_increment primary key,
	`name` varchar(200) not null,
	`keywords` varchar(200) default '',
	`description` varchar(500) default '',
	`domain` varchar(100) default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

insert into `site_info` values(null, '青石玉雕', '青石玉雕，玉石，玉雕', '青石玉雕', 'http://mmcms.com');

/*分类表*/
create table `category`(
	`id` int unsigned auto_increment primary key,
	`name` varchar(50) not null default '',
	`pid` int unsigned not null default 0,
	`keywords` varchar(200) default '',
	`description` varchar(500) default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*文章表*/
create table `article`(
	`id` int unsigned auto_increment primary key,
	`focus_img` varchar(200),
	`title` varchar(200) not null default '',
	`summary` varchar(400) default '',
	`keywords` varchar(200) default '',
	`content` text default '',
	`author` varchar(50),
	`origin` varchar(50),
	`create_time` timestamp,
	`update_time` timestamp,
	`category_id` int unsigned not null default 0,
	`recommend` tinyint(1) default 0,
	`outlink` varchar(200) default '',
	`del` tinyint(1) default 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*文章访问记录表*/
create table `article_visited`(
	`id` int unsigned auto_increment primary key,
	`article_id` int unsigned not null,
	`total` int unsigned default 0,
	`day` int unsigned default 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*单页表*/
create table `page`(
	`id` int unsigned auto_increment primary key,
	`title` varchar(200) not null,
	`alias` varchar(200) not null,
	`keywords` varchar(200) default '',
	`description` varchar(400) default '',
	`content` text default '',
	`del` tinyint(1) default 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;



/*证书*/
create table `certificate`(
	`id` int unsigned auto_increment primary key,
	`year` varchar(4) not null,
	`certificate` varchar(12) not null,
	`name` varchar(50) not null,
	`texture` varchar(50) not null,
	`size` varchar(50) not null,
	`weight` varchar(50) not null,
	`product_img` varchar(50) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/*插入数据*/
