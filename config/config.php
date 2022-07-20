<?php
ini_set('display_errors',1);
define('DSN','mysql:host=localhost;charset=utf8;dbname=apply');
define('DB_USERNAME','apply_user');
define('DB_PASSWORD','w2T8PIFVUG8po53v');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/apply/public_html');
require_once(__DIR__ .'/../lib/Controller/functions.php');
require_once(__DIR__ . '/autoload.php');
session_start();

$current_uri =  $_SERVER["REQUEST_URI"];

$file_name = basename($current_uri);

if(strpos($file_name,'login.php') !== false || strpos($file_name,'signup.php') !== false || strpos($file_name,'index.php') !== false || strpos($file_name,'public_html') !== false) {
}
else {
  if(!isset($_SESSION['me'])){
    header('Location: ' . SITE_URL . '/login.php');
    exit();
  }
}