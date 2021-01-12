/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 10.4.14-MariaDB : Database - luge_php
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`luge_php` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `luge_php`;

/*Table structure for table `video` */

DROP TABLE IF EXISTS `video`;

CREATE TABLE `video` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `cate_id` int(10) DEFAULT NULL,
  `cate_name` varchar(64) DEFAULT NULL,
  `is_vip` tinyint(3) DEFAULT 1,
  `is_hd` tinyint(3) DEFAULT 1,
  `hit_num` int(10) DEFAULT 120,
  `up_num` int(10) DEFAULT 100,
  `down_num` int(10) DEFAULT 100,
  `images` varchar(256) DEFAULT NULL,
  `video_url` varchar(256) DEFAULT NULL,
  `images_type` tinyint(3) DEFAULT NULL,
  `video_type` tinyint(3) DEFAULT NULL,
  `vod_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `third_type` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8mb4;

/*Data for the table `video` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
