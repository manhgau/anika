CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `slugname` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `content` longtext NOT NULL,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `meta_keyword` varchar(250) DEFAULT NULL,
  `tags_id` varchar(100) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `public_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  `thumbnail` varchar(250) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `hit_view` int(11) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `relate_news` varchar(200) DEFAULT NULL,
  `source` varchar(250) DEFAULT NULL,
  `source_url` varchar(250) DEFAULT NULL,
  `display_author` tinyint(1) DEFAULT '1',
  `display_ads_box` tinyint(1) DEFAULT '1',
  `highlight_image` varchar(250) DEFAULT NULL,
  `highlight_alt` varchar(250) DEFAULT NULL,
  `source_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id` (`id`) USING BTREE,
  KEY `public_time` (`public_time`) USING BTREE,
  KEY `category` (`category`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slugname` varchar(100) NOT NULL,
  `description` text,
  `status` int(1) DEFAULT '1',
  `parent_id` int(11) NOT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `meta_keyword` varchar(250) DEFAULT NULL,
  `meta_title` varchar(250) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE `category_news` (
  `news_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`news_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `slugname` varchar(250) NOT NULL,
  `intro` varchar(250) DEFAULT NULL,
  `description` text,
  `begin_time` int(15) DEFAULT NULL,
  `create_time` int(15) NOT NULL,
  `update_time` int(15) DEFAULT NULL,
  `create_by` int(11) NOT NULL,
  `location` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '2',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(250) NOT NULL,
  `meta_keyword` varchar(250) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `thumbnail` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `event_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `news_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `note` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `view_count` int(11) NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6980 DEFAULT CHARSET=utf8;

CREATE TABLE `news_type` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slugname` varchar(200) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `view_money` varchar(255) DEFAULT NULL,
  `fixed_money` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;