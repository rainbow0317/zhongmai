/* 1:06:08 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `promotion_amount`;
/* 1:06:12 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `promotion_flag`;
/* 1:06:17 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `level_relation`;
/* 1:07:43 PM local laravel-shop */ ALTER TABLE `benefits` CHANGE `status` `status` TINYINT(4)  NULL  DEFAULT '0'  COMMENT '收益状态 0待收 1已收';


/* 2:52:03 PM local laravel-shop */ ALTER TABLE `invite_promotion` CHANGE `status` `status` TINYINT(4)  NOT NULL  DEFAULT '0'  COMMENT '状态 0待收 1已收';
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`)
VALUES
	(6, 0, 6, '用户列表', 'fa-user', '/users', '2020-04-08 15:06:03', '2020-04-08 15:06:03');

	INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`)
VALUES
	(7, 0, 6, '文案产品列表', 'fa-bars', '/selects', '2020-04-08 15:06:03', '2020-04-08 15:06:03');

CREATE TABLE `select_records` (
                            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            `goods_id` varchar (255) NOT NULL DEFAULT '0',
                            `has_coupon` varchar (255) NOT NULL DEFAULT '0',
                            `coupon_discount` varchar (255) NOT NULL DEFAULT '0',
                            `sales_tip` varchar (255) NOT NULL DEFAULT '0',
                            `min_group_price` varchar (255) NOT NULL DEFAULT '0',
                            `search_id` varchar (255) NOT NULL DEFAULT '0',
                            `coupon_remain_quantity` varchar (255) NOT NULL DEFAULT '0',
                            `goods_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `goods_image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `mall_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `promotion_rate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,

                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

