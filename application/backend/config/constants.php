<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
Define Error Message
*/
/*defined('ERROR_URL_INVALID','Lỗi! Đường dẫn không hợp lệ');
defined('SUBMIT_OK','Thành công! Đã cập nhật dữ liệu mới');
defined('SUBMIT_FAILE','Lỗi! Không thể cập nhật dữ liệu');
*/
defined('FAILE_LOGIN_TIME') OR define('FAILE_LOGIN_TIME', 5);

// require_once('app_constant.php');


defined('STATUS_SALARY_PAID') OR define('STATUS_SALARY_PAID', 1);
defined('STATUS_SALARY_WAITING') OR define('STATUS_SALARY_WAITING', 2);
defined('STATUS_SALARY_NOT_PAID') OR define('STATUS_SALARY_NOT_PAID', 3);

defined('START_COUNTER') OR define('START_COUNTER', 0);
defined('AUTHOR_ID') OR define('AUTHOR_ID', 28);
defined('OFFSET') OR define('OFFSET', 0);
defined('LIMIT') OR define('LIMIT', 20);

defined('STATUS_PUBLISHED') OR define('STATUS_PUBLISHED', 1);
defined('STATUS_PENDING') OR define('STATUS_PENDING', 2);
defined('STATUS_DELETED') OR define('STATUS_DELETED', 3);
defined('STATUS_WRITING') OR define('STATUS_WRITING', 4);
defined('STATUS_COMEBACK') OR define('STATUS_COMEBACK', 5);

defined('DAY_OF_COUNTER') OR define('DAY_OF_COUNTER', 7);
defined('COUNTER_CIRCEL') OR define('COUNTER_CIRCEL', 5);
defined('COUNTER_DELAY') OR define('COUNTER_DELAY', 6);
defined('END_DAY_OF_MONTH') OR define('END_DAY_OF_MONTH', 20);

// Banner group
defined('BANNER_SIDEBAR_HCM_TOP') OR define('BANNER_SIDEBAR_HCM_TOP', 11);

defined('BANNER_SIDEBAR_HCM_MID') OR define('BANNER_SIDEBAR_HCM_MID', 22);

defined('BANNER_SIDEBAR_HCM_BOT') OR define('BANNER_SIDEBAR_HCM_BOT', 33);

defined('BANNER_HEADER_HCM') OR define('BANNER_HEADER_HCM', 44);

defined('BANNER_AFTER_MENU_HCM') OR define('BANNER_AFTER_MENU_HCM', 55);

defined('BANNER_MID_ARTICLE_HCM') OR define('BANNER_MID_ARTICLE_HCM', 66);

// image size
defined('COVER_IMAGE_SIZE') OR define('COVER_IMAGE_SIZE', '1600x500');

defined('THUMBNAIL_SIZE_PRODUCT') OR define('THUMBNAIL_SIZE_PRODUCT', '1200x1200');

defined('THUMBNAIL_SIZE_LOCATION') OR define('THUMBNAIL_SIZE_LOCATION', '1600x500');

defined('PRODUCT_IMAGE_SIZE') OR define('PRODUCT_IMAGE_SIZE', '800x450');

defined('MENTOR_AVATAR') OR define('MENTOR_AVATAR', '280x280');

defined('PARTNER_LOGO_TRANSPARENT') OR define('PARTNER_LOGO_TRANSPARENT', '130x50');

defined('PARTNER_LOGO') OR define('PARTNER_LOGO', '130x50');

defined('GG_RECAPTCHA_SITE_KEY') OR define('GG_RECAPTCHA_SITE_KEY', '6LfkzaMUAAAAAOFqygZZ42AhNEXFZohFXcqNKQG-');

defined('GG_RECAPTCHA_SECRET_KEY') OR define('GG_RECAPTCHA_SECRET_KEY', '6LfkzaMUAAAAACX-j7Rv_EDoLPQqnXZ2HQAyDiFl');

defined('TYDONG') OR define('TYDONG', 1000000000);

defined('TRIEUDONG') OR define('TRIEUDONG', 1000000);