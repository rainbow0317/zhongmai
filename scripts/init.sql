# ************************************************************
# Sequel Pro SQL dump
# Version 5428
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.13)
# Database: laravel-shop
# Generation Time: 2020-04-02 11:03:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account_withdraws
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account_withdraws`;

CREATE TABLE `account_withdraws` (
                                   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                   `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                   `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                   `user_id` int(11) NOT NULL,
                                   `amount` int(11) NOT NULL COMMENT '提现金额 单位分',
                                   `channel` tinyint(4) DEFAULT '1' COMMENT '提现方式',
                                   `status` tinyint(4) DEFAULT '0' COMMENT ' 状态 0 申请 1已处理 2提现失败',
                                   PRIMARY KEY (`id`),
                                   KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `account_withdraws` WRITE;
/*!40000 ALTER TABLE `account_withdraws` DISABLE KEYS */;

INSERT INTO `account_withdraws` (`id`, `created_at`, `updated_at`, `user_id`, `amount`, `channel`, `status`)
VALUES
(1,'2020-04-02 16:17:03','2020-04-02 16:17:03',1,143,1,0),
(3,'2020-04-02 18:15:09','2020-04-02 18:15:09',2,100,1,0);

/*!40000 ALTER TABLE `account_withdraws` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_menu`;

CREATE TABLE `admin_menu` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `parent_id` int(11) NOT NULL DEFAULT '0',
                            `order` int(11) NOT NULL DEFAULT '0',
                            `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`)
VALUES
(1,0,1,'首頁','fa-bar-chart','/',NULL,'2018-10-11 00:05:54'),
(2,0,6,'系統管理','fa-tasks',NULL,NULL,'2018-10-18 00:39:11'),
(3,2,7,'管理員','fa-users','auth/users',NULL,'2018-10-18 00:39:11'),
(4,2,8,'角色','fa-user','auth/roles',NULL,'2018-10-18 00:39:11'),
(5,2,9,'權限','fa-ban','auth/permissions',NULL,'2018-10-18 00:39:11'),
(6,2,10,'選單','fa-bars','auth/menu',NULL,'2018-10-18 00:39:11'),
(7,2,11,'操作日誌','fa-history','auth/logs',NULL,'2018-10-18 00:39:11'),
(8,0,2,'用戶管理','fa-users','/users','2018-10-11 00:42:51','2018-10-11 00:43:09'),
(9,0,3,'商品管理','fa-cubes','/products','2018-10-11 19:58:14','2018-10-11 19:58:27'),
(10,0,4,'訂單管理','fa-usd','/orders','2018-10-16 22:07:39','2018-10-16 22:07:49');

/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_operation_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_operation_log`;

CREATE TABLE `admin_operation_log` (
                                     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `user_id` int(11) NOT NULL,
                                     `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                     `created_at` timestamp NULL DEFAULT NULL,
                                     `updated_at` timestamp NULL DEFAULT NULL,
                                     PRIMARY KEY (`id`),
                                     KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_operation_log` WRITE;
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;

INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`)
VALUES
(1,1,'ls-admin','GET','127.0.0.1','[]','2020-04-01 10:21:20','2020-04-01 10:21:20'),
(2,1,'ls-admin','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:23','2020-04-01 10:21:23'),
(3,1,'ls-admin','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:25','2020-04-01 10:21:25'),
(4,1,'ls-admin/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:34','2020-04-01 10:21:34'),
(5,1,'ls-admin/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:41','2020-04-01 10:21:41'),
(6,1,'ls-admin/products','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:43','2020-04-01 10:21:43'),
(7,1,'ls-admin/users','GET','127.0.0.1','[]','2020-04-01 10:21:43','2020-04-01 10:21:43'),
(8,1,'ls-admin/orders','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:52','2020-04-01 10:21:52'),
(9,1,'ls-admin/users','GET','127.0.0.1','[]','2020-04-01 10:21:53','2020-04-01 10:21:53'),
(10,1,'ls-admin/auth/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:21:56','2020-04-01 10:21:56'),
(11,1,'ls-admin/auth/permissions','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:01','2020-04-01 10:22:01'),
(12,1,'ls-admin/auth/menu','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:05','2020-04-01 10:22:05'),
(13,1,'ls-admin/auth/permissions','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:09','2020-04-01 10:22:09'),
(14,1,'ls-admin/auth/roles','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:09','2020-04-01 10:22:09'),
(15,1,'ls-admin/auth/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:10','2020-04-01 10:22:10'),
(16,1,'ls-admin/auth/menu','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:11','2020-04-01 10:22:11'),
(17,1,'ls-admin/auth/permissions','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:12','2020-04-01 10:22:12'),
(18,1,'ls-admin/auth/roles','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:12','2020-04-01 10:22:12'),
(19,1,'ls-admin/auth/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:12','2020-04-01 10:22:12'),
(20,1,'ls-admin/products','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:13','2020-04-01 10:22:13'),
(21,1,'ls-admin/auth/users','GET','127.0.0.1','[]','2020-04-01 10:22:13','2020-04-01 10:22:13'),
(22,1,'ls-admin/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 10:22:28','2020-04-01 10:22:28'),
(23,1,'ls-admin/auth/logs','GET','127.0.0.1','[]','2020-04-01 16:56:51','2020-04-01 16:56:51'),
(24,1,'ls-admin/auth/menu','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:56:54','2020-04-01 16:56:54'),
(25,1,'ls-admin/auth/logs','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:56:56','2020-04-01 16:56:56'),
(26,1,'ls-admin/auth/logs','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:29','2020-04-01 16:58:29'),
(27,1,'ls-admin/auth/logs','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:31','2020-04-01 16:58:31'),
(28,1,'ls-admin/users','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:33','2020-04-01 16:58:33'),
(29,1,'ls-admin','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:35','2020-04-01 16:58:35'),
(30,1,'ls-admin/orders','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:36','2020-04-01 16:58:36'),
(31,1,'ls-admin','GET','127.0.0.1','[]','2020-04-01 16:58:36','2020-04-01 16:58:36'),
(32,1,'ls-admin/products','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 16:58:37','2020-04-01 16:58:37'),
(33,1,'ls-admin','GET','127.0.0.1','[]','2020-04-01 16:58:37','2020-04-01 16:58:37'),
(34,1,'ls-admin','GET','127.0.0.1','{\"_pjax\":\"#pjax-container\"}','2020-04-01 17:31:54','2020-04-01 17:31:54');

/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
                                   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                   `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                   `http_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `http_path` text COLLATE utf8mb4_unicode_ci,
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   `updated_at` timestamp NULL DEFAULT NULL,
                                   PRIMARY KEY (`id`),
                                   UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`)
VALUES
(1,'All permission','*','','*',NULL,NULL),
(2,'Dashboard','dashboard','GET','/',NULL,NULL),
(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),
(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),
(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),
(6,'用戶管理','users','','/users*','2018-10-11 00:50:33','2018-10-11 00:50:33'),
(7,'商品管理','products','','/products*','2018-10-18 03:01:36','2018-10-18 03:01:36'),
(8,'訂單管理','orders','','/orders*','2018-10-18 03:01:56','2018-10-18 03:01:56');

/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_role_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_role_menu`;

CREATE TABLE `admin_role_menu` (
                                 `role_id` int(11) NOT NULL,
                                 `menu_id` int(11) NOT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 `updated_at` timestamp NULL DEFAULT NULL,
                                 KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`)
VALUES
(1,2,NULL,NULL);

/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_role_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_role_permissions`;

CREATE TABLE `admin_role_permissions` (
                                        `role_id` int(11) NOT NULL,
                                        `permission_id` int(11) NOT NULL,
                                        `created_at` timestamp NULL DEFAULT NULL,
                                        `updated_at` timestamp NULL DEFAULT NULL,
                                        KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`)
VALUES
(1,1,NULL,NULL),
(2,2,NULL,NULL),
(2,3,NULL,NULL),
(2,4,NULL,NULL),
(2,6,NULL,NULL),
(2,7,NULL,NULL),
(2,8,NULL,NULL);

/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_role_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_role_users`;

CREATE TABLE `admin_role_users` (
                                  `role_id` int(11) NOT NULL,
                                  `user_id` int(11) NOT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`)
VALUES
(1,1,NULL,NULL),
(2,2,NULL,NULL);

/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
                             `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`)
VALUES
(1,'Administrator','administrator','2018-10-10 22:24:00','2018-10-10 22:24:00'),
(2,'運營','operator','2018-10-11 00:53:12','2018-10-11 00:53:12');

/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_user_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_user_permissions`;

CREATE TABLE `admin_user_permissions` (
                                        `user_id` int(11) NOT NULL,
                                        `permission_id` int(11) NOT NULL,
                                        `created_at` timestamp NULL DEFAULT NULL,
                                        `updated_at` timestamp NULL DEFAULT NULL,
                                        KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table admin_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
                             `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`)
VALUES
(1,'admin','$2y$10$Rqf.qkEI7kTrpGq616f/2O9dOOraUTLce91YWM0rHJOoT4X4CTRgq','管理員',NULL,'yrGNSYtY1HN1SipsoU7BDZrUfH7cQImkgMI7Q6qvP4y990qKhTK6MCQOCA2e','2018-10-10 22:24:00','2018-10-11 20:29:52'),
(2,'operator','$2y$10$2LqPBWDNnru8J5GmhwNEb.ZekAhg7OPJenhugJt1UrOeuLfyvcsKe','運營',NULL,'WYUWf8Zy95olghb8gcFWxnYfLeNuJspSUDRNL0jsiMjSK0oTLoIAwX7Ok8l2','2018-10-11 00:55:07','2018-10-11 00:55:07');

/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table benefits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `benefits`;

CREATE TABLE `benefits` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          `order_id` int(11) NOT NULL COMMENT '推广订单id',
                          `user_id` int(11) NOT NULL COMMENT '用户id',
                          `level_relation` varchar(255) NOT NULL COMMENT '用户层级关系',
                          `benefit` int(11) NOT NULL COMMENT '分润金额，单位分',
                          `type` tinyint(4) NOT NULL COMMENT '分润类型，1直接抽佣 2上级抽佣 3邀请抽佣',
                          PRIMARY KEY (`id`),
                          KEY `idx_user_id` (`user_id`),
                          KEY `idx_order_id` (`order_id`),
                          KEY `idx_level_relation` (`level_relation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='分润记录表';

LOCK TABLES `benefits` WRITE;
/*!40000 ALTER TABLE `benefits` DISABLE KEYS */;

INSERT INTO `benefits` (`id`, `created_at`, `updated_at`, `order_id`, `user_id`, `level_relation`, `benefit`, `type`)
VALUES
(6,'2020-04-01 12:49:11','2020-04-01 12:49:11',1,1,'0',30,1),
(8,'2020-04-01 13:10:21','2020-04-01 13:10:21',2,1,'0',11,2),
(9,'2020-04-01 13:10:21','2020-04-01 13:10:21',2,2,'1',207,1);

/*!40000 ALTER TABLE `benefits` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invite_promotion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invite_promotion`;

CREATE TABLE `invite_promotion` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                  `invite_uid` int(11) NOT NULL COMMENT '邀请人id',
                                  `user_id` int(11) NOT NULL COMMENT '用户id',
                                  `benefit` int(11) NOT NULL COMMENT '奖励金额，单位分',
                                  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
                                  PRIMARY KEY (`id`),
                                  KEY `idx_user_id` (`user_id`),
                                  KEY `idx_invite_uid` (`invite_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='邀请奖励记录表';

LOCK TABLES `invite_promotion` WRITE;
/*!40000 ALTER TABLE `invite_promotion` DISABLE KEYS */;

INSERT INTO `invite_promotion` (`id`, `created_at`, `updated_at`, `invite_uid`, `user_id`, `benefit`, `status`)
VALUES
(1,'2020-04-02 15:18:14','2020-04-02 15:18:14',2,1,100,1);

/*!40000 ALTER TABLE `invite_promotion` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `batch` int(11) NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
                                 `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `created_at` timestamp NULL DEFAULT NULL,
                                 KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table promote_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promote_orders`;

CREATE TABLE `promote_orders` (
                                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                `user_id` int(11) NOT NULL COMMENT '推广人id',
                                `goods_id` varchar(255) NOT NULL DEFAULT '' COMMENT '拼多多推广商品id',
                                `level_relation` varchar(255) NOT NULL COMMENT '用户层级关系',
                                `goods_name` varchar(255) NOT NULL COMMENT '商品名称',
                                `goods_price` int(11) NOT NULL DEFAULT '0' COMMENT '订单中sku的单件价格，单位为分',
                                `order_amount` int(11) DEFAULT '0' COMMENT '实际支付金额，单位为分',
                                `goods_quantity` int(11) DEFAULT '0' COMMENT '订单数量',
                                `order_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '拼多多订单号',
                                `order_create_time` timestamp NOT NULL COMMENT '订单生成时间',
                                `order_pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
                                `order_verify_time` timestamp NULL DEFAULT NULL COMMENT '审核时间',
                                `order_group_success_time` timestamp NULL DEFAULT NULL COMMENT '成团时间',
                                `order_receive_time` timestamp NULL DEFAULT NULL COMMENT '收货时间',
                                `order_modify_at` timestamp NOT NULL COMMENT '最后更新时间',
                                `order_settle_time` timestamp NULL DEFAULT NULL COMMENT '结算时间',
                                `batch_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '结算批次号',
                                `status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT ' -1 待支付; 0-已支付；1-已成团；2-确认收货；3-审核成功；4-审核失败（不可提现）；5-已经结算；8-非多多进宝商品（无佣金订单）',
                                `fail_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '订单审核失败原因',
                                `actual_promotion_amount` int(11) NOT NULL DEFAULT '0' COMMENT '拼多多佣金金额，单位为分',
                                `promotion_amount` int(11) NOT NULL DEFAULT '0' COMMENT '显示佣金金额，单位为分(拼多多佣金*百分比)',
                                `promotion_flag` int(11) NOT NULL DEFAULT '0' COMMENT '是否已计算抽佣',
                                `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图url',
                                PRIMARY KEY (`id`),
                                UNIQUE KEY `uqi_order_sn` (`order_sn`),
                                KEY `idx_level` (`level_relation`),
                                KEY `idx_user_id` (`user_id`),
                                KEY `idx_goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='拼多多推广订单';

LOCK TABLES `promote_orders` WRITE;
/*!40000 ALTER TABLE `promote_orders` DISABLE KEYS */;

INSERT INTO `promote_orders` (`id`, `created_at`, `updated_at`, `user_id`, `goods_id`, `level_relation`, `goods_name`, `goods_price`, `order_amount`, `goods_quantity`, `order_sn`, `order_create_time`, `order_pay_time`, `order_verify_time`, `order_group_success_time`, `order_receive_time`, `order_modify_at`, `order_settle_time`, `batch_no`, `status`, `fail_reason`, `actual_promotion_amount`, `promotion_amount`, `promotion_flag`, `image_url`)
VALUES
(1,'2020-04-01 12:47:26','2020-04-01 12:49:11',1,'96402131714','0','奥斯洁锡纸烤箱加厚锡箔铝箔纸烧烤肉厨房烤盘烘婴儿焙油纸硅油纸',490,290,1,'200401-044059198392800','2020-04-01 11:44:08','2020-04-01 11:44:14',NULL,'2020-04-01 11:44:15',NULL,'2020-04-01 11:44:23',NULL,NULL,1,'',61,30,1,'http://t00img.yangkeduo.com/goods/images/2020-03-27/1372eac1c0a3079feafd2afd22c175d9.jpeg'),
(2,'2020-04-01 13:09:56','2020-04-01 13:37:08',2,'115664267','1','【20支牙刷】成人竹炭软毛牙刷 细毛牙刷 家用套装',3090,1090,1,'200401-376551834412800','2020-04-01 13:09:30','2020-04-01 13:09:38',NULL,'2020-04-01 13:09:38',NULL,'2020-04-01 13:09:46',NULL,NULL,1,'',436,218,1,'http://t00img.yangkeduo.com/goods/images/2020-03-30/f80df967e287ef3a37e31e53b966fd61.jpeg'),
(5,'2020-04-01 13:46:32','2020-04-01 13:46:32',2,'5490891858','1','四川丑橘不知火10斤现摘现发新鲜丑八怪柑桔子水果2/5斤批发整箱',1680,1180,1,'200401-407095870352800','2020-04-01 13:39:57','2020-04-01 13:40:04',NULL,'2020-04-01 13:40:04',NULL,'2020-04-01 13:40:12',NULL,NULL,1,'',35,17,0,'http://t00img.yangkeduo.com/goods/images/2019-11-16/dfec75fe244396c72301a0da322b76a8.jpeg'),
(6,'2020-04-01 13:46:32','2020-04-02 18:55:37',2,'5490891858','1','测试数据',1680,1180,1,'200401-4070958703528010','2020-04-01 13:39:57','2020-04-01 13:40:04',NULL,'2020-04-01 13:40:04',NULL,'2020-04-01 13:40:12',NULL,NULL,1,'',35,17,0,'http://t00img.yangkeduo.com/goods/images/2019-11-16/dfec75fe244396c72301a0da322b76a8.jpeg');

/*!40000 ALTER TABLE `promote_orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table share_records
# ------------------------------------------------------------

DROP TABLE IF EXISTS `share_records`;

CREATE TABLE `share_records` (
                               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                               `user_id` int(11) NOT NULL COMMENT '用户id',
                               `goods_id` varchar(255) NOT NULL DEFAULT '' COMMENT '商品id',
                               `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '推广链接URL',
                               PRIMARY KEY (`id`),
                               KEY `idx_good_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='分享链接记录表';

LOCK TABLES `share_records` WRITE;
/*!40000 ALTER TABLE `share_records` DISABLE KEYS */;

INSERT INTO `share_records` (`id`, `created_at`, `updated_at`, `user_id`, `goods_id`, `link_url`)
VALUES
(1,'2020-03-30 21:36:19','2020-03-30 21:36:19',1,'98037368241','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=98037368241&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_b5665e58c54b028de98e903b4ae3c162&duoduo_type=2'),
(2,'2020-03-30 21:37:56','2020-03-30 21:37:56',1,'98037368241','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=98037368241&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_5cfcac33970cf700c5acf0e2ddc95d22&duoduo_type=2'),
(3,'2020-03-30 21:40:02','2020-03-30 21:40:02',1,'100237848247','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=100237848247&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_86c254abbed9fcf748269106eb865be3&duoduo_type=2'),
(4,'2020-03-30 21:40:23','2020-03-30 21:40:23',1,'100237848247','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=100237848247&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_f96c0702f0908e6ac4d6516d7a2b8860&duoduo_type=2'),
(5,'2020-03-30 21:41:35','2020-03-30 21:41:35',1,'100237848247','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=100237848247&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_51cb44646358f30d3fdc3d6f1c211dc4&duoduo_type=2'),
(6,'2020-03-30 21:42:15','2020-03-30 21:42:15',1,'100237848247','https://mobile.yangkeduo.com/duo_coupon_landing.html?goods_id=100237848247&pid=9696763_133721040&customParameters=0**1&cpsSign=CC_200330_9696763_133721040_752a843993794666982ae4c8a0bc992e&duoduo_type=2'),

/*!40000 ALTER TABLE `share_records` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
                       `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                       `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       `name` varchar(64) NOT NULL DEFAULT '' COMMENT '用户名/手机号码',
                       `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'email',
                       `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户密码',
                       `level_relation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' COMMENT '当前用户层级关系,用于计算佣金,例如1_2,目前只支持2层,则该值等价于parentId',
                       `remember_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT 'token',
                       `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '账号状态[0:封号,1:正常]',
                       `balance` int(11) NOT NULL DEFAULT '0' COMMENT '余额',
                       `invitation_code` varchar(50) DEFAULT '' COMMENT '邀请码',
                       PRIMARY KEY (`id`),
                       KEY `idx_invite` (`invitation_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户';

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `name`, `email`, `password`, `level_relation`, `remember_token`, `status`, `balance`, `invitation_code`)
VALUES
(1,'2020-03-30 21:14:41','2020-04-02 18:41:59','15177@qq.com','15177@qq.com','$2y$10$tR0gYP3mt7UIqFDuH1.F9.ehbrJJ8yLDVT908kaeb/RjFZ/Glz8P2','0','pNkiDP60JGE7rZpWFJJEISB5EUdkEeKITHmIAyRkkJUewtpw7tX8cNJJUptT',1,0,'3b1925d3e1d2576e725c8f6901117a2b'),
(2,'2020-04-01 12:57:52','2020-04-02 18:42:53','157@qq','157@qq.com','$2y$10$tR0gYP3mt7UIqFDuH1.F9.ehbrJJ8yLDVT908kaeb/RjFZ/Glz8P2','1','7GPrM7RM43bV5NWCuD3KjAfJE6XKQkEwny9fwHsey3hQrBlujLv7W0PUGoMI',1,107,'');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
