<?php
namespace Apply\Controller;
class UserUpdate extends \Apply\Controller {
  public function run() {
    // マイページに今ログインしているユーザーの情報を反映させる
    $this->showUser();
    // フォーム送信されてきときに実行
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // updateUser()が動く
      $this->updateUser();
    }
  }

  protected function updateUser() {
    try {
      $this->validate();
    } catch (\Apply\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Apply\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    }
    // エラーが出ても入力された内容が消えない
    $this->setValues('title', $_POST['thread_name']);
    $this->setValues('address', $_POST['address_name']);
    $this->setValues('due_date', $_POST['due_date']);
    $this->setValues('comment', $_POST['comment']);
    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      // データベースに保存する画像の情報を作っている場所
      // グローバル変数$_FILESを使い、アップロードした画像情報を取得する
      $user_img = $_FILES['image'];
      // 変更前の画像情報を取得する(マイページからフォーム送信されてくるもの)
      $old_img = $_POST['old_image'];
      if($old_img == '') {
        $old_img = NULL;
      }
      // アップロードした画像ファイルのファイル名を取得し、プログラムで名前を変えている(絶対に被らないユニークなものにしている)
      $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
      $user_img['name'] = uniqid("img_") .'.'. $ext;
      try {
        $userModel = new \Apply\Model\User();
        // アップロードした画像があれば、gazouディレクトリにある古い画像を削除し、新しい画像を保存する。
        // アップロードされてきた画像があれば実行する
        if($user_img['size'] > 0) {
          // gazouフォルダーの中にある古い画像をフォルダから削除する
          unlink('./gazou/'.$old_img);
          // 新しい画像をgazouフォルダに移動
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
          // データベースに保存
          $userModel->update([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'userimg' => $user_img['name']
          ]);
          $_SESSION['me']->image = $user_img['name'];
          // 画像の変更をしないとき
        } else {
          $userModel->update([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            // 今まで使っていた画像をupdate
            'userimg' => $old_img
          ]);
          $_SESSION['me']->image = $old_img;
        }
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
  private function validate() {
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
