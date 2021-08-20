<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

define('BASE_URL', "http://localhost/ofis/satis_takip2");
define('odeme_reel', 1);
define('PROGRAM_NAME', "ZİRVE SATIŞ TAKİP");
define('FİRMA_NAME', "Zirve Internet Yazılım Tasarım");
define('DOMAIN', "http://localhost/ofis/satis_takip");

//ÜYELİK VE KULLANICI İŞLEMLERİNDE ÖDEME YAPILACAK
//https://dev.iyzipay.com/tr/test-kartlari
// 10/20 , 123
/*
define('odeme_api', "sandbox-Ob4o46YkMlAqenETM75mlZx5EAH0lky9");
define('odeme_secret', "sandbox-IGJY0Tdh1HhLDAd4VstfsmNjNVqWxSmE");
define('odeme_base', "https://sandbox-api.iyzipay.com");
 */

define('odeme_api',"YJS6WaJxQKOGVpoMZryTk68KmNWmhSeS");
define('odeme_secret',"rU1jUL8qr7oAiTZQrGzKdfsESkeYzzd7");
define('odeme_base',"https://api.iyzipay.com");

define('odeme', APPPATH . 'libraries/iyzipay-php-master/samples/config.php');
define('form', APPPATH . 'libraries/iyzipay-php-master/samples/initialize_checkout_form.php');
define('donus', BASE_URL . '/odeme/odeme_al');

define('form2', APPPATH . 'libraries/iyzipay-php-master/samples/initialize_checkout_form_2.php');
define('donus2', BASE_URL . '/kullanici/odeme_al');
define('boot', APPPATH . 'libraries/iyzipay-php-master/IyzipayBootstrap.php');

//ÜYELİK VE KULLANICI İŞLEMLERİNDEN SONRA FATURA GÖNDERİLECEK
define('ork_musteri_no', 'zirveinternet');
define('ork_kullanici', 'zirveinternet');
define('ork_sifre', '958162');
define('ork_api', '93a1683d714b01643de1eca115ca3e5aab43be602f137a6f2a101dc05ffed49851e9607306d6685d8cfc33e9dc98866314b612a88e05c1899123eb5ea3fdcf1d62e3fdc1f5265b813c4da1cf203896c5ce4f369e716be911523cb2d29819a505f2db4e155fe65d4bbb2dbabfe8b29b5b13556856457e554b53e64e8e48f0be07c07bbd798998cc250b2a971307b038d0');
define('ork_portal', 'https://b2.orkestra.com.tr/efaturacim/servis.php');
// ork_portal için canlı url : https://efaturacim.orkestra.com.tr/servis.php

//Bunlara ek drive env url düzelt

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
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('zdrive_url', "http://localhost/otomasyon/bedrive");
