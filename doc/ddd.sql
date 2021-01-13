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
) ENGINE=InnoDB AUTO_INCREMENT=10021 DEFAULT CHARSET=utf8mb4;

/*Data for the table `video` */

insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10001,'OKAX-687 商业酒店工作人员的肥心熟女的肉体恶作剧 摸了一下打工的阿姨',4,'亞洲有碼',1,1,191385,23104,27214,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/40ce62f5563955696503486e556dc10d.jpg','https://jx.tingxuan2014.top/tyfirm/81385312394627803.mp4',11,11,NULL,'2021-01-10 19:34:34','2021-01-13 10:07:50',16819);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10002,'OKAX-691 在这种地方职场上苦闷工作的阿姨4小时',4,'亞洲有碼',1,1,169855,27810,41092,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/3eab4c19b14dc7d6f900412beec9b67d.jpg','https://jx.tingxuan2014.top/tyfirm/71540312426385817.mp4',11,11,NULL,'2021-01-10 19:34:34','2021-01-13 10:08:07',16820);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10003,'RCTD-247 救命病栋篇 横山夏希',4,'亞洲有碼',1,1,253532,38795,26912,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/7e04ab01fb1eb00324f74d7b8cd16b53.jpg','https://jx.tingxuan2014.top/tyfirm/61549312420115492.mp4',11,11,NULL,'2021-01-10 19:34:34','2021-01-13 10:08:11',16821);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10004,'TOTTE-007 利刃裂裂',4,'亞洲有碼',1,1,143495,25387,44503,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/5b92c54c80e9004dcb0a45677e400138.jpg','https://jx.tingxuan2014.top/tyfirm/81385312394627675.mp4',11,11,NULL,'2021-01-10 19:34:29','2021-01-13 10:08:19',16827);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10005,'VDD-168 接待小姐 恐吓套房 桐山結羽 桐山结羽',4,'亞洲有碼',1,1,95902,36806,21260,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/4eeb1804c97108d390a065eb5931e86a.jpg','https://jx.tingxuan2014.top/tyfirm/91462312430532279.mp4',11,11,NULL,'2021-01-10 19:34:29','2021-01-13 10:08:23',16828);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10006,'SIM-104 色情服务内容感到可疑的店长设置的隐藏照相机中收录的通常业务正在现场拍摄中',4,'亞洲有碼',1,1,189063,22539,46902,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/31d524fa526a218ec58daee27dbc8da5.jpg','https://jx.tingxuan2014.top/tyfirm/71407312426186448.mp4',11,11,NULL,'2021-01-10 19:34:28','2021-01-13 10:08:28',16829);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10007,'SIV-044 以延长感被拍摄了，外行偶像们的首次出现映像',4,'亞洲有碼',1,1,265238,31562,49785,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/b93027745e31b1c2383dc2229862f7e5.jpg','https://jx.tingxuan2014.top/tyfirm/81455312394796455.mp4',11,11,NULL,'2021-01-10 19:34:28','2021-01-13 10:08:32',16830);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10008,'NASH-430-A 掠夺交尾被夺走的人妻NTR best 4小时',4,'亞洲有碼',1,1,138192,46187,41062,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/8b6140082ef1f1b26c24cda474eceeb6.jpg','https://jx.tingxuan2014.top/tyfirm/61549312420115182.mp4',11,11,NULL,'2021-01-10 19:34:27','2021-01-13 10:08:37',16831);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10009,'NASH-430-B 掠夺交尾被夺走的人妻NTR best 4小时',4,'亞洲有碼',1,1,170484,45231,21973,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/2036232f6b91cb16e37c5925dfbd8ca4.jpg','https://jx.tingxuan2014.top/tyfirm/51367312435548478.mp4',11,11,NULL,'2021-01-10 19:34:27','2021-01-13 10:08:41',16832);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10010,'SGSR-271 酒屋酒会外带录像所谓的酒 自肃解禁纪念特别4小时13人',4,'亞洲有碼',1,1,187396,26123,39163,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/1c2538a46b8a3e81c330273b003ea647.jpg','https://jx.tingxuan2014.top/tyfirm/31374312329291845.mp4',11,11,NULL,'2021-01-10 19:34:27','2021-01-13 10:08:45',16833);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10011,'SHM-030 全是女生的写真 椿りか 椿莉香',4,'亞洲有碼',1,1,217225,30395,41515,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/e8ffbfa2ce7c02fd9974434e67883ca2.jpg','https://jx.tingxuan2014.top/tyfirm/81455312394796295.mp4',11,11,NULL,'2021-01-10 19:34:27','2021-01-13 10:08:49',16834);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10012,'SIM-103 不用付酒店费的最高的约瑟夫在人妻丈夫不在的时候',4,'亞洲有碼',1,1,295514,41660,28873,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/456e74795507d69baa52af755bf7aa60.jpg','https://jx.tingxuan2014.top/tyfirm/61549312420115260.mp4',11,11,NULL,'2021-01-10 19:34:27','2021-01-13 10:08:53',16835);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10013,'中文字幕 WAAA-024 夫妻交换的绝伦马拉互相吃粗俗出し比较逆3P后宫 望月あやか 望月绫香',1,'中文字幕',1,1,275312,27246,41849,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/1fd98ab769e818cb7a1c0ee967c45f37.jpg','https://jx.tingxuan2014.top/tyfirm/41385312427548603.mp4',11,11,NULL,'2021-01-10 19:34:24','2021-01-13 10:09:01',16843);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10014,'MBM-250-A 西田カリナ 西田卡莉娜',4,'亞洲有碼',1,1,248910,23157,35982,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/f7e588a15504550c2058772dbde601af.jpg','https://jx.tingxuan2014.top/tyfirm/81345312393823692.mp4',11,11,NULL,'2021-01-10 19:34:26','2021-01-13 10:09:05',16836);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10015,'MBM-250-B 西田カリナ 西田卡莉娜',4,'亞洲有碼',1,1,196367,22265,49539,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/5f2e647c73ecc297d5526f91aaa88dd0.jpg','https://jx.tingxuan2014.top/tyfirm/51540312434208290.mp4',11,11,NULL,'2021-01-10 19:34:26','2021-01-13 10:09:09',16837);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10016,'MKMP-371-A 完成BEST4小时 七瀬いおり 七濑伊织',4,'亞洲有碼',1,1,147512,33602,36317,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/015d9a359246545f6027d27838dbb4d0.jpg','https://jx.tingxuan2014.top/tyfirm/81385312394627262.mp4',11,11,NULL,'2021-01-10 19:34:26','2021-01-13 10:09:13',16838);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10017,'MKMP-371-B 完成BEST4小时 七瀬いおり 七濑伊织',4,'亞洲有碼',1,1,114786,20639,45837,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/269cc9abd369d9348c37a8cd54d1f927.jpg','https://jx.tingxuan2014.top/tyfirm/31374312329291581.mp4',11,11,NULL,'2021-01-10 19:34:26','2021-01-13 10:09:17',16839);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10018,'BDSR-434 纯洁的笑容和止不住的豪爽潮吹性感美女 浜崎真緒 浜崎真绪',4,'亞洲有碼',1,1,200767,37579,42998,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/da788edf64af6f2fd5d9705ca1b51884.jpg','https://jx.tingxuan2014.top/tyfirm/71540312426385517.mp4',11,11,NULL,'2021-01-10 19:34:25','2021-01-13 10:09:21',16840);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10019,'JUFE-239 虽然很朴素 但是H罩杯的宁酱超早泄 初愛ねんね 初爱宁宁',4,'亞洲有碼',1,1,204984,35764,20816,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/4dee9e48e248f8eb96ed452a8faeafc5.jpg','https://jx.tingxuan2014.top/tyfirm/41407312427589947.mp4',11,11,NULL,'2021-01-10 19:34:25','2021-01-13 10:09:25',16841);
insert  into `video`(`id`,`title`,`cate_id`,`cate_name`,`is_vip`,`is_hd`,`hit_num`,`up_num`,`down_num`,`images`,`video_url`,`images_type`,`video_type`,`vod_time`,`create_time`,`update_time`,`third_type`) values (10020,'JUFE-240 性骚扰整体太厉害了 男朋友在旁边却多次被欺负的女大学生 木下ひまり 木下日葵',4,'亞洲有碼',1,1,135521,21712,42970,'https://img.hxcsxs1.xyz/upload/vod/20210110-1/6004c5190b569d7571e4e89d8fc6b178.jpg','https://jx.tingxuan2014.top/tyfirm/71407312426184755.mp4',11,11,NULL,'2021-01-10 19:34:25','2021-01-13 10:09:29',16842);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
