<?php
namespace Apply\Controller;
class Thread extends \Apply\Controller {
  public function run() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ($_POST['type']  === 'createthread') {
        $this->createThread();
      } elseif($_POST['type']  === 'createcomment') {
        $this->createComment();
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

  public function outputCsv($thread_id){
    try {
      $threadModel = new \Apply\Model\Thread();
      $data = $threadModel->getCommentCsv($thread_id);
      $csv=array('num','username','content','date');
      $csv=mb_convert_encoding($csv,'SJIS-WIN','UTF-8');
      $date = date("YmdH:i:s");
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='. $date .'_thread.csv');
      $stream = fopen('php://output', 'w');
      stream_filter_prepend($stream,'convert.iconv.utf-8/cp932');
      $i = 0;
      foreach ($data as $row) {
        if($i === 0) {
          fputcsv($stream , $csv);
        }
        fputcsv($stream , $row);
        $i++;
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  private function validateSearch() {
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type'])) {
      if ($_GET['keyword'] === ''){
        throw new \Apply\Exception\EmptyPost("検索キーワードが入力されていません！");
      }
      if (mb_strlen($_GET['keyword']) > 20) {
        throw new \Apply\Exception\CharLength("キーワードが長すぎます！");
      }
    }
  }

  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['type'] === 'createthread') {
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
    //   if (=== 'noimage.jpg')
    // }

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