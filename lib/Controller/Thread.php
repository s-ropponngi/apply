<?php
namespace Apply\Controller;
class Thread extends \Apply\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_POST['type'])){
        if ($_POST['type']  === 'createthread') {
          $this->createThread();
        } elseif($_POST['type']  === 'createcomment') {
          $this->createComment();
        } elseif($_POST['type']  === 'updatethread'){
          $this->updateThread();
        }
      }
    }
  }

  private function createThread(){
    try {
      $this->validate();
    } catch (\Apply\Exception\EmptyPost $e) {
        $this->setErrors('create_thread', $e->getMessage());
    } catch (\Apply\Exception\CharLength $e) {
        $this->setErrors('create_thread', $e->getMessage());
    }
    $this->setValues('thread_name', $_POST['thread_name']);
    $this->setValues('address_name', $_POST['address_name']);
    $this->setValues('due_date', $_POST['due_date']);
    $this->setValues('comment', $_POST['comment']);
    if ($this->hasError()){
      return;
    } else {
      $threadModel = new \Apply\Model\Thread();

      // 画像の編集(画像のリンク変更)
      $user_img = $_FILES['image'];
      $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
      $user_img['name'] = uniqid("img_") .'.'. $ext;

      $old_img = $_POST['old_image'];
      if($old_img == '') {
        $old_img = NULL;
      }
      try {
        $userModel = new \Apply\Model\Thread();
        // アップロードした画像があれば、gazouディレクトリにある古い画像を削除し、新しい画像を保存する。
        // アップロードされてきた画像があれば実行する
        if($user_img['size'] > 0) {
          // gazouフォルダーの中にある古い画像をフォルダから削除する
          unlink('./gazou/'.$old_img);
          // 新しい画像をgazouフォルダに移動
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
        }
      }catch(\Exception $e){
        return;
      }

    }
    $_SESSION['me']->username = $_POST['username'];


      // Model部分に渡すようにしている部分
      $threadModel->createThread([
        'image' => $user_img['name'],
        'title' => $_POST['thread_name'],
        'address' => $_POST['address_name'],
        'due_date' => $_POST['due_date'],
        'comment' => $_POST['comment'],
        'user_id' => $_SESSION['me']->id
      ]);
      header('Location: '. SITE_URL . '/index.php');
      exit();

  }

  protected function showUser() {
    $user = new \Apply\Model\Thread();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('image', $userData->image);
  }



  private function createComment() {
    try {
        $this->validate();
      } catch (\Apply\Exception\EmptyPost $e) {
          $this->setErrors('content', $e->getMessage());
      } catch (\Apply\Exception\CharLength $e) {
          $this->setErrors('content', $e->getMessage());
      }

      $this->setValues('content', $_POST['content']);
      if ($this->hasError()) {
        return;
      } else {
          $threadModel = new \Apply\Model\Thread();
          $threadModel->createComment([
            'thread_id' => $_POST['thread_id'],
            'user_id' => $_SESSION['me']->id,
            'content' => $_POST['content'],
          ]);
      }
      header('Location: '. SITE_URL . '/thread_disp.php?thread_id=' . $_POST['thread_id']);
      exit();
  }

  private function updateThread() {
    try {
      $this->validate();
      } catch (\Apply\Exception\EmptyPost $e) {
          $this->setErrors('update_thread', $e->getMessage());
      } catch (\Apply\Exception\CharLength $e) {
          $this->setErrors('update_thread', $e->getMessage());
      }
      $this->setValues('thread_name', $_POST['thread_name']);
      $this->setValues('address_name', $_POST['address_name']);
      $this->setValues('comment', $_POST['comment']);
    if ($this->hasError()){
      return;
    } else {
      $threadModel = new \Apply\Model\Thread();

      // 画像の編集(画像のリンク変更)
      $user_img = $_FILES['image'];
      $ext = substr($user_img['name'], strrpos($user_img['name'], '.') + 1);
      $user_img['name'] = uniqid("img_") .'.'. $ext;

      $old_img = (!empty($_POST['old_image']));
      if($old_img == '') {
        $old_img = NULL;
      }
      try {
        $userModel = new \Apply\Model\Thread();
        if($user_img['size'] > 0) {
          unlink('./gazou/'.$old_img);
          move_uploaded_file($user_img['tmp_name'],'./gazou/'.$user_img['name']);
        }
      }catch(\Exception $e){
        return;
      }

    }
    $_SESSION['me']->username = (!empty($_POST['username']));


      // Model部分に渡すようにしている部分
      $threadModel->updateThread([
        'image' => $user_img['name'],
        'title' => $_POST['thread_name'],
        'address' => $_POST['address_name'],
        'due_date' => $_POST['due_date'],
        'comment' => $_POST['comment'],
        'user_id' => $_SESSION['me']->id
      ]);
      header('Location: '. SITE_URL . '/index.php');
      exit();
    }

  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['type'] === 'createthread'||'updateThread') {
      if (!isset($_POST['thread_name']) || !isset($_POST['comment'])){
        echo '不正な投稿です';
        exit();
      }
      if ( $_FILES['image']['type'] === ''|| $_POST['thread_name'] === '' || $_POST['comment'] === ''|| $_POST['address_name'] === ''|| $_POST['due_date'] === ''){
        throw new \Apply\Exception\EmptyPost("全て入力してください！");
      }

      if (mb_strlen($_POST['comment']) > 200) {
        throw new \Apply\Exception\CharLength("コメントが長すぎます！");
      }

      if($_POST['type'] === 'createcomment') {
        if (!isset($_POST['content'])){
          echo '不正な投稿です';
          exit();
        }

      if($_POST['content'] === '') {
        throw new \Apply\Exception\EmptyPost("コメントが入力されていません！");
      }
    }
  }
}
}