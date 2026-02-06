<?php
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Kolkata'); 
$_SESSION['uid']='1';
$session_uid = $_SESSION['uid'];
define("SITE_KEY", "yoursitekey");
define("DB_PREFIX", "tbl_");
define("EXCELPATH", $_SERVER['DOCUMENT_ROOT'] . '/restful-demo/libs/helpers/PHPExcel_1.7.9_doc/Classes/');
define('UPLOADFILEPATH', $_SERVER['DOCUMENT_ROOT'] . '/demo/uploads/attendance_data/');
define('UPLOADPATH', $_SERVER['DOCUMENT_ROOT'] . '/restful-demo/uploads/');
define('IMGURL', "http://".$_SERVER['HTTP_HOST'] . '/restful-demo/restful/public/uploads/');
define("SITEURL", "http://" . $_SERVER['HTTP_HOST'] . '/restful-demo/');
define('UPLOADURL', SITEURL.'uploads/');
define('CONTROLLERPATH', 'Controllers/');
define('BASE', $_SERVER['DOCUMENT_ROOT']."/restful-demo/");
define("THEMEURL", SITEURL."views/basic/");
define("LIBS", $_SERVER['DOCUMENT_ROOT']."/restful-demo/libs/");
//Error codes
define('ERR_OK', 200);//ok
define('ERR_NO_DATA', 204);//No Data found
define('ERR_EXISTS', 208);//Already Exist
define('ERR_NON_AUTH', 203);//Non-Authoritative 
define('ERR_PARTIAL_CONT', 206);//Partial Content(required)
define('ERR_NOT_MODIFIED', 304);//Not Modified
// Settings
$settings = [];
// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';
// Error Handling Middleware settings
$settings['error'] = [
// Should be set to false in production
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => true,

];
function apiKey($session_uid){
    $key=md5(SITE_KEY.$session_uid);
    return hash('sha256', $key.$_SERVER['REMOTE_ADDR']);

}
function loadUtility($utility) {
    global $utilityClass;
    require_once 'Utilities/'.$utility.'.php';
    return new $utility;
}
$apiKey=apiKey($session_uid);
$settings['apiKey'] = $apiKey;
$settings['db'] = [

    'driver' => 'mysql',

    'host' => 'localhost',

    'username' => 'root',  

    'database' => 'demo',

    'password' => '',

    'charset' => 'utf8mb4',

    'collation' => 'utf8mb4_unicode_ci',

    'flags' => [

        // Turn off persistent connections

        PDO::ATTR_PERSISTENT => false,

        // Enable exceptions

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//ERRMODE_SILENT

        // Emulate prepared statements

        PDO::ATTR_EMULATE_PREPARES => true,

        // Set default fetch mode to array

        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

        // Set character set

        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'

    ],

];

return $settings;