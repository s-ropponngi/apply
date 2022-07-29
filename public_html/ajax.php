<?php
require_once(__DIR__ .'/../config/config.php');

$threadApp = new \Apply\Model\Thread();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $res = $threadApp->searchThread([
      'title' => $_POST['title'],
      'address' => $_POST['address']
    ]);
    header('Content-Type: application/json');
    echo json_encode($res);
  } catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL']. '500 Internal Server Error', true, 500);
    echo $e->getMessage();
  }
}

