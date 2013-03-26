/*
SQLyog Ultimate v8.61 
MySQL - 5.5.22 : Database - ittblog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ittblog` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ittblog`;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(36) NOT NULL COMMENT '博文的编号',
  `author` varchar(20) DEFAULT 'guest' COMMENT '博文的作者Account',
  `title` varchar(255) DEFAULT NULL COMMENT '博文的标题',
  `content` longtext COMMENT '博文的内容',
  `publishTime` datetime DEFAULT NULL COMMENT '博文发表的时间',
  `typeId` varchar(36) DEFAULT NULL COMMENT '博文所属类别:0系统默认为',
  `status` tinyint(1) DEFAULT '0' COMMENT '博文状态:	0草稿；1已发表；2已删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `articleId` varchar(36) NOT NULL COMMENT '博文编号',
  `commentor` varchar(36) NOT NULL DEFAULT '0' COMMENT '评论者account:0游客评论',
  `content` varchar(500) NOT NULL COMMENT '评论内容',
  `publishTime` datetime NOT NULL COMMENT '评论发表时间',
  `delTag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论删除标志:0正常；1已删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

/*Table structure for table `layouts` */

DROP TABLE IF EXISTS `layouts`;

CREATE TABLE `layouts` (
  `layoutId` int(36) NOT NULL AUTO_INCREMENT COMMENT '布局编号',
  `userAccount` varchar(36) DEFAULT '0' COMMENT '用户编号',
  `layoutLeft` varchar(255) DEFAULT NULL COMMENT '左边布局编号',
  `layoutMiddle` varchar(255) DEFAULT NULL COMMENT '中间边布局编号',
  `layoutRight` varchar(255) DEFAULT NULL COMMENT '右边布局编号',
  `currentStatus` varchar(8) DEFAULT NULL COMMENT '当前状态',
  UNIQUE KEY `layoutId` (`layoutId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `layouts` */

/*Table structure for table `links` */

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) NOT NULL COMMENT '友情链接编号',
  `name` varchar(100) NOT NULL COMMENT '友情连接的名称',
  `url` varchar(255) NOT NULL COMMENT '友情连接地址',
  `articleId` varchar(36) NOT NULL COMMENT '所属博文Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `links` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(36) NOT NULL AUTO_INCREMENT,
  `articleId` varchar(36) DEFAULT NULL COMMENT '博文Id',
  `tagName` varchar(36) DEFAULT NULL COMMENT '标签名',
  `tagNameFirstPY` varchar(36) DEFAULT NULL COMMENT '标签名拼音首字母缩写',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tags` */

/*Table structure for table `types` */

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int(36) NOT NULL COMMENT '文章分类编号',
  `userAccount` varchar(36) DEFAULT NULL COMMENT '用户唯一编号',
  `name` varchar(20) DEFAULT NULL COMMENT '文章分类名称',
  `nameFirstPY` varchar(20) DEFAULT NULL COMMENT '分类首字母拼音缩写',
  `typeTag` tinyint(1) DEFAULT NULL COMMENT '文章类别标识:0：系统默认；其他为用户添加',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `types` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(36) NOT NULL AUTO_INCREMENT COMMENT '用户编号，主键',
  `name` varchar(20) DEFAULT NULL COMMENT '用户真实姓名',
  `nameFirstPY` varchar(20) DEFAULT NULL COMMENT '用户真实姓名首字母拼音缩写',
  `alias` varchar(20) NOT NULL COMMENT '用户别名，唯一',
  `aliasFirstPY` varchar(20) DEFAULT NULL COMMENT '用户别名拼音首字母缩写',
  `account` varchar(20) NOT NULL COMMENT '用户数字帐号，唯一',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `role` varchar(8) NOT NULL DEFAULT 'g' COMMENT '用户角色：g来宾；a管理员；u用户；o其他',
  `sex` varchar(4) NOT NULL DEFAULT 'm' COMMENT '用户性别，默认为男性',
  `birthday` datetime DEFAULT NULL COMMENT '用户生日',
  `userGrade` int(8) DEFAULT NULL COMMENT '用户级别',
  `mobilePhone` varchar(20) DEFAULT NULL COMMENT '用户电话',
  `email` varchar(100) NOT NULL COMMENT '用户电子邮件',
  `address` varchar(255) DEFAULT NULL COMMENT '用户地址',
  `zipCode` varchar(8) DEFAULT NULL COMMENT '用户地址邮编',
  `identityNo` varchar(36) DEFAULT NULL COMMENT '用户身份识别号',
  `registTime` datetime NOT NULL COMMENT '用户注册时间',
  `lastLoginTime` datetime DEFAULT NULL COMMENT '用户上次登录时间',
  `lastIP` varchar(20) DEFAULT NULL COMMENT '用户上次登录IP地址',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户当前状态：0：未激活，1：正常，2：删除',
  `visitCount` int(11) DEFAULT '0' COMMENT '访问次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*Table structure for table `windows` */

DROP TABLE IF EXISTS `windows`;

CREATE TABLE `windows` (
  `windowsId` int(36) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `userAccount` varchar(36) NOT NULL COMMENT '用户帐号',
  `blogName` varchar(255) NOT NULL COMMENT '博客名称',
  `className` varchar(255) NOT NULL COMMENT '初始化类名',
  `currentStatus` varchar(8) DEFAULT NULL COMMENT '当前窗口的状态',
  UNIQUE KEY `windowsId` (`windowsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `windows` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
