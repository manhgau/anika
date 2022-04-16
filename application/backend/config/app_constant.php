<?php
defined('BUSSINESS_ENCRYPT_KEY')    or define('BUSSINESS_ENCRYPT_KEY', '2Hon0DwJpI0x');
defined('LIMIT')    				or define('LIMIT', 20);
defined('OFFSET')    				or define('OFFSET', 0);

defined('STATUS_PUBLISHED')    		or define('STATUS_PUBLISHED', 1);
defined('STATUS_PENDING')    		or define('STATUS_PENDING', 2);
defined('STATUS_DELETED')    		or define('STATUS_DELETED', 3);
defined('STATUS_DRAFF') 			OR define('STATUS_DRAFF', 4);
defined('STATUS_BANNED') 			OR define('STATUS_BANNED', 5);

// Product types
defined('PRODUCT_TOUR') OR define('PRODUCT_TOUR', 1);
defined('PRODUCT_TRANSFER') OR define('PRODUCT_TRANSFER', 2);
defined('PRODUCT_STAY') OR define('PRODUCT_STAY', 3);
defined('PRODUCT_RESTAURANT') OR define('PRODUCT_RESTAURANT', 4);
defined('PRODUCT_TYPE') OR define('PRODUCT_TYPE', 'tour,transfer,stay,restaurant');

// options defined
// defined('HOT_TOUR_CFG') 			OR define('HOT_TOUR_CFG', 'hot_tours');
defined('HOT_TOUR_CFG') 			OR define('HOT_TOUR_CFG', 'home_feature');
defined('HOT_TRANSFER_CFG') 		OR define('HOT_TRANSFER_CFG', 'hot_transfer');
defined('HOT_STAY_CFG') 			OR define('HOT_STAY_CFG', 'hot_stay');
defined('HOT_DESTINATION_CFG') 		OR define('HOT_DESTINATION_CFG', 'hot_destination');

// Banner
defined('BANNER_SLIDER') 			OR define('BANNER_SLIDER', 1);
defined('BANNER_SIDEBAR') 			OR define('BANNER_SIDEBAR', 2);

// PRODUCT TYPE CATEGORY
defined('TOUR_CATEGORY') OR define('TOUR_CATEGORY', 1);
defined('STAY_CATEGORY') OR define('STAY_CATEGORY', 2);
defined('TRANSFER_CATEGORY') OR define('TRANSFER_CATEGORY', 3);
defined('RESTAURANT_CATEGORY') OR define('RESTAURANT_CATEGORY', 20);
defined('TIMEOUTMIN') OR define('TIMEOUTMIN', 60);
defined('OG_IMAGE_SIZE') OR define('OG_IMAGE_SIZE', '600x315');

defined('POINT_MASTER_ID') OR define('POINT_MASTER_ID', 1);