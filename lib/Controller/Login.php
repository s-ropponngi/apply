<?php
namespace Apply\Controller;
class Login extends \Apply\Controller {
  public function run() {
    // ログインしていればトップページへ移動
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
    } catch (\Apply\Exception\EmptyPost $e) {
        $this->setErrors('login', $e->getMessage());
    }
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Apply\Model\User();
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      }
      catch (\Apply\Exception\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      catch (\Apply\Exception\DeleteUser $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      // ログイン処理
      session_regenerate_id(true);
      // ユーザー情報をセッションに格納
      $_SESSION['me'] = $user;
      // スレッド一覧ページへリダイレクト
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }
  }
  private function validate() {
    // トークンが空またはPOST送信とセッションに格納された値が異なるとエラー
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが不正です!";
      exit();
    }
    // emailとpasswordのキーがなかった場合、強制終了
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "不正なフォームから登録されています!";
      exit();
    }
    if ($_POST['email'] === '' || $_POST['password'] === '') {
      throw new \Apply\Exception\EmptyPost("メールアドレスとパスワードを入力してください!");
    }
  }
}