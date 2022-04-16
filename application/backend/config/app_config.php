<?php 

$config['FB_APP_ID'] = '974871540070687';

$config['FB_APP_SECRET_KEY'] = '12ea4cc801151b62deeccff7586d1d34';

$config['main_domain'] = $_SERVER['REQUEST_SCHEME'] . '://' . str_replace('cms.', '', $_SERVER['HTTP_HOST']) . '/';

$config['domain'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';

$config['media_server'] = $config['main_domain'] . 'uploads/';

$config['media_uri'] = $config['main_domain'] . 'uploads/';

$config['upload_dir'] =  'uploads/';

$config['site_name'] = 'Vn-TS';

$config['site_title'] = 'Bất động sản SARI';

$config['model_product_prefix'] = '';

$config['admin_url'] = $config['domain'];

$config['out_of_stock_number'] = 2;

$config['page_display_number'] = 20;

$config['default_img'] = $config['domain'] . 'images/no-image.jpg';


$config['mentor_group'] = ['adviser','coach','mentor','lecturer', 'judge', 'trainer'];

$config['menuGroup'] = [
	1 => 'Main menu',
	2 => 'Footer menu',
	3 => 'Product menu',
	4 => 'Page menu',
];

$config['bannerGroup'] = [
	1 => 'Slider (1920x760)',
	// 2 => 'Accelerator Banner',
	// 3 => 'Partnership Circle-around (256x256)',
	// 4 => 'Content Banner',
	// 5 => 'Popup Banner',
	// 6 => 'Top Banner',
	// 7 => 'Supported By', 
	// 8 => 'Feedback Banner (1440x220)'
];

$config['user_levels'] = [
	1 => 'Admin',
	2 => 'Quản trị viên',
	// 3 => 'Trưởng mục',
	// 4 => 'Phóng viên',
	// 5 => 'Cộng tác viên',
];

$config['logEditNewsFile'] = 'thcl-log.txt';

/* === Setup auto create thumbnail === */
$config['auto_create_thumbnail'] = TRUE;
$config['thumbnail_width'] = 160;
$config['thumbnail_height'] = 120;

$config['auto_watermark'] = FALSE;
$config['watermark_text'] = 'gamerum.net';
$config['watermark_color'] = '008d4c';

$config['image_max_width'] = 800;
$config['image_max_height'] = 600;

//User Permission
$config['permission']['view'] = 1;
$config['permission']['add'] = 2;
$config['permission']['edit'] = 4;
$config['permission']['delete'] = 8;
$config['permission_user_level_1'] = 15;
$config['permission_user_level_2'] = 7;
$config['permission_user_level_3'] = 7;
$config['permission_user_level_4'] = 3;
$config['permission_user_level_5'] = 3;