UPDATE `member` SET `username` = 'BDS Sari', `fullname` = 'BDS Sari', `password` = '35XainF4ywJyq92tUuWx', `email` = 'admin@sari.vn' WHERE `id` = 1;

ALTER TABLE `real_news` 
ADD COLUMN `member_id` int(0) UNSIGNED NULL DEFAULT NULL COMMENT 'thành viên gửi đăng bài' AFTER `acreage`;

-- 1 nhà có cả dịch vụ cho thuê, mua bán, cho thuê có giá theo giờ, ngày, tháng
ALTER TABLE `real_news` 
MODIFY COLUMN `service_type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '[]' COMMENT 'mua_ban, cho_thue' AFTER `content`,
MODIFY COLUMN `price` bigint(20) NULL DEFAULT NULL COMMENT 'giá bán' AFTER `status`,
ADD COLUMN `rent_price_hour` bigint(20) NULL DEFAULT NULL COMMENT 'giá thuê giờ' AFTER `price`,
ADD COLUMN `rent_price_day` bigint(20) NULL DEFAULT NULL COMMENT 'giá thuê ngày' AFTER `rent_price_hour`,
ADD COLUMN `rent_price_month` bigint(20) NULL DEFAULT NULL COMMENT 'giá thuê tháng' AFTER `rent_price_day`,
MODIFY COLUMN `rent_time` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '[]' COMMENT 'thời gian cho thuê: gio,ngay,thang' AFTER `thumbnail`;

ALTER TABLE `member_news` 
ADD COLUMN `session_id` varchar(250) NOT NULL AFTER `created_time`;

ALTER TABLE `real_news` 
ADD COLUMN `rent_enddate` date NULL COMMENT 'ngày kết thúc trạng thái thuê hiện tại' AFTER `member_id`;

ALTER TABLE `post_request` 
ADD COLUMN `details` longtext NULL AFTER `created_time`;

ALTER TABLE `post_request` 
ADD COLUMN `owner_phone` char(20) NULL AFTER `details`,
ADD COLUMN `owner_name` varchar(100) NULL AFTER `owner_phone`,
ADD COLUMN `address` varchar(255) NULL AFTER `owner_name`;

ALTER TABLE `real_news` 
ADD COLUMN `request_id` int(10) NULL COMMENT 'Mã yêu cầu đăng' AFTER `rent_enddate`;

ALTER TABLE `post_request` 
ADD COLUMN `realnews_id` int(10) NULL AFTER `address`;
