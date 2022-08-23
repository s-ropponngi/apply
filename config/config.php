<?php
ini_set('display_errors',1);
define('DSN','mysql:host=us-cdbr-east-06.cleardb.net;charset=utf8;dbname=heroku_c9e1ae2759f6c1e');
define('DB_USERNAME','b3df6f381eee25');
define('DB_PASSWORD','8872b555');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
require_once(__DIR__ .'/../lib/Controller/functions.php');
// require_once(__DIR__ . '/autoload.php');
session_start();

$current_uri = 'http://' . $_SERVER["REQUEST_URI"];

$file_name = basename($current_uri);

if(strpos($file_name,'login.php') !== false || strpos($file_name,'signup.php') !== false || strpos($file_name,'index.php') !== false || strpos($file_name,'public_html') !== false || strpos($file_name,'ajax.php') !== false) {
}
else {
  if(!isset($_SESSION['me'])){
    header('Location: ' . SITE_URL . '/login.php');
    exit();
  }
}