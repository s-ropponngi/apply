<?php
namespace Apply\Controller;
class Logout extends \Apply\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit();
      }
      $_SESSION = [];
      if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
      }
      // セッションの破棄(ログアウトのとき)
      session_destroy();
    }
    header('Location: ' . SITE_URL);
  }
}