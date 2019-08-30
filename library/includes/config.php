<?php
session_start();
define('SITEFOLDER', '');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'].SITEFOLDER);
$scheme=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://';
$site_url=$scheme.$_SERVER['HTTP_HOST'].SITEFOLDER;
$site_url_absolute=empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on")? "https://".$_SERVER['HTTP_HOST'] : "http://".$_SERVER['HTTP_HOST'];
define("SITE_URL",$site_url);

define("SITE_URL_AB",$site_url_absolute);

define("DASHBOARD_URL",$site_url_absolute.'/dashboard');

define("DOCUMENTROOT",$_SERVER['DOCUMENT_ROOT'].SITEFOLDER);

define("ASSETS", SITE_URL.'/library/assets');

define("CLASSES", DOCUMENTROOT.'/library/classes');

define("INC", DOCUMENTROOT.'/library/includes');

define("INSTALL", DOCUMENTROOT.'/library/install');

define("AJAX", SITE_URL.'/library/ajax');

define("AJAX_ABS", DOCUMENTROOT.'/library/ajax');
define('DATABASE', 'was');
define('SALT', 'SHYWbbMImqKeVpQoMeUnfwZJIyMBwono'); //Do not Change this value
define('TimeZone','Asia/Kolkata'); //Change Time Zone Here
define("CIPHER_METHOD",'DES-EDE3-CFB8');
define("FROM_EMAIL","no-reply@was.com");

define("META_TITLE","WAS");
?>
