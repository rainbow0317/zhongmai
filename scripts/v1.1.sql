/* 1:06:08 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `promotion_amount`;
/* 1:06:12 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `promotion_flag`;
/* 1:06:17 PM local laravel-shop */ ALTER TABLE `promote_orders` DROP `level_relation`;
/* 1:07:43 PM local laravel-shop */ ALTER TABLE `benefits` CHANGE `status` `status` TINYINT(4)  NULL  DEFAULT '0'  COMMENT '收益状态 0待收 1已收';
