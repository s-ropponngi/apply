<?php
namespace Apply\Controller;
class Signup extends \Apply\Controller {
  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }
  protected function postProcess() {
    try {
      $this->validate();
    } catch (\Apply\Exception\InvalidEmail $e) {
        $this->setErrors('email', $e->getMessage());
    } catch (\Apply\Exception\InvalidName $e) {
        $this->setErrors('username', $e->getMessage());
    } catch (\Apply\Exception\InvalidPassword $e) {
        $this->setErrors('password', $e->getMessage());
    }
    $this->setValues('email', $_POST['email']);
    $this->setValues('username', $_POST['username']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Apply\Model\User();
        $user = $userModel->create([
          'email' => $_POST['email'],
          'username' => $_POST['username'],
          'password' => $_POST['password']
        ]);
      }
      catch (\Apply\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
      $userModel = new \Apply\Model\User();
      $user = $userModel->login([
        'email' => $_POST['email'],
        'password' => $_POST['password']
      ]);
      session_regenerate_id(true);
      $_SESSION['me'] = $user;
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }

    // ToDo:ユーザー登録後、ログイン処理を行う
  }

  // バリデーションメソッド
  private function validate() {
    // トークンが空またはPOST送信とセッションに格納された値が異なるとエラー
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
      echo "不正なフォームから登録されています!";
      exit();
    }
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
      throw new \Apply\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['username'] === '') {
      throw new \Apply\Exception\InvalidName("ユーザー名が入力されていません!");
    }
    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \Apply\Exception\InvalidPassword("パスワードが不正です!");
    }
  }
}