<?php

namespace Apply\Controller;

class UserDelete extends \Apply\Controller {
  public function run() {
    $user = new \Apply\Model\User();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('username', $userData->username);
    $this->setValues('email', $userData->email);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) == 'delete') {
      // バリデーション
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit;
      }

    $userModel = new \Apply\Model\User();
    $userModel->delete();

    $_SESSION = [];

    // Session＝ユーザー情報 を退会のときに破棄する
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 86400, '/');
    }

    // セッションの破棄
    // セッションハイジャック対策
    session_destroy();

    header('Location: ' . SITE_URL . '/index.php');
    exit();
    }
  }
}