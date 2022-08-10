<?php
namespace Apply\Controller;
class UserUpdate extends \Apply\Controller {
  public function run() {
    // フォーム送信されてきときに実行
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->updateUser();
    }
  }

  protected function updateUser() {
    try {
      $this->updateUservalidate();
    } catch (\Apply\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Apply\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    }
    // エラーが出ても入力された内容が消えない
    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Apply\Model\User();
          $userModel->update([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
          ]);
      }
      catch (\Apply\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    }
    $_SESSION['me']->username = $_POST['username'];
    header('Location: '. SITE_URL . '/mypage.php');
    exit();
  }

  

  // ユーザー登録のときと一緒
  private function updateUservalidate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
      throw new \Apply\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['username'] === '') {
      throw new \Apply\Exception\InvalidName("ユーザー名が入力されていません!");
    }
  }
}
